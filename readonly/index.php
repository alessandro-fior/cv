<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

$profile = fetchOne('SELECT * FROM profile WHERE id = 1');
$contacts = fetchAllRows('SELECT * FROM contacts ORDER BY sort_order, id');
$languages = fetchAllRows('SELECT * FROM languages ORDER BY sort_order, id');
$availability = fetchAllRows('SELECT * FROM availability ORDER BY sort_order, id');
$skills = fetchAllRows('SELECT * FROM skills ORDER BY sort_order, id');
$experiences = fetchAllRows(
    'SELECT e.*, c.name AS company_name, c.location
     FROM experiences e
     INNER JOIN companies c ON c.id = e.company_id
     ORDER BY e.sort_order, e.id'
);
$education = fetchAllRows('SELECT * FROM education ORDER BY sort_order, id');
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CV <?= htmlspecialchars($profile['full_name'] ?? 'Curriculum') ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <main class="page">
    <aside class="sidebar">
      <div class="photo-lockup">
        <div class="photo-ring">
          <img class="profile-photo" src="<?= htmlspecialchars($profile['photo_path'] ?? 'assets/profile-from-pdf.jpg') ?>" alt="Foto profilo">
        </div>
      </div>

      <section class="side-section">
        <h2 class="section-title">Contatti</h2>
        <ul class="contact-list">
          <?php foreach ($contacts as $contact): ?>
            <li>
              <span class="label"><?= htmlspecialchars($contact['label']) ?>:</span>
              <span><?= htmlspecialchars($contact['value']) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </section>

      <section class="side-section">
        <h2 class="section-title">Lingue</h2>
        <ul class="simple-list">
          <?php foreach ($languages as $language): ?>
            <li><?= htmlspecialchars($language['name']) ?>: <?= htmlspecialchars($language['level']) ?></li>
          <?php endforeach; ?>
        </ul>
      </section>

      <section class="side-section">
        <h2 class="section-title">Disponibilita'</h2>
        <ul class="bullet-list">
          <?php foreach ($availability as $item): ?>
            <li><?= htmlspecialchars($item['description']) ?></li>
          <?php endforeach; ?>
        </ul>
      </section>

      <section class="side-section">
        <h2 class="section-title">Competenze</h2>
        <ul class="bullet-list compact">
          <?php foreach ($skills as $skill): ?>
            <li><?= htmlspecialchars($skill['name']) ?></li>
          <?php endforeach; ?>
        </ul>
      </section>
    </aside>

    <section class="content">
      <header class="hero">
        <div class="hero-text">
          <h1><?= htmlspecialchars($profile['full_name'] ?? '') ?></h1>
          <p class="role"><?= htmlspecialchars($profile['headline'] ?? '') ?></p>
        </div>
      </header>

      <section class="content-section profile-section">
        <h2 class="section-title">Profilo</h2>
        <p><?= htmlspecialchars($profile['summary'] ?? '') ?></p>
      </section>

      <section class="content-section">
        <h2 class="section-title">Esperienze Lavorative</h2>
        <?php foreach ($experiences as $experience): ?>
          <article class="experience-item">
            <h3><?= htmlspecialchars($experience['role']) ?></h3>
            <p class="experience-meta">
              <strong><?= htmlspecialchars($experience['company_name']) ?></strong>,
              <?= htmlspecialchars($experience['location']) ?>
              - <span class="date-range"><?= htmlspecialchars($experience['start_label']) ?> - <?= htmlspecialchars($experience['end_label']) ?></span>
            </p>
          </article>
        <?php endforeach; ?>
      </section>

      <section class="content-section education-section">
        <h2 class="section-title">Formazione</h2>
        <?php foreach ($education as $item): ?>
          <article class="education-item">
            <h3><?= htmlspecialchars($item['title']) ?></h3>
            <p><?= htmlspecialchars($item['institution']) ?> | <?= htmlspecialchars($item['year_label']) ?></p>
          </article>
        <?php endforeach; ?>
      </section>

      <footer class="footer">
        <p>
          Autorizzo il trattamento dei miei dati personali presenti nel CV ai sensi del
          Decreto Legislativo 30 giugno 2003, n. 196 "Codice in materia di protezione dei dati
          personali" e dell'art. 13 del GDPR (Regolamento UE 2016/679).
        </p>
        <div class="signature-row">
          <span><?= htmlspecialchars(($profile['signature_city'] ?? '') . ', ' . ($profile['signature_date'] ?? '')) ?></span>
          <span><?= htmlspecialchars($profile['full_name'] ?? '') ?></span>
        </div>
      </footer>
    </section>
  </main>
</body>
</html>
