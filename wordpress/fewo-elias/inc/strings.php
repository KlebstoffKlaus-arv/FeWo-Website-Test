<?php
/**
 * Feste Beschriftungen der Website (Menü, Kalender, Formular) in drei Sprachen.
 * Die eigentlichen Seitentexte werden im WordPress-Editor bearbeitet.
 */

defined( 'ABSPATH' ) || exit;

function fewo_strings( $lang = 'de' ) {
	$all = array(
		'de' => array(
			'navApt' => 'Wohnung', 'navAmen' => 'Ausstattung', 'navBook' => 'Preise & Verfügbarkeit', 'navArea' => 'Umgebung', 'navFaq' => 'FAQ', 'navCta' => 'Anfragen',
			'menuAria' => 'Hauptmenü', 'menuOpen' => 'Menü öffnen', 'langAria' => 'Sprache wählen',
			'summer' => 'Sommer', 'winter' => 'Winter', 'seasonAria' => 'Jahreszeit wählen',
			'pickIn' => 'Anreise wählen', 'pickOut' => 'Abreise wählen', 'booked' => 'belegt', 'inout' => 'An-/Abreise', 'stay' => 'dein Aufenthalt',
			'prev' => 'Vorheriger Monat', 'next' => 'Nächster Monat',
			'calNote' => 'Durchgestrichene Tage sind bereits belegt.',
			'from' => 'ab', 'perNight' => '/ Nacht', 'onRequest' => 'Preis auf Anfrage',
			'arrival' => 'Anreise', 'departure' => 'Abreise', 'adults' => 'Erwachsene', 'kids' => 'Kinder',
			'pickDates' => 'Bitte Zeitraum wählen', 'night' => 'Nacht', 'nights' => 'Nächte', 'cleaning' => 'Endreinigung', 'tax' => 'Gästetaxe', 'minStay' => 'Mindestaufenthalt {n} Nächte', 'total' => 'Gesamt',
			'notFree' => 'In diesem Zeitraum ist die Wohnung leider schon belegt.',
			'bookCta' => 'Unverbindlich anfragen', 'calcNote' => 'Unverbindliche Berechnung. Den endgültigen Preis bestätigen wir mit unserer Antwort.',
			'name' => 'Name', 'email' => 'E-Mail', 'guests' => 'Personen', 'guestsPh' => 'z. B. 2 Erwachsene, 1 Kind', 'message' => 'Nachricht', 'messagePh' => 'Fragen oder Wünsche?',
			'privacy' => 'Ich habe die {link} gelesen und bin mit der Verarbeitung meiner Angaben zur Beantwortung der Anfrage einverstanden.', 'privacyLink' => 'Datenschutzerklärung',
			'send' => 'Anfrage senden', 'invalid' => 'Bitte Name, eine gültige E-Mail und die Zustimmung zum Datenschutz angeben.', 'sending' => 'Wird gesendet …',
			'ok' => 'Danke für deine Anfrage! Wir melden uns so bald wie möglich.', 'err' => 'Senden hat nicht geklappt. Bitte schreib uns direkt per E-Mail.',
			'adultsWord' => 'Erwachsene', 'kidsWord' => 'Kinder', 'noMsg' => '(keine Nachricht)',
			'imprint' => 'Impressum', 'privacyPage' => 'Datenschutz', 'mbar' => 'Verfügbarkeit', 'close' => 'Schließen', 'image' => 'Bild',
		),
		'en' => array(
			'navApt' => 'Apartment', 'navAmen' => 'Amenities', 'navBook' => 'Prices & availability', 'navArea' => 'Area', 'navFaq' => 'FAQ', 'navCta' => 'Enquire',
			'menuAria' => 'Main menu', 'menuOpen' => 'Open menu', 'langAria' => 'Choose language',
			'summer' => 'Summer', 'winter' => 'Winter', 'seasonAria' => 'Choose season',
			'pickIn' => 'Choose arrival', 'pickOut' => 'Choose departure', 'booked' => 'booked', 'inout' => 'arrival/departure', 'stay' => 'your stay',
			'prev' => 'Previous month', 'next' => 'Next month',
			'calNote' => 'Crossed-out days are already booked.',
			'from' => 'from', 'perNight' => '/ night', 'onRequest' => 'Price on request',
			'arrival' => 'Arrival', 'departure' => 'Departure', 'adults' => 'Adults', 'kids' => 'Children',
			'pickDates' => 'Please choose your dates', 'night' => 'night', 'nights' => 'nights', 'cleaning' => 'Final cleaning', 'tax' => 'Tourist tax', 'minStay' => 'Minimum stay {n} nights', 'total' => 'Total',
			'notFree' => 'Sorry, the apartment is already booked during this period.',
			'bookCta' => 'Send a free enquiry', 'calcNote' => 'Non-binding estimate. We confirm the final price in our reply.',
			'name' => 'Name', 'email' => 'Email', 'guests' => 'Guests', 'guestsPh' => 'e.g. 2 adults, 1 child', 'message' => 'Message', 'messagePh' => 'Any questions or wishes?',
			'privacy' => 'I have read the {link} and agree that my details are used to answer my enquiry.', 'privacyLink' => 'privacy policy',
			'send' => 'Send enquiry', 'invalid' => 'Please enter your name, a valid email and accept the privacy policy.', 'sending' => 'Sending …',
			'ok' => 'Thank you for your enquiry! We will get back to you as soon as possible.', 'err' => 'Sending failed. Please email us directly.',
			'adultsWord' => 'adults', 'kidsWord' => 'children', 'noMsg' => '(no message)',
			'imprint' => 'Legal notice', 'privacyPage' => 'Privacy', 'mbar' => 'Availability', 'close' => 'Close', 'image' => 'Image',
		),
		'nl' => array(
			'navApt' => 'Appartement', 'navAmen' => 'Voorzieningen', 'navBook' => 'Prijzen & beschikbaarheid', 'navArea' => 'Omgeving', 'navFaq' => 'FAQ', 'navCta' => 'Aanvragen',
			'menuAria' => 'Hoofdmenu', 'menuOpen' => 'Menu openen', 'langAria' => 'Taal kiezen',
			'summer' => 'Zomer', 'winter' => 'Winter', 'seasonAria' => 'Seizoen kiezen',
			'pickIn' => 'Kies aankomst', 'pickOut' => 'Kies vertrek', 'booked' => 'bezet', 'inout' => 'aankomst/vertrek', 'stay' => 'jouw verblijf',
			'prev' => 'Vorige maand', 'next' => 'Volgende maand',
			'calNote' => 'Doorgestreepte dagen zijn al bezet.',
			'from' => 'vanaf', 'perNight' => '/ nacht', 'onRequest' => 'Prijs op aanvraag',
			'arrival' => 'Aankomst', 'departure' => 'Vertrek', 'adults' => 'Volwassenen', 'kids' => 'Kinderen',
			'pickDates' => 'Kies eerst je periode', 'night' => 'nacht', 'nights' => 'nachten', 'cleaning' => 'Eindschoonmaak', 'tax' => 'Toeristenbelasting', 'minStay' => 'Minimaal verblijf {n} nachten', 'total' => 'Totaal',
			'notFree' => 'Helaas is het appartement in deze periode al bezet.',
			'bookCta' => 'Vrijblijvend aanvragen', 'calcNote' => 'Vrijblijvende berekening. De definitieve prijs bevestigen we in ons antwoord.',
			'name' => 'Naam', 'email' => 'E-mail', 'guests' => 'Personen', 'guestsPh' => 'bijv. 2 volwassenen, 1 kind', 'message' => 'Bericht', 'messagePh' => 'Vragen of wensen?',
			'privacy' => 'Ik heb de {link} gelezen en ga akkoord met het gebruik van mijn gegevens om mijn aanvraag te beantwoorden.', 'privacyLink' => 'privacyverklaring',
			'send' => 'Aanvraag versturen', 'invalid' => 'Vul je naam en een geldig e-mailadres in en ga akkoord met de privacyverklaring.', 'sending' => 'Bezig met versturen …',
			'ok' => 'Bedankt voor je aanvraag! We nemen zo snel mogelijk contact met je op.', 'err' => 'Versturen is mislukt. Mail ons alsjeblieft direct.',
			'adultsWord' => 'volwassenen', 'kidsWord' => 'kinderen', 'noMsg' => '(geen bericht)',
			'imprint' => 'Colofon', 'privacyPage' => 'Privacy', 'mbar' => 'Beschikbaarheid', 'close' => 'Sluiten', 'image' => 'Afbeelding',
		),
	);
	return isset( $all[ $lang ] ) ? $all[ $lang ] : $all['de'];
}
