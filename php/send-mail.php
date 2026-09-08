<?php
/**
 * Verarbeitet das Anfrageformular von preise-anfrage.html und versendet
 * eine E-Mail an die Vermieter. Läuft auf Hostinger-PHP-Hosting ohne
 * zusätzliche Abhängigkeiten (mail()-Funktion).
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

$empfaenger = 'fewoelias@gmail.com';

function respond(bool $success, string $message): void
{
    http_response_code($success ? 200 : 400);
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond(false, 'Ungültige Anfrage.');
}

function cleanInput(string $value): string
{
    $value = trim($value);
    $value = str_replace(["\r", "\n"], ' ', $value);
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$name = cleanInput($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$zeitraum = cleanInput($_POST['zeitraum'] ?? '');
$personen = cleanInput($_POST['personen'] ?? '');
$nachricht = trim($_POST['nachricht'] ?? '');
$honeypot = trim($_POST['website'] ?? ''); // Spam-Falle, für Menschen unsichtbar

if ($honeypot !== '') {
    // Vermutlich ein Bot: still und ohne Fehler abbrechen.
    respond(true, 'Danke für Ihre Anfrage.');
}

if ($name === '' || $email === '' || $nachricht === '') {
    respond(false, 'Bitte füllen Sie alle Pflichtfelder aus.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond(false, 'Bitte geben Sie eine gültige E-Mail-Adresse ein.');
}

$nachrichtSauber = htmlspecialchars(trim($nachricht), ENT_QUOTES, 'UTF-8');

$betreff = '=?UTF-8?B?' . base64_encode('Neue Anfrage – Ferienwohnung Elias') . '?=';

$body = "Neue Anfrage über das Kontaktformular der Website:\n\n"
    . "Name: {$name}\n"
    . "E-Mail: {$email}\n"
    . "Gewünschter Zeitraum: {$zeitraum}\n"
    . "Personenzahl: {$personen}\n\n"
    . "Nachricht:\n{$nachrichtSauber}\n";

$headers = [
    'MIME-Version: 1.0',
    'Content-Type: text/plain; charset=UTF-8',
    'From: Ferienwohnung Elias <no-reply@' . ($_SERVER['HTTP_HOST'] ?? 'fewo-elias.at') . '>',
    'Reply-To: ' . $email,
    'X-Mailer: PHP/' . phpversion(),
];

$erfolg = @mail($empfaenger, $betreff, $body, implode("\r\n", $headers));

if ($erfolg) {
    respond(true, 'Vielen Dank für Ihre Anfrage! Wir melden uns so bald wie möglich bei Ihnen.');
}

respond(false, 'Die Nachricht konnte nicht gesendet werden. Bitte versuchen Sie es später erneut.');
