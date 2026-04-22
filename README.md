# CV Projects

Cartella organizzata in due progetti separati:

- `static`: CV in HTML/CSS puro
- `readonly`: CV in PHP che legge i dati da `data/cv.sqlite`
- `admin`: CV in PHP con pannello `admin.php` per gestire skill, aziende ed esperienze
- `python-simple`: CV in Python con server leggero e SQLite

Programmi installati:

- PHP 8.3 in `C:\tools\php83\php.exe`
- DB Browser for SQLite in `C:\Program Files\DB Browser for SQLite\DB Browser for SQLite.exe`
- SQLiteStudio in `C:\Program Files\SQLiteStudio\SQLiteStudio.exe`

Database SQLite:

- `C:\cv\readonly\data\cv.sqlite`
- `C:\cv\admin\data\cv.sqlite`

Per gestire il database con un tool esterno puoi usare:

- DB Browser for SQLite
- SQLiteStudio

Per avviare i progetti con PHP, quando hai `php.exe` disponibile:

```powershell
cd C:\cv\readonly
php -S localhost:8000
```

```powershell
cd C:\cv\admin
php -S localhost:8001
```

In alternativa puoi usare direttamente:

- `C:\cv\start-readonly-php.bat`
- `C:\cv\start-admin-php.bat`

URL:

- `readonly`: http://127.0.0.1:8000
- `admin`: http://127.0.0.1:8001

Come modificare il database:

1. Apri `DB Browser for SQLite` oppure `SQLiteStudio`
2. Apri uno di questi file:
   `C:\cv\readonly\data\cv.sqlite`
   `C:\cv\admin\data\cv.sqlite`
   `C:\cv\python-simple\data\cv.sqlite`
3. Vai nella tabella che ti interessa:
   `skills` per le competenze
   `companies` per le aziende
   `experiences` per le esperienze lavorative
   `profile` per nome, titolo, testo profilo, firma
4. Modifica o inserisci le righe
5. Salva le modifiche
6. Ricarica la pagina del progetto nel browser

Nota:

- `experiences.company_id` deve puntare all`id` della tabella `companies`
- il campo `sort_order` controlla l'ordine di visualizzazione
- se il comando `php` non viene riconosciuto in un terminale gia' aperto, chiudi e riapri il prompt
"# cv" 
