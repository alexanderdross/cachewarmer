# API Keys & Credentials — Schritt-für-Schritt Anleitungen

## Inhaltsverzeichnis

1. [Facebook App ID & App Secret](#1-facebook-app-id--app-secret)
2. [LinkedIn Session Cookie](#2-linkedin-session-cookie)
3. [Google Service Account (Indexing API)](#3-google-service-account-indexing-api)
4. [Bing Webmaster API Key](#4-bing-webmaster-api-key)
5. [IndexNow Key](#5-indexnow-key)

---

## 1. Facebook App ID & App Secret

Die Facebook Graph API wird genutzt, um den OG-Tag-Cache zu invalidieren (Sharing Debugger).

### Voraussetzungen
- Ein Facebook-Konto
- Optional: Ein Facebook-Unternehmenskonto (Business Manager)

### Schritte

1. **Facebook Developers Portal öffnen**
   - Gehe zu https://developers.facebook.com
   - Melde dich mit deinem Facebook-Konto an

2. **Neue App erstellen**
   - Klicke auf **"Meine Apps"** (oben rechts)
   - Klicke auf **"App erstellen"**
   - Wähle den App-Typ: **"Business"** (oder "Sonstiges")
   - Gib einen App-Namen ein, z.B. `CacheWarmer`
   - Wähle dein Business-Konto (oder erstelle eins)
   - Klicke auf **"App erstellen"**

3. **App ID kopieren**
   - Nach der Erstellung wirst du zum Dashboard weitergeleitet
   - Die **App ID** steht oben auf der Seite (z.B. `123456789012345`)

4. **App Secret kopieren**
   - Gehe zu **Einstellungen** → **Grundlegendes**
   - Neben "App-Geheimcode" klicke auf **"Anzeigen"**
   - Bestätige mit deinem Facebook-Passwort
   - Kopiere den **App Secret** (z.B. `abc123def456...`)

5. **In config.yaml eintragen**
   ```yaml
   facebook:
     enabled: true
     appId: "123456789012345"
     appSecret: "abc123def456ghi789jkl012mno345pq"
     rateLimitPerSecond: 10
   ```

### Hinweise
- Der Access Token wird automatisch als `app_id|app_secret` zusammengesetzt
- Die App muss **nicht** veröffentlicht werden — der Scrape-Endpoint funktioniert mit einem App Access Token
- Rate-Limit: Max. 200 Calls/Stunde pro App (10/Sekunde ist konservativ genug)

---

## 2. LinkedIn Session Cookie

LinkedIn bietet keine offizielle API zum Cache-Invalidieren. Stattdessen nutzen wir den Post Inspector über ein Session Cookie.

### Voraussetzungen
- Ein LinkedIn-Konto

### Schritte

1. **In LinkedIn einloggen**
   - Gehe zu https://www.linkedin.com und melde dich an

2. **Browser DevTools öffnen**
   - **Chrome:** `F12` oder `Strg+Shift+I` (Windows) / `Cmd+Option+I` (Mac)
   - **Firefox:** `F12` oder `Strg+Shift+I`

3. **Cookie extrahieren**
   - Gehe zum Tab **"Application"** (Chrome) oder **"Storage"** (Firefox)
   - Klappe links **"Cookies"** auf
   - Wähle `https://www.linkedin.com`
   - Suche nach dem Cookie mit dem Namen **`li_at`**
   - Kopiere den **Wert** (eine lange Zeichenkette, z.B. `AQEDAQe...`)

4. **In config.yaml eintragen**
   ```yaml
   linkedin:
     enabled: true
     sessionCookie: "AQEDAQe...dein_li_at_cookie_wert..."
     concurrency: 1
     delayBetweenRequests: 5000
   ```

### Hinweise
- Das Cookie hat eine **begrenzte Gültigkeitsdauer** (ca. 1 Jahr)
- Wenn das Cookie abläuft, musst du es erneut aus dem Browser extrahieren
- LinkedIn erkennt automatisierte Zugriffe — halte `concurrency: 1` und `delayBetweenRequests: 5000` bei
- **Wichtig:** Teile dieses Cookie mit niemandem — es gewährt vollen Zugriff auf deinen Account

---

## 3. Google Service Account (Indexing API)

Über die Google Indexing API kannst du Google benachrichtigen, wenn sich URLs geändert haben.

### Voraussetzungen
- Ein Google-Konto
- Zugriff auf die Google Cloud Console
- Eine verifizierte Property in der Google Search Console

### Schritt A: Projekt & Service Account erstellen

1. **Google Cloud Console öffnen**
   - Gehe zu https://console.cloud.google.com

2. **Neues Projekt erstellen**
   - Klicke oben auf das Projekt-Dropdown → **"Neues Projekt"**
   - Name: `CacheWarmer`
   - Klicke auf **"Erstellen"**
   - Warte bis das Projekt erstellt ist und wähle es aus

3. **Indexing API aktivieren**
   - Gehe zu **APIs & Dienste** → **Bibliothek**
   - Suche nach **"Web Search Indexing API"**
   - Klicke auf **"Aktivieren"**

4. **Service Account erstellen**
   - Gehe zu **APIs & Dienste** → **Anmeldedaten**
   - Klicke auf **"Anmeldedaten erstellen"** → **"Dienstkonto"**
   - Name: `cachewarmer-indexer`
   - Klicke auf **"Erstellen und fortfahren"**
   - Rolle: Keine spezielle Rolle nötig → **"Fertig"**

5. **JSON-Schlüssel herunterladen**
   - Klicke auf das neu erstellte Dienstkonto
   - Gehe zum Tab **"Schlüssel"**
   - Klicke auf **"Schlüssel hinzufügen"** → **"Neuen Schlüssel erstellen"**
   - Typ: **JSON**
   - Klicke auf **"Erstellen"**
   - Die JSON-Datei wird automatisch heruntergeladen

6. **JSON-Datei platzieren**
   - Verschiebe die heruntergeladene Datei nach:
     ```
     cachewarmer/credentials/google-sa-key.json
     ```

### Schritt B: Service Account in Search Console berechtigen

7. **E-Mail-Adresse des Service Accounts kopieren**
   - In der Google Cloud Console unter **Dienstkonten**
   - Format: `cachewarmer-indexer@cachewarmer-xxxxx.iam.gserviceaccount.com`

8. **Google Search Console öffnen**
   - Gehe zu https://search.google.com/search-console
   - Wähle deine Property (z.B. `https://www.example.com`)

9. **Service Account als Inhaber hinzufügen**
   - Gehe zu **Einstellungen** → **Nutzer und Berechtigungen**
   - Klicke auf **"Nutzer hinzufügen"**
   - E-Mail: Die Service-Account-E-Mail aus Schritt 7
   - Berechtigung: **"Inhaber"**
   - Klicke auf **"Hinzufügen"**

10. **In config.yaml eintragen**
    ```yaml
    google:
      enabled: true
      serviceAccountKeyFile: "./credentials/google-sa-key.json"
      dailyQuota: 200
    ```

### Hinweise
- Tägliches Limit: **200 URL-Benachrichtigungen** pro Property
- Die Indexing API garantiert keine sofortige Indexierung — sie informiert Google nur
- Die JSON-Datei enthält sensible Daten — sie wird automatisch von `.gitignore` ausgeschlossen

---

## 4. Bing Webmaster API Key

Damit können URLs direkt an Bing zur Indexierung übermittelt werden.

### Voraussetzungen
- Ein Microsoft-Konto
- Eine verifizierte Website in den Bing Webmaster Tools

### Schritte

1. **Bing Webmaster Tools öffnen**
   - Gehe zu https://www.bing.com/webmasters
   - Melde dich mit deinem Microsoft-Konto an

2. **Website hinzufügen (falls noch nicht geschehen)**
   - Klicke auf **"Website hinzufügen"**
   - Gib deine Domain ein, z.B. `https://www.example.com`
   - Verifiziere die Website über eine der angebotenen Methoden:
     - XML-Datei auf dem Server
     - CNAME-DNS-Eintrag
     - Meta-Tag auf der Startseite

3. **API Key generieren**
   - Nach der Verifizierung: Klicke auf das **Zahnrad-Symbol** (Einstellungen)
   - Oder gehe direkt zu: **Meine Website** → **Konfigurieren** → **API-Zugriff**
   - Klicke auf **"API-Schlüssel generieren"**
   - Kopiere den generierten API Key

4. **In config.yaml eintragen**
   ```yaml
   bing:
     enabled: true
     apiKey: "dein_bing_api_key_hier"
     dailyQuota: 10000
   ```

### Hinweise
- Standard-Limit: **10.000 URLs/Tag**, kann auf Anfrage auf 100.000+ erhöht werden
- Bing akzeptiert auch IndexNow — du kannst beides parallel nutzen
- Der API Key ist pro Microsoft-Konto, nicht pro Website

---

## 5. IndexNow Key

IndexNow ist ein offenes Protokoll, das von Bing, Yandex, Seznam und Naver unterstützt wird.

### Voraussetzungen
- Zugriff auf den Webserver / das Hosting deiner Website

### Schritte

1. **Key generieren**
   - Gehe zu https://www.indexnow.org/getstarted
   - Klicke auf **"Generate Key"**
   - Oder generiere selbst einen (mind. 8 Zeichen, alphanumerisch + Bindestriche):
     ```bash
     # Beispiel: Key mit openssl generieren
     openssl rand -hex 16
     # Ergebnis z.B.: a1b2c3d4e5f6a7b8c9d0e1f2a3b4c5d6
     ```

2. **Key-Datei auf deiner Website hosten**
   - Erstelle eine Textdatei mit dem Key als Dateinamen:
     ```
     https://www.example.com/a1b2c3d4e5f6a7b8c9d0e1f2a3b4c5d6.txt
     ```
   - Der Inhalt der Datei ist der Key selbst:
     ```
     a1b2c3d4e5f6a7b8c9d0e1f2a3b4c5d6
     ```
   - Die Datei muss im **Root-Verzeichnis** der Website erreichbar sein

3. **Verifizieren**
   - Öffne die URL im Browser und prüfe, ob der Key angezeigt wird:
     ```
     https://www.example.com/a1b2c3d4e5f6a7b8c9d0e1f2a3b4c5d6.txt
     ```

4. **In config.yaml eintragen**
   ```yaml
   indexNow:
     enabled: true
     key: "a1b2c3d4e5f6a7b8c9d0e1f2a3b4c5d6"
     keyLocation: "https://www.example.com/a1b2c3d4e5f6a7b8c9d0e1f2a3b4c5d6.txt"
   ```

### Hinweise
- IndexNow ist **kostenlos** und hat **keine strengen Rate-Limits**
- Bis zu **10.000 URLs pro Batch** können eingereicht werden
- Wenn du den Key bei Bing einreichst, wird er automatisch an alle IndexNow-Partner weitergeleitet (Yandex, Seznam, Naver)
- Der Key muss dauerhaft auf deiner Website erreichbar sein

---

## Zusammenfassung: Vollständige config.yaml

```yaml
facebook:
  enabled: true
  appId: "DEINE_FACEBOOK_APP_ID"
  appSecret: "DEIN_FACEBOOK_APP_SECRET"
  rateLimitPerSecond: 10

linkedin:
  enabled: true
  sessionCookie: "DEIN_LI_AT_COOKIE"
  concurrency: 1
  delayBetweenRequests: 5000

google:
  enabled: true
  serviceAccountKeyFile: "./credentials/google-sa-key.json"
  dailyQuota: 200

bing:
  enabled: true
  apiKey: "DEIN_BING_API_KEY"
  dailyQuota: 10000

indexNow:
  enabled: true
  key: "DEIN_INDEXNOW_KEY"
  keyLocation: "https://www.example.com/DEIN_INDEXNOW_KEY.txt"
```

> **Tipp:** Erstelle eine `config.local.yaml` mit deinen echten Keys — diese Datei wird automatisch von `.gitignore` ausgeschlossen und hat Vorrang vor `config.yaml`.
