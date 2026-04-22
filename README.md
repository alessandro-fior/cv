# CV Projects

Repository con piu' versioni del CV:

- `static`: CV in HTML/CSS puro
- `readonly`: CV in PHP che legge dati da SQLite
- `admin`: CV in PHP con pannello `admin.php` per gestire skill, aziende ed esperienze
- `python-simple`: CV in Python con server leggero e SQLite

Percorsi progetto:

- `C:\cv\cv\static`
- `C:\cv\cv\readonly`
- `C:\cv\cv\admin`
- `C:\cv\cv\python-simple`

Database SQLite:

- file sorgente nel repository:
  - `C:\cv\cv\readonly\data\cv.sqlite`
  - `C:\cv\cv\admin\data\cv.sqlite`
  - `C:\cv\cv\python-simple\data\cv.sqlite`
- copia runtime scrivibile generata automaticamente dai progetti PHP:
  - `%LOCALAPPDATA%\cv-projects\readonly\cv.sqlite`
  - `%LOCALAPPDATA%\cv-projects\admin\cv.sqlite`

Prerequisiti PHP:

- `pdo_sqlite` abilitato
- `sqlite3` abilitato

Per avviare i progetti PHP:

```powershell
cd C:\cv\cv\readonly
php -S localhost:8000
```

```powershell
cd C:\cv\cv\admin
php -S localhost:8001
```

URL:

- `readonly`: http://127.0.0.1:8000
- `admin`: http://127.0.0.1:8001

Se il comando `php` non viene riconosciuto in un terminale gia' aperto, chiudi e riapri la shell.
