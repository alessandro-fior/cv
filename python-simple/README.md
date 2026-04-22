# Python Simple CV

Versione Python minimale e separata da quelle PHP.

Contenuto:

- `server.py`: piccolo server HTTP con sola libreria standard Python
- `styles.css`: stile del CV
- `assets/profile-from-pdf.jpg`: foto profilo
- `data/cv.sqlite`: database SQLite del CV

Avvio:

```powershell
cd C:\cv\python-simple
python server.py
```

Poi apri:

`http://127.0.0.1:8010`

Se il browser mostra `ERR_EMPTY_RESPONSE`:

1. chiudi il server con `Ctrl+C`
2. rilancia `python server.py`
3. ricarica `http://127.0.0.1:8010`

Se compare una traceback nel terminale, il browser non riceve dati finche' il processo non viene riavviato con il file corretto.

Puoi modificare i dati direttamente nel database SQLite con:

- DB Browser for SQLite
- SQLiteStudio
