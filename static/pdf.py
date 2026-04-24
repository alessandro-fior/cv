from playwright.sync_api import sync_playwright

with sync_playwright() as p:
    browser = p.chromium.launch()
    page = browser.new_page()
    page.goto("file:///C:/path/file.html")
    page.pdf(path="output.pdf")
    browser.close()