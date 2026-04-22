from __future__ import annotations

import html
import sqlite3
from http.server import BaseHTTPRequestHandler, ThreadingHTTPServer
from pathlib import Path
from urllib.parse import unquote


BASE_DIR = Path(__file__).resolve().parent
DB_PATH = BASE_DIR / "data" / "cv.sqlite"


def fetch_all(query: str) -> list[sqlite3.Row]:
    with sqlite3.connect(DB_PATH) as conn:
        conn.row_factory = sqlite3.Row
        return conn.execute(query).fetchall()


def fetch_one(query: str) -> sqlite3.Row | None:
    rows = fetch_all(query)
    return rows[0] if rows else None


def render_cv() -> str:
    profile = fetch_one("SELECT * FROM profile WHERE id = 1")
    contacts = fetch_all("SELECT * FROM contacts ORDER BY sort_order, id")
    languages = fetch_all("SELECT * FROM languages ORDER BY sort_order, id")
    availability = fetch_all("SELECT * FROM availability ORDER BY sort_order, id")
    skills = fetch_all("SELECT * FROM skills ORDER BY sort_order, id")
    experiences = fetch_all(
        """
        SELECT e.*, c.name AS company_name, c.location
        FROM experiences e
        INNER JOIN companies c ON c.id = e.company_id
        ORDER BY e.sort_order, e.id
        """
    )
    education = fetch_all("SELECT * FROM education ORDER BY sort_order, id")

    def esc(value: object) -> str:
        return html.escape("" if value is None else str(value))

    def render_list(items: list[sqlite3.Row], template: str) -> str:
        return "\n".join(template.format(item=item, esc=esc) for item in items)

    return f"""<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CV {esc(profile['full_name'] if profile else 'Curriculum')}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/styles.css">
</head>
<body>
  <main class="page">
    <aside class="sidebar">
      <div class="photo-lockup">
        <div class="photo-ring">
          <img class="profile-photo" src="/assets/profile-from-pdf.jpg" alt="Foto profilo Alessandro Fior">
        </div>
      </div>

      <section class="side-section">
        <h2 class="section-title">Contatti</h2>
        <ul class="contact-list">
          {render_list(contacts, '<li><span class="label">{esc(item["label"])}:</span> {esc(item["value"])}</li>')}
        </ul>
      </section>

      <section class="side-section">
        <h2 class="section-title">Lingue</h2>
        <ul class="simple-list">
          {render_list(languages, '<li>{esc(item["name"])}: {esc(item["level"])}</li>')}
        </ul>
      </section>

      <section class="side-section">
        <h2 class="section-title">Disponibilita'</h2>
        <ul class="bullet-list">
          {render_list(availability, '<li>{esc(item["description"])}</li>')}
        </ul>
      </section>

      <section class="side-section">
        <h2 class="section-title">Competenze</h2>
        <ul class="bullet-list compact">
          {render_list(skills, '<li>{esc(item["name"])}</li>')}
        </ul>
      </section>
    </aside>

    <section class="content">
      <header class="hero">
        <div class="hero-text">
          <h1>{esc(profile['full_name'] if profile else '')}</h1>
          <p class="role">{esc(profile['headline'] if profile else '')}</p>
        </div>
      </header>

      <section class="content-section profile-section">
        <h2 class="section-title">Profilo</h2>
        <p>{esc(profile['summary'] if profile else '')}</p>
      </section>

      <section class="content-section">
        <h2 class="section-title">Esperienze Lavorative</h2>
        {"".join(
            f'''
        <article class="experience-item">
          <h3>{esc(item["role"])}</h3>
          <p class="experience-meta"><strong>{esc(item["company_name"])}</strong>, {esc(item["location"])} - <span class="date-range">{esc(item["start_label"])} - {esc(item["end_label"])}</span></p>
        </article>'''
            for item in experiences
        )}
      </section>

      <section class="content-section education-section">
        <h2 class="section-title">Formazione</h2>
        {"".join(
            f'''
        <article class="education-item">
          <h3>{esc(item["title"])}</h3>
          <p>{esc(item["institution"])} | {esc(item["year_label"])}</p>
        </article>'''
            for item in education
        )}
      </section>

      <footer class="footer">
        <p>
          Autorizzo il trattamento dei miei dati personali presenti nel CV ai sensi del Decreto Legislativo
          30 giugno 2003, n. 196 "Codice in materia di protezione dei dati personali" e dell'art. 13 del GDPR
          (Regolamento UE 2016/679).
        </p>
        <div class="signature-row">
          <span>{esc(profile['signature_city'] if profile else '')}, {esc(profile['signature_date'] if profile else '')}</span>
          <span>{esc(profile['full_name'] if profile else '')}</span>
        </div>
      </footer>
    </section>
  </main>
</body>
</html>"""


class CvRequestHandler(BaseHTTPRequestHandler):
    def do_GET(self) -> None:
        raw_path = self.path.split("?", 1)[0]
        path = unquote(raw_path)

        if path in {"/", "/index.html"}:
            content = render_cv().encode("utf-8")
            self.send_response(200)
            self.send_header("Content-Type", "text/html; charset=utf-8")
            self.send_header("Content-Length", str(len(content)))
            self.end_headers()
            self.wfile.write(content)
            return

        if path == "/styles.css":
            self.serve_file(BASE_DIR / "styles.css", "text/css; charset=utf-8")
            return

        if path.startswith("/assets/"):
            self.serve_file(BASE_DIR / path.lstrip("/"), "image/jpeg")
            return

        self.send_error(404, "Pagina non trovata")

    def serve_file(self, file_path: Path, content_type: str) -> None:
        if not file_path.exists():
            self.send_error(404, "File non trovato")
            return

        payload = file_path.read_bytes()
        self.send_response(200)
        self.send_header("Content-Type", content_type)
        self.send_header("Content-Length", str(len(payload)))
        self.end_headers()
        self.wfile.write(payload)

    def log_message(self, format: str, *args: object) -> None:
        return


if __name__ == "__main__":
    host = "127.0.0.1"
    port = 8010
    print(f"CV Python disponibile su http://{host}:{port}")
    ThreadingHTTPServer((host, port), CvRequestHandler).serve_forever()
