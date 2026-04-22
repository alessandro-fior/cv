# CV Projects

Cartella organizzata in due progetti separati:

- `readonly`: CV in PHP che legge i dati da `data/cv.sqlite`
- `admin`: CV in PHP con pannello `admin.php` per gestire skill, aziende ed esperienze

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
"# cv" 
