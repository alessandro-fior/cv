@echo off
set DIR=%~dp0

"C:\Program Files\Google\Chrome\Application\chrome.exe" ^
--headless ^
--disable-gpu ^
--print-to-pdf="%DIR%CV-Alessandro-Fior.pdf" ^
"file:///%DIR%index.html"
pause