# Ferienwohnung Elias – Website

Neue, moderne Website für die Ferienwohnung „Elias" der Familie Grabherr-Mathis in Riezlern/Kleinwalsertal. Reines HTML5/CSS3/Vanilla-JavaScript ohne Build-Schritt – die Seite ist so aufgebaut, dass sie direkt über Hostingers native Git-Integration deployt werden kann.

## Projektüberblick

- **Startseite** (`index.html`) – Hero, Kurzüberblick, Teaser-Kacheln, Bildergalerie
- **Die Wohnung** (`wohnung.html`) – Beschreibung, Ausstattung, Fotogalerie mit Lightbox
- **Preise & Anfrage** (`preise-anfrage.html`) – Preistabelle, inkludierte Leistungen, Mietkonditionen, Anfrageformular
- **Lage & Umgebung** (`lage.html`) – Kleinwalsertal, Sommer/Winter-Highlights, Anfahrt mit Karte
- **Impressum** (`impressum.html`) & **Datenschutz** (`datenschutz.html`) – rechtliche Pflichtseiten, nur im Footer verlinkt

### Ordnerstruktur

```
/
├── index.html
├── wohnung.html
├── preise-anfrage.html
├── lage.html
├── impressum.html
├── datenschutz.html
├── css/
│   └── style.css
├── js/
│   ├── main.js       (Navigation, Scroll-Reveal)
│   ├── gallery.js    (Lightbox-Galerie)
│   └── form.js        (Formularvalidierung & Versand)
├── images/            (Platzhalterbilder – bitte durch echte Fotos ersetzen)
└── php/
    └── send-mail.php  (Serverseitige Verarbeitung des Anfrageformulars)
```

## Lokale Vorschau

Kein Build-Schritt nötig. Für eine lokale Vorschau reicht ein einfacher statischer Server, z. B. mit Python:

```bash
python3 -m http.server 8000
```

Anschließend im Browser `http://localhost:8000` öffnen.

> Hinweis: Das PHP-Formular (`php/send-mail.php`) benötigt einen PHP-fähigen Server. Für einen lokalen Test mit PHP:
> ```bash
> php -S localhost:8000
> ```

## Platzhalterbilder

Die Bilder im Ordner `images/` sind generierte Platzhalter in den korrekten Seitenverhältnissen (JPG + WebP, gleicher Dateiname). Beim Austausch gegen eigene Fotos:

- gleichen Dateinamen und gleiches Seitenverhältnis beibehalten (oder Referenzen in den HTML-Dateien anpassen),
- Bilder als WebP (mit JPG-Fallback über `<picture>`) und komprimiert bereitstellen,
- aussagekräftige Alt-Texte in den `<img>`-Tags pflegen.

## Deployment über Hostinger (Git-Integration)

1. Dieses Repository auf GitHub (oder GitLab) pushen.
2. In hPanel: **Websites → [Domain] → Advanced → Git**.
3. Repository-URL und den gewünschten Branch (z. B. `main`) eintragen.
4. **Auto-Deploy** aktiviert lassen – jeder Push auf den verbundenen Branch wird automatisch veröffentlicht.
5. Da kein Build-Prozess läuft, wird exakt der Inhalt des Repositorys ausgeliefert. Sicherstellen, dass die Domain auf das Root-Verzeichnis dieses Repos zeigt (dort liegt `index.html`).
6. Für das Kontaktformular: PHP-Hosting ist bei Hostinger standardmäßig aktiv, `php/send-mail.php` funktioniert ohne weitere Konfiguration.

## Kontakt (Website-Betreiber)

Familie Grabherr-Mathis, Eggstraße 15, A-6991 Riezlern
Tel.: 0043/5517/3193 · Mobil: 0043/650/5173194 · E-Mail: fewoelias@gmail.com
