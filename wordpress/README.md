# WordPress-Version der Website

- `fewo-elias/` – das WordPress-Theme. Für Hostinger als ZIP packen und unter **Design → Themes → Theme hochladen** installieren.
- `blueprint.json` – startet eine Testumgebung in WordPress Playground (WordPress im Browser, ohne Server):
  https://playground.wordpress.net/?blueprint-url=https://raw.githubusercontent.com/KlebstoffKlaus-arv/fewo-website-test/wordpress-theme/wordpress/blueprint.json
  Funktioniert nur, solange das Repository öffentlich ist. Änderungen in Playground gehen beim Schließen des Tabs verloren.
- `playground-setup.php` – Einrichtungsschritte für Playground (Sprachen anlegen, Seiten erstellen, Beispielpreise). Auf dem echten Server nicht nötig.

Die statische Vorschau liegt unter `/index-neu.html` (über GitHub Pages erreichbar, wenn Pages für den Branch `wordpress-theme` aktiviert ist).
