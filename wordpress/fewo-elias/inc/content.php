<?php
/**
 * Erstinhalte der Startseite in Deutsch, Englisch und Niederländisch.
 * Wird nur beim Einrichten verwendet – danach werden alle Texte im Editor gepflegt.
 */

defined( 'ABSPATH' ) || exit;

function fewo_content_texts( $lang ) {
	$t = array(
		'de' => array(
			'h1S' => 'Dein Zuhause<br>in den <em>Bergen</em>.', 'h1W' => 'Dein Zuhause<br>im <em>Schnee</em>.',
			'leadS' => 'Ruhig am Wiesenrand, Bus direkt vor der Tür und Wanderwege ab Haus. Unsere helle Ferienwohnung ist der perfekte Ausgangspunkt für Familien und Freunde.',
			'leadW' => 'Ski- und Wanderbus direkt vor der Tür, Skischuhtrockner im Haus und abends gemütlich zurück in die warme Wohnung.',
			'cta1' => 'Verfügbarkeit prüfen', 'cta2' => 'Fotos ansehen',
			'fc1' => 'zum Ski- &amp; Wanderbus', 'fc2b' => 'Terrasse', 'fc2' => 'mit Garten &amp; Wiese',
			'f1' => 'm² Wohnfläche', 'f2' => 'Schlafzimmer', 'f3' => 'Erwachsene max. + Kinder', 'f4' => 'Zimmer insgesamt',
			'aptE' => 'Die Wohnung', 'aptH' => 'Hell, gemütlich, durchdacht.', 'aptP' => 'Zwei Schlafzimmer, ein Wohnbereich mit Küche und eine eigene Terrasse mit Blick ins Grüne. Tippe auf ein Bild, um es groß zu sehen.',
			'g' => array( 'Wohnbereich', 'Küche', 'Schlafzimmer 1', 'Terrasse', 'Schlafzimmer 2', 'Bad', 'Essbereich', 'Ausblick' ),
			'amE' => 'Ausstattung', 'amH' => 'Alles da, was du brauchst.', 'amP' => 'Bettwäsche und Handtücher sind vorhanden – einfach anreisen und wohlfühlen.',
			'am' => array(
				array( 'Küche &amp; Wohnen', array( 'Backofen, Kühlschrank mit Gefrierfach', 'Dunstabzug, Küchen- &amp; Tischwäsche', 'Sat-TV, Radio, kostenloses WLAN' ) ),
				array( 'Schlafen &amp; Bad', array( '2 separate Schlafzimmer', 'Bettwäsche &amp; Handtücher inklusive', 'Föhn im Bad' ) ),
				array( 'Familie &amp; Draußen', array( 'Kinderbett &amp; Hochstuhl', 'Terrasse, Gartenmöbel, Liegestühle', 'Parkplatz, Radabstellplatz, Skischuhtrockner' ) ),
			),
			'amN' => 'Nichtraucherhaus · Haustiere leider nicht erlaubt',
			'bkE' => 'Preise &amp; Verfügbarkeit', 'bkH' => 'Wähle deinen Zeitraum.', 'bkP' => 'Tippe auf Anreise und Abreise im Kalender – der Preis wird sofort berechnet.',
			'arE' => 'Umgebung', 'arHS' => 'Sommer im Kleinwalsertal', 'arHW' => 'Winter im Kleinwalsertal', 'arP' => 'Ob Gipfeltour oder gemütlicher Spaziergang – direkt vor der Haustür geht’s los.',
			'tS' => array( array( 'Wandern', 'Unzählige Wege starten direkt in Riezlern – vom Familienspaziergang bis zur Gipfeltour.' ), array( 'Bergbahnen', 'Mit der Gästekarte hinauf ins Panorama – ideal mit Kindern.' ), array( 'Rad &amp; Bike', 'Gemütliche Talrunden oder sportliche Touren – dein Rad steht sicher am Haus.' ) ),
			'tW' => array( array( 'Skifahren', 'Mit dem Skibus ab Haustür in wenigen Minuten bei den Liften.' ), array( 'Langlauf', 'Gespurte Loipen durch die verschneite Landschaft.' ), array( 'Winterwandern', 'Geräumte Winterwanderwege und Hütten zum Einkehren.' ) ),
			'mapP' => 'Ruhige Lage am Wiesenrand, Bushaltestelle direkt am Haus.', 'mapB' => 'Route planen',
			'fqE' => 'Gut zu wissen', 'fqH' => 'Häufige Fragen',
			'fq' => array(
				array( 'Wann ist An- und Abreise?', 'Anreise ab … Uhr, Abreise bis … Uhr. (Bitte Uhrzeiten eintragen.)' ),
				array( 'Sind Bettwäsche und Handtücher dabei?', 'Ja, Bett-, Küchen- und Tischwäsche sowie Handtücher sind vorhanden.' ),
				array( 'Gibt es einen Parkplatz?', 'Ja, ein Parkplatz am Haus ist vorhanden. Fahrräder können ebenfalls sicher abgestellt werden.' ),
				array( 'Sind Haustiere erlaubt?', 'Leider nein. Die Wohnung ist außerdem ein Nichtraucherhaus.' ),
				array( 'Wie kann ich bezahlen?', 'Per Überweisung oder bar vor Ort.' ),
			),
			'ctE' => 'Kontakt', 'ctH' => 'Wir freuen uns auf dich!', 'ctP' => 'Schick uns deine Anfrage – wir melden uns persönlich, meist innerhalb von 24 Stunden.',
			'host' => '<strong>Familie Grabherr</strong><br>Eure Gastgeber in Riezlern · Tel. +43 5517 3193',
			'pageTitle' => 'Startseite',
		),
		'en' => array(
			'h1S' => 'Your home<br>in the <em>mountains</em>.', 'h1W' => 'Your home<br>in the <em>snow</em>.',
			'leadS' => 'Quietly set at the edge of a meadow, with the bus stop right outside and hiking trails from the door. Our bright apartment is the perfect base for families and friends.',
			'leadW' => 'Ski and hiking bus right outside, a ski boot dryer in the house and a warm, cosy apartment to come back to in the evening.',
			'cta1' => 'Check availability', 'cta2' => 'View photos',
			'fc1' => 'to the ski &amp; hiking bus', 'fc2b' => 'Terrace', 'fc2' => 'with garden &amp; meadow',
			'f1' => 'm² living space', 'f2' => 'bedrooms', 'f3' => 'adults max. + children', 'f4' => 'rooms in total',
			'aptE' => 'The apartment', 'aptH' => 'Bright, cosy, well thought out.', 'aptP' => 'Two bedrooms, a living area with kitchen and a private terrace overlooking the greenery. Tap a photo to see it larger.',
			'g' => array( 'Living area', 'Kitchen', 'Bedroom 1', 'Terrace', 'Bedroom 2', 'Bathroom', 'Dining area', 'View' ),
			'amE' => 'Amenities', 'amH' => 'Everything you need.', 'amP' => 'Bed linen and towels are provided – just arrive and feel at home.',
			'am' => array(
				array( 'Kitchen &amp; living', array( 'Oven, fridge with freezer compartment', 'Extractor hood, kitchen &amp; table linen', 'Satellite TV, radio, free Wi-Fi' ) ),
				array( 'Sleeping &amp; bathroom', array( '2 separate bedrooms', 'Bed linen &amp; towels included', 'Hairdryer in the bathroom' ) ),
				array( 'Family &amp; outdoors', array( 'Cot &amp; high chair', 'Terrace, garden furniture, deck chairs', 'Parking, bike storage, ski boot dryer' ) ),
			),
			'amN' => 'Non-smoking house · Sorry, no pets',
			'bkE' => 'Prices &amp; availability', 'bkH' => 'Choose your dates.', 'bkP' => 'Tap your arrival and departure in the calendar – the price is calculated instantly.',
			'arE' => 'Area', 'arHS' => 'Summer in the Kleinwalsertal', 'arHW' => 'Winter in the Kleinwalsertal', 'arP' => 'Summit tour or gentle stroll – it all starts right on your doorstep.',
			'tS' => array( array( 'Hiking', 'Countless trails start right in Riezlern – from family walks to summit tours.' ), array( 'Mountain lifts', 'Ride up to the views with the guest card – great with kids.' ), array( 'Cycling &amp; biking', 'Easy valley loops or sporty tours – your bike is stored safely at the house.' ) ),
			'tW' => array( array( 'Skiing', 'The ski bus from the door gets you to the lifts in minutes.' ), array( 'Cross-country skiing', 'Groomed trails through the snowy landscape.' ), array( 'Winter walks', 'Cleared winter paths and mountain huts to stop at.' ) ),
			'mapP' => 'Quiet spot at the edge of a meadow, bus stop right by the house.', 'mapB' => 'Plan your route',
			'fqE' => 'Good to know', 'fqH' => 'Frequently asked questions',
			'fq' => array(
				array( 'When are check-in and check-out?', 'Check-in from … , check-out by … . (Please fill in the times.)' ),
				array( 'Are bed linen and towels included?', 'Yes, bed, kitchen and table linen as well as towels are provided.' ),
				array( 'Is there parking?', 'Yes, there is a parking space at the house. Bikes can be stored safely too.' ),
				array( 'Are pets allowed?', 'Sorry, no. The apartment is also non-smoking.' ),
				array( 'How can I pay?', 'By bank transfer or in cash on site.' ),
			),
			'ctE' => 'Contact', 'ctH' => 'We look forward to welcoming you!', 'ctP' => 'Send us your enquiry – we’ll get back to you personally, usually within 24 hours.',
			'host' => '<strong>The Grabherr family</strong><br>Your hosts in Riezlern · Phone +43 5517 3193',
			'pageTitle' => 'Home',
		),
		'nl' => array(
			'h1S' => 'Jouw thuis<br>in de <em>bergen</em>.', 'h1W' => 'Jouw thuis<br>in de <em>sneeuw</em>.',
			'leadS' => 'Rustig gelegen aan de rand van een weide, met de bushalte voor de deur en wandelpaden vanaf het huis. Ons lichte appartement is de perfecte uitvalsbasis voor gezinnen en vrienden.',
			'leadW' => 'Ski- en wandelbus voor de deur, een skischoendroger in huis en ’s avonds terug naar een warm, gezellig appartement.',
			'cta1' => 'Beschikbaarheid bekijken', 'cta2' => 'Foto’s bekijken',
			'fc1' => 'naar de ski- &amp; wandelbus', 'fc2b' => 'Terras', 'fc2' => 'met tuin &amp; weide',
			'f1' => 'm² woonoppervlak', 'f2' => 'slaapkamers', 'f3' => 'volwassenen max. + kinderen', 'f4' => 'kamers in totaal',
			'aptE' => 'Het appartement', 'aptH' => 'Licht, gezellig, doordacht.', 'aptP' => 'Twee slaapkamers, een woonruimte met keuken en een eigen terras met uitzicht op het groen. Tik op een foto om hem groot te zien.',
			'g' => array( 'Woonkamer', 'Keuken', 'Slaapkamer 1', 'Terras', 'Slaapkamer 2', 'Badkamer', 'Eethoek', 'Uitzicht' ),
			'amE' => 'Voorzieningen', 'amH' => 'Alles wat je nodig hebt.', 'amP' => 'Beddengoed en handdoeken zijn aanwezig – gewoon aankomen en je thuis voelen.',
			'am' => array(
				array( 'Keuken &amp; wonen', array( 'Oven, koelkast met vriesvak', 'Afzuigkap, keuken- &amp; tafellinnen', 'Satelliet-tv, radio, gratis wifi' ) ),
				array( 'Slapen &amp; badkamer', array( '2 aparte slaapkamers', 'Beddengoed &amp; handdoeken inbegrepen', 'Föhn in de badkamer' ) ),
				array( 'Gezin &amp; buiten', array( 'Kinderbed &amp; kinderstoel', 'Terras, tuinmeubels, ligstoelen', 'Parkeerplaats, fietsenstalling, skischoendroger' ) ),
			),
			'amN' => 'Rookvrij huis · Huisdieren helaas niet toegestaan',
			'bkE' => 'Prijzen &amp; beschikbaarheid', 'bkH' => 'Kies je periode.', 'bkP' => 'Tik op je aankomst- en vertrekdatum in de kalender – de prijs wordt direct berekend.',
			'arE' => 'Omgeving', 'arHS' => 'Zomer in het Kleinwalsertal', 'arHW' => 'Winter in het Kleinwalsertal', 'arP' => 'Een toptocht of een rustige wandeling – het begint direct voor de deur.',
			'tS' => array( array( 'Wandelen', 'Talloze paden beginnen in Riezlern – van gezinswandeling tot toptocht.' ), array( 'Bergbanen', 'Met de gastenkaart omhoog naar het panorama – ideaal met kinderen.' ), array( 'Fietsen &amp; mountainbiken', 'Rustige rondjes door het dal of sportieve tochten – je fiets staat veilig bij het huis.' ) ),
			'tW' => array( array( 'Skiën', 'Met de skibus vanaf de deur ben je in een paar minuten bij de liften.' ), array( 'Langlaufen', 'Geprepareerde loipes door het besneeuwde landschap.' ), array( 'Winterwandelen', 'Geruimde winterwandelpaden en berghutten om binnen te lopen.' ) ),
			'mapP' => 'Rustige ligging aan de rand van een weide, bushalte direct bij het huis.', 'mapB' => 'Route plannen',
			'fqE' => 'Goed om te weten', 'fqH' => 'Veelgestelde vragen',
			'fq' => array(
				array( 'Wanneer is aankomst en vertrek?', 'Aankomst vanaf … uur, vertrek tot … uur. (Tijden nog invullen.)' ),
				array( 'Zijn beddengoed en handdoeken inbegrepen?', 'Ja, bed-, keuken- en tafellinnen en handdoeken zijn aanwezig.' ),
				array( 'Is er een parkeerplaats?', 'Ja, er is een parkeerplaats bij het huis. Fietsen kunnen ook veilig worden gestald.' ),
				array( 'Zijn huisdieren toegestaan?', 'Helaas niet. Het appartement is bovendien rookvrij.' ),
				array( 'Hoe kan ik betalen?', 'Per bankoverschrijving of contant ter plaatse.' ),
			),
			'ctE' => 'Contact', 'ctH' => 'We kijken ernaar uit je te verwelkomen!', 'ctP' => 'Stuur ons je aanvraag – we reageren persoonlijk, meestal binnen 24 uur.',
			'host' => '<strong>Familie Grabherr</strong><br>Jullie gastheren in Riezlern · Tel. +43 5517 3193',
			'pageTitle' => 'Home',
		),
	);
	return $t[ $lang ];
}

/* ---------- kleine Helfer, die gültiges Block-Markup erzeugen ---------- */

function fewo_b_attrs( $attrs ) {
	return $attrs ? ' ' . wp_json_encode( $attrs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) : '';
}

function fewo_b_p( $html, $class = '' ) {
	$a = $class ? array( 'className' => $class ) : array();
	$c = $class ? ' class="' . esc_attr( $class ) . '"' : '';
	return "<!-- wp:paragraph" . fewo_b_attrs( $a ) . " -->\n<p{$c}>{$html}</p>\n<!-- /wp:paragraph -->\n";
}

function fewo_b_h( $html, $level = 2, $class = '' ) {
	$a = array();
	if ( 2 !== $level ) {
		$a['level'] = $level;
	}
	if ( $class ) {
		$a['className'] = $class;
	}
	$cls = trim( 'wp-block-heading ' . $class );
	return "<!-- wp:heading" . fewo_b_attrs( $a ) . " -->\n<h{$level} class=\"{$cls}\">{$html}</h{$level}>\n<!-- /wp:heading -->\n";
}

function fewo_b_img( $m, $alt, $class = '', $caption = '' ) {
	$a = array( 'id' => (int) $m['id'], 'sizeSlug' => 'large', 'linkDestination' => 'none' );
	if ( $class ) {
		$a['className'] = $class;
	}
	$cls = trim( 'wp-block-image size-large ' . $class );
	$cap = $caption ? '<figcaption class="wp-element-caption">' . $caption . '</figcaption>' : '';
	return "<!-- wp:image" . fewo_b_attrs( $a ) . " -->\n<figure class=\"{$cls}\"><img src=\"" . esc_url( $m['url'] ) . '" alt="' . esc_attr( wp_strip_all_tags( $alt ) ) . '" class="wp-image-' . (int) $m['id'] . "\"/>{$cap}</figure>\n<!-- /wp:image -->\n";
}

function fewo_b_group( $inner, $class = '', $tag = 'div', $id = '', $lock = false ) {
	$a = array();
	if ( 'div' !== $tag ) {
		$a['tagName'] = $tag;
	}
	if ( $lock ) {
		$a['templateLock'] = 'contentOnly';
	}
	if ( $class ) {
		$a['className'] = $class;
	}
	$idattr = $id ? ' id="' . esc_attr( $id ) . '"' : '';
	$cls    = trim( 'wp-block-group ' . $class );
	return "<!-- wp:group" . fewo_b_attrs( $a ) . " -->\n<{$tag}{$idattr} class=\"{$cls}\">{$inner}</{$tag}>\n<!-- /wp:group -->\n";
}

function fewo_b_buttons( $buttons ) {
	$inner = '';
	foreach ( $buttons as $b ) {
		list( $text, $href, $class ) = $b;
		$a     = array( 'className' => $class );
		$extra = isset( $b[3] ) && $b[3] ? ' target="_blank" rel="noreferrer noopener"' : '';
		$inner .= "<!-- wp:button" . fewo_b_attrs( $a ) . " -->\n<div class=\"wp-block-button {$class}\"><a class=\"wp-block-button__link wp-element-button\" href=\"" . esc_url( $href ) . "\"{$extra}>{$text}</a></div>\n<!-- /wp:button -->";
	}
	return "<!-- wp:buttons -->\n<div class=\"wp-block-buttons\">{$inner}</div>\n<!-- /wp:buttons -->\n";
}

function fewo_b_list( $items ) {
	$inner = '';
	foreach ( $items as $i ) {
		$inner .= "<!-- wp:list-item -->\n<li>{$i}</li>\n<!-- /wp:list-item -->";
	}
	return "<!-- wp:list -->\n<ul class=\"wp-block-list\">{$inner}</ul>\n<!-- /wp:list -->\n";
}

function fewo_b_details( $q, $a ) {
	return "<!-- wp:details -->\n<details class=\"wp-block-details\"><summary>{$q}</summary>" . fewo_b_p( $a ) . "</details>\n<!-- /wp:details -->\n";
}

function fewo_b_gallery( $images ) {
	$inner = '';
	foreach ( $images as $img ) {
		list( $m, $cap ) = $img;
		$a      = array( 'id' => (int) $m['id'], 'sizeSlug' => 'large', 'linkDestination' => 'none' );
		$inner .= "<!-- wp:image" . fewo_b_attrs( $a ) . " -->\n<figure class=\"wp-block-image size-large\"><img src=\"" . esc_url( $m['url'] ) . '" alt="' . esc_attr( wp_strip_all_tags( $cap ) ) . '" class="wp-image-' . (int) $m['id'] . "\"/><figcaption class=\"wp-element-caption\">{$cap}</figcaption></figure>\n<!-- /wp:image -->\n\n";
	}
	$a = array( 'linkTo' => 'none', 'className' => 'fewo-gallery' );
	return "<!-- wp:gallery" . fewo_b_attrs( $a ) . " -->\n<figure class=\"wp-block-gallery has-nested-images columns-default is-cropped fewo-gallery\">{$inner}</figure>\n<!-- /wp:gallery -->\n";
}

function fewo_b_dynamic( $name ) {
	return "<!-- wp:fewo/{$name} /-->\n";
}

/**
 * Startseite als Block-Markup.
 *
 * @param string $lang  de|en|nl
 * @param array  $media Schlüssel => array( id, url )
 */
function fewo_front_content( $lang, $media ) {
	$t = fewo_content_texts( $lang );

	// HERO
	$copy  = fewo_b_dynamic( 'saison' );
	$copy .= fewo_b_p( 'Riezlern · Kleinwalsertal', 'eyebrow' );
	$copy .= fewo_b_h( $t['h1S'], 1, 'season-summer' );
	$copy .= fewo_b_h( $t['h1W'], 1, 'season-winter' );
	$copy .= fewo_b_p( $t['leadS'], 'lead season-summer' );
	$copy .= fewo_b_p( $t['leadW'], 'lead season-winter' );
	$copy .= fewo_b_buttons( array( array( $t['cta1'], '#buchen', 'fewo-btn-primary' ), array( $t['cta2'], '#wohnung', 'fewo-btn-light' ) ) );

	$visual  = fewo_b_img( $media['hero-summer'], 'Ferienwohnung Elias', 'hero-img season-summer' );
	$visual .= fewo_b_img( $media['hero-winter'], 'Ferienwohnung Elias', 'hero-img season-winter' );
	$visual .= fewo_b_group( fewo_b_p( '<strong>0 m</strong><br>' . $t['fc1'] ), 'float-card fc1' );
	$visual .= fewo_b_group( fewo_b_p( '<strong>' . $t['fc2b'] . '</strong><br>' . $t['fc2'] ), 'float-card fc2' );

	$facts = '';
	foreach ( array( array( '64', $t['f1'] ), array( '2', $t['f2'] ), array( '5', $t['f3'] ), array( '3', $t['f4'] ) ) as $f ) {
		$facts .= fewo_b_group( fewo_b_p( $f[0], 'fact-num' ) . fewo_b_p( $f[1], 'fact-label' ), 'fact' );
	}

	$hero = fewo_b_group(
		fewo_b_group( fewo_b_group( $copy, 'hero-copy' ) . fewo_b_group( $visual, 'hero-visual' ), 'hero-grid' ) . fewo_b_group( $facts, 'facts' ),
		'fewo-hero', 'section', 'start', true
	);

	// WOHNUNG / GALERIE
	$keys = array( 'g1', 'g2', 'g3', 'g4', 'g5', 'g6', 'g7', 'g8' );
	$imgs = array();
	foreach ( $keys as $i => $k ) {
		$imgs[] = array( $media[ $k ], $t['g'][ $i ] );
	}
	$apt = fewo_b_group(
		fewo_b_p( $t['aptE'], 'eyebrow' ) . fewo_b_h( $t['aptH'] ) . fewo_b_p( $t['aptP'], 'intro' ) . fewo_b_gallery( $imgs ),
		'fewo-section', 'section', 'wohnung'
	);

	// AUSSTATTUNG
	$cards = '';
	foreach ( $t['am'] as $i => $c ) {
		$cards .= fewo_b_group( fewo_b_h( $c[0], 3 ) . fewo_b_list( $c[1] ), 'amen-card ic-' . ( $i + 1 ) );
	}
	$amen = fewo_b_group(
		fewo_b_p( $t['amE'], 'eyebrow' ) . fewo_b_h( $t['amH'] ) . fewo_b_p( $t['amP'], 'intro' ) . fewo_b_group( $cards, 'grid-3' ) . fewo_b_p( $t['amN'], 'note' ),
		'fewo-section bg-sand', 'section', 'ausstattung', true
	);

	// BUCHUNG
	$book = fewo_b_group(
		fewo_b_p( $t['bkE'], 'eyebrow' ) . fewo_b_h( $t['bkH'] ) . fewo_b_p( $t['bkP'], 'intro' ) . fewo_b_dynamic( 'buchung' ),
		'fewo-section', 'section', 'buchen', true
	);

	// UMGEBUNG
	$tiles = function ( $list, $imgkeys, $class ) use ( $media ) {
		$out = '';
		foreach ( $list as $i => $tile ) {
			$out .= fewo_b_group( fewo_b_img( $media[ $imgkeys[ $i ] ], $tile[0] ) . fewo_b_group( fewo_b_h( $tile[0], 3 ) . fewo_b_p( $tile[1] ), 'tile-body' ), 'tile' );
		}
		return fewo_b_group( $out, 'grid-3 ' . $class );
	};
	$map  = fewo_b_group( fewo_b_h( 'Eggstraße 15, 6991 Riezlern', 3 ) . fewo_b_p( $t['mapP'] ), 'map-text' );
	$map .= fewo_b_buttons( array( array( $t['mapB'], 'https://www.google.com/maps/search/?api=1&query=Eggstra%C3%9Fe+15+6991+Riezlern', 'fewo-btn-apricot', true ) ) );
	$area = fewo_b_group(
		fewo_b_p( $t['arE'], 'eyebrow' ) . fewo_b_h( $t['arHS'], 2, 'season-summer' ) . fewo_b_h( $t['arHW'], 2, 'season-winter' ) . fewo_b_p( $t['arP'], 'intro' )
		. $tiles( $t['tS'], array( 's1', 's2', 's3' ), 'season-summer' )
		. $tiles( $t['tW'], array( 'w1', 'w2', 'w3' ), 'season-winter' )
		. fewo_b_group( $map, 'map-card' ),
		'fewo-section bg-sand', 'section', 'umgebung', true
	);

	// FAQ
	$q = '';
	foreach ( $t['fq'] as $f ) {
		$q .= fewo_b_details( $f[0], $f[1] );
	}
	$faq = fewo_b_group( fewo_b_p( $t['fqE'], 'eyebrow' ) . fewo_b_h( $t['fqH'] ) . fewo_b_group( $q, 'faq-list' ), 'fewo-section', 'section', 'faq' );

	// KONTAKT
	$contact = fewo_b_group(
		fewo_b_group(
			fewo_b_group( fewo_b_p( $t['ctE'], 'eyebrow' ) . fewo_b_h( $t['ctH'] ) . fewo_b_p( $t['ctP'], 'intro' ) . fewo_b_p( $t['host'], 'host' ), 'contact-copy' )
			. fewo_b_dynamic( 'anfrage' ),
			'contact'
		),
		'fewo-section pt-0', 'section', 'kontakt', true
	);

	return $hero . "\n" . $apt . "\n" . $amen . "\n" . $book . "\n" . $area . "\n" . $faq . "\n" . $contact;
}

/**
 * Impressum (Deutsch) – Inhalte aus der bisherigen Website.
 */
function fewo_imprint_content() {
	return fewo_b_h( 'Angaben gemäß § 5 ECG' )
		. fewo_b_p( 'Familie Grabherr-Mathis<br>Ferienwohnung Elias<br>Eggstraße 15<br>A-6991 Riezlern<br>Österreich' )
		. fewo_b_h( 'Kontakt' )
		. fewo_b_p( 'Telefon: +43 5517 3193<br>Mobil: +43 650 5173194<br>E-Mail: <a href="mailto:fewoelias@gmail.com">fewoelias@gmail.com</a>' )
		. fewo_b_h( 'Haftung für Inhalte' )
		. fewo_b_p( 'Die Inhalte dieser Website wurden mit größtmöglicher Sorgfalt erstellt. Für die Richtigkeit, Vollständigkeit und Aktualität der Inhalte können wir jedoch keine Gewähr übernehmen.' )
		. fewo_b_h( 'Haftung für Links' )
		. fewo_b_p( 'Diese Website enthält Links zu externen Websites Dritter, auf deren Inhalte wir keinen Einfluss haben. Für diese fremden Inhalte können wir daher keine Gewähr übernehmen.' )
		. fewo_b_h( 'Bildnachweis' )
		. fewo_b_p( 'Die auf dieser Website verwendeten Fotografien zeigen die Ferienwohnung Elias und ihre Umgebung.' );
}

/**
 * Datenschutzerklärung (Deutsch) – an die WordPress-Version angepasst.
 */
function fewo_privacy_content() {
	return fewo_b_h( 'Verantwortliche Stelle' )
		. fewo_b_p( 'Familie Grabherr-Mathis<br>Ferienwohnung Elias<br>Eggstraße 15<br>A-6991 Riezlern, Österreich<br>E-Mail: <a href="mailto:fewoelias@gmail.com">fewoelias@gmail.com</a>' )
		. fewo_b_h( 'Hosting und Server-Protokolle' )
		. fewo_b_p( 'Diese Website wird bei der Hostinger International Ltd. betrieben. Beim Aufruf der Website verarbeitet der Server technisch notwendige Daten (z. B. IP-Adresse, Datum und Uhrzeit, aufgerufene Seite, Browsertyp) in Protokolldateien, um den sicheren Betrieb zu gewährleisten (Art. 6 Abs. 1 lit. f DSGVO).' )
		. fewo_b_h( 'Anfrageformular' )
		. fewo_b_p( 'Wenn Sie uns über das Anfrageformular kontaktieren, werden die von Ihnen angegebenen Daten (Name, E-Mail-Adresse, gewünschter Zeitraum, Personenzahl und Ihre Nachricht) zur Bearbeitung Ihrer Anfrage und für Anschlussfragen per E-Mail an uns übermittelt und bei uns gespeichert. Diese Daten geben wir nicht ohne Ihre Einwilligung weiter.' )
		. fewo_b_p( 'Die Verarbeitung erfolgt auf Grundlage Ihrer Einwilligung (Art. 6 Abs. 1 lit. a DSGVO) bzw. zur Durchführung vorvertraglicher Maßnahmen (Art. 6 Abs. 1 lit. b DSGVO).' )
		. fewo_b_h( 'Cookies' )
		. fewo_b_p( 'Diese Website verwendet keine Cookies zu Analyse- oder Marketingzwecken. Es wird lediglich ein technisch notwendiges Cookie gesetzt, das sich Ihre gewählte Sprache merkt.' )
		. fewo_b_h( 'Schriftarten' )
		. fewo_b_p( 'Die verwendeten Schriftarten werden direkt von unserem Server geladen. Es findet keine Verbindung zu Servern von Google oder anderen Anbietern statt.' )
		. fewo_b_h( 'Google Maps' )
		. fewo_b_p( 'Über die Schaltfläche „Route planen“ gelangen Sie zu Google Maps (Google Ireland Limited). Erst wenn Sie darauf klicken, werden Daten an Google übermittelt. Informationen dazu finden Sie unter <a href="https://policies.google.com/privacy">policies.google.com/privacy</a>.' )
		. fewo_b_h( 'Ihre Rechte' )
		. fewo_b_p( 'Sie haben jederzeit das Recht auf Auskunft, Berichtigung, Löschung oder Einschränkung der Verarbeitung Ihrer bei uns gespeicherten personenbezogenen Daten sowie ein Widerspruchsrecht und das Recht auf Datenübertragbarkeit. Kontaktieren Sie uns dazu unter der oben genannten E-Mail-Adresse. Sie haben außerdem das Recht, sich bei der Österreichischen Datenschutzbehörde zu beschweren.' );
}
