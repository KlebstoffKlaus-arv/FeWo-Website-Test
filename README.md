# Ferienwohnung Elias – Website

Moderne Website für die Ferienwohnung Elias in Riezlern (Deutsch, Englisch, Niederländisch).
Gehostet kostenlos bei **Cloudflare**, bearbeitet ohne Programmierkenntnisse über **Pages CMS**.

## So funktioniert es

1. Inhalte stehen in `content/` (Texte, Preise, Belegung, Fotos) und Fotos in `images/`.
2. Wer in Pages CMS etwas speichert, ändert diese Dateien auf GitHub.
3. Cloudflare merkt das, baut die Website neu (`npm run build`) und veröffentlicht sie – nach ca. 1–2 Minuten ist die Änderung online.

## Ordner

| Ordner / Datei | Inhalt |
|---|---|
| `content/preise.json` | Belegung, Preise, Saisonpreise, Telefon, Anfrage-E-Mail |
| `content/fotos.json` | welche Fotos wo erscheinen, Bildunterschriften |
| `content/texte-de/en/nl.json` | alle Texte je Sprache |
| `content/rechtliches.json` | Impressum und Datenschutzerklärung |
| `images/` | Fotos (werden beim Bauen automatisch verkleinert) |
| `src/` | Gestaltung (CSS), Skripte, Schriften, Logo |
| `build/` | Baut aus Inhalten und Vorlage die fertigen Seiten nach `dist/` |
| `worker/` | Verschickt Anfragen aus dem Formular per E-Mail |
| `.pages.yml` | Welche Felder in Pages CMS erscheinen |
| `wrangler.jsonc` | Cloudflare-Einstellungen |

## Einrichtung (einmalig)

### 1. Cloudflare
1. Kostenloses Konto auf cloudflare.com anlegen.
2. **Workers & Pages → Erstellen → Repository importieren** → GitHub verbinden → Repository `fewo-website-test` wählen.
3. Branch: `cloudflare` · Build-Befehl: `npm run build` · Deploy-Befehl: `npx wrangler deploy` (Standard).
4. Nach dem ersten Durchlauf ist die Seite unter `ferienwohnung-elias.<konto>.workers.dev` erreichbar.

### 2. Pages CMS
1. Auf app.pagescms.org mit GitHub anmelden und die Pages-CMS-App für das Repository erlauben.
2. Repository öffnen, Branch `cloudflare` wählen.
3. **Collaborators** → Eltern per E-Mail einladen. Sie brauchen keinen GitHub-Account.

### 3. Eigene Domain (wenn alles passt)
1. In Cloudflare **Domain hinzufügen** → `ferienwohnung-elias.at` → Free-Plan.
2. Beim bisherigen Domain-Anbieter die Nameserver auf die zwei von Cloudflare angezeigten ändern.
3. Im Worker unter **Einstellungen → Domains & Routen** `ferienwohnung-elias.at` und `www.ferienwohnung-elias.at` hinzufügen.

### 4. Anfragen per E-Mail
1. In Cloudflare bei der Domain **E-Mail → Email Routing** aktivieren.
2. Unter **Zieladressen** `fewoelias@gmail.com` hinzufügen und den Link in der Bestätigungsmail anklicken.
3. In `wrangler.jsonc` die Zeilen `send_email` und `vars` aktivieren (siehe Kommentar dort).

Solange Schritt 4 fehlt, bietet das Formular Gästen automatisch an, die fertige Anfrage per E-Mail zu schicken – es geht also nichts verloren.

## Lokal testen

```bash
npm install
npm run dev     # baut die Seite und startet sie auf http://localhost:8787
```
