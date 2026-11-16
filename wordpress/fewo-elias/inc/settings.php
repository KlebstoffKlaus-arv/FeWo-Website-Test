<?php
/**
 * Einstellungsseite „Ferienwohnung“: Preise, Saisonpreise, Belegung, E-Mail.
 * Zugänglich für Administratoren und Redakteure.
 */

defined( 'ABSPATH' ) || exit;

function fewo_settings_defaults() {
	return array(
		'price'      => 0,
		'cleaning'   => 0,
		'tax'        => 0,
		'min_nights' => 1,
		'email'      => 'fewoelias@gmail.com',
		'seasons'    => array(),
		'bookings'   => array(),
	);
}

/**
 * Gespeicherte Einstellungen, bereinigt. 'bookings_public' enthält nur Datumsangaben (ohne Notizen).
 */
function fewo_settings() {
	$s = wp_parse_args( (array) get_option( 'fewo_settings', array() ), fewo_settings_defaults() );

	$s['seasons']  = is_array( $s['seasons'] ) ? $s['seasons'] : array();
	$s['bookings'] = is_array( $s['bookings'] ) ? $s['bookings'] : array();

	$s['bookings_public'] = array();
	foreach ( $s['bookings'] as $b ) {
		if ( ! empty( $b['from'] ) && ! empty( $b['to'] ) ) {
			$s['bookings_public'][] = array( 'from' => $b['from'], 'to' => $b['to'] );
		}
	}
	return $s;
}

function fewo_valid_date( $d ) {
	return is_string( $d ) && preg_match( '/^\d{4}-\d{2}-\d{2}$/', $d ) ? $d : '';
}

add_action(
	'admin_menu',
	function () {
		add_menu_page(
			'Ferienwohnung',
			'Ferienwohnung',
			'edit_pages',
			'fewo',
			'fewo_settings_page',
			'dashicons-admin-home',
			3
		);
	}
);

add_action(
	'admin_enqueue_scripts',
	function ( $hook ) {
		if ( 'toplevel_page_fewo' !== $hook ) {
			return;
		}
		wp_enqueue_style( 'fewo-admin', FEWO_URI . '/assets/css/admin.css', array(), FEWO_VERSION );
		wp_enqueue_script( 'fewo-admin', FEWO_URI . '/assets/js/admin.js', array(), FEWO_VERSION, true );
	}
);

/**
 * Speichern.
 */
function fewo_settings_save() {
	if ( ! current_user_can( 'edit_pages' ) ) {
		return;
	}
	check_admin_referer( 'fewo_save', 'fewo_nonce' );

	$in  = wp_unslash( $_POST );
	$num = function ( $v ) {
		$v = str_replace( ',', '.', (string) $v );
		return max( 0, round( (float) $v, 2 ) );
	};

	$s               = fewo_settings_defaults();
	$s['price']      = $num( $in['price'] ?? 0 );
	$s['cleaning']   = $num( $in['cleaning'] ?? 0 );
	$s['tax']        = $num( $in['tax'] ?? 0 );
	$s['min_nights'] = max( 1, (int) ( $in['min_nights'] ?? 1 ) );
	$email           = sanitize_email( $in['email'] ?? '' );
	$s['email']      = is_email( $email ) ? $email : get_option( 'admin_email' );

	$rows = isset( $in['season'] ) && is_array( $in['season'] ) ? $in['season'] : array();
	foreach ( $rows as $r ) {
		$from = fewo_valid_date( $r['from'] ?? '' );
		$to   = fewo_valid_date( $r['to'] ?? '' );
		if ( $from && $to && $to >= $from ) {
			$s['seasons'][] = array(
				'name'  => sanitize_text_field( $r['name'] ?? '' ),
				'from'  => $from,
				'to'    => $to,
				'price' => $num( $r['price'] ?? 0 ),
			);
		}
	}
	usort( $s['seasons'], fn( $a, $b ) => strcmp( $a['from'], $b['from'] ) );

	$rows   = isset( $in['booking'] ) && is_array( $in['booking'] ) ? $in['booking'] : array();
	$cutoff = gmdate( 'Y-m-d', strtotime( '-60 days' ) );
	foreach ( $rows as $r ) {
		$from = fewo_valid_date( $r['from'] ?? '' );
		$to   = fewo_valid_date( $r['to'] ?? '' );
		if ( $from && $to && $to > $from && $to >= $cutoff ) {
			$s['bookings'][] = array(
				'from' => $from,
				'to'   => $to,
				'note' => sanitize_text_field( $r['note'] ?? '' ),
			);
		}
	}
	usort( $s['bookings'], fn( $a, $b ) => strcmp( $a['from'], $b['from'] ) );

	update_option( 'fewo_settings', $s, false );
	add_settings_error( 'fewo', 'saved', 'Gespeichert. Die Website zeigt die Änderungen sofort an.', 'success' );
}

function fewo_settings_page() {
	if ( isset( $_POST['fewo_nonce'] ) ) {
		fewo_settings_save();
	}
	if ( isset( $_POST['fewo_setup_nonce'] ) && current_user_can( 'manage_options' ) ) {
		check_admin_referer( 'fewo_setup', 'fewo_setup_nonce' );
		$msg = fewo_run_setup();
		add_settings_error( 'fewo', 'setup', $msg, 'success' );
	}

	$s   = fewo_settings();
	$fmt = fn( $v ) => $v ? str_replace( ',00', '', number_format( (float) $v, 2, ',', '' ) ) : '';
	?>
	<div class="wrap fewo-admin">
		<h1>Ferienwohnung – Preise &amp; Belegung</h1>
		<?php settings_errors( 'fewo' ); ?>

		<form method="post">
			<?php wp_nonce_field( 'fewo_save', 'fewo_nonce' ); ?>

			<div class="fewo-card">
				<h2>Belegung</h2>
				<p class="description">Hier tragt ihr gebuchte Zeiträume ein. Diese Tage erscheinen im Kalender auf der Website als belegt. Am Abreisetag kann der nächste Gast anreisen. Die Notiz sieht nur ihr, nicht die Gäste.</p>
				<table class="widefat fewo-rows" data-name="booking">
					<thead><tr><th>Anreise</th><th>Abreise</th><th>Notiz (intern, z. B. Name)</th><th></th></tr></thead>
					<tbody>
					<?php foreach ( $s['bookings'] as $i => $b ) : ?>
						<tr class="<?php echo $b['to'] < gmdate( 'Y-m-d' ) ? 'is-past' : ''; ?>">
							<td><input type="date" name="booking[<?php echo (int) $i; ?>][from]" value="<?php echo esc_attr( $b['from'] ); ?>" required></td>
							<td><input type="date" name="booking[<?php echo (int) $i; ?>][to]" value="<?php echo esc_attr( $b['to'] ); ?>" required></td>
							<td><input type="text" name="booking[<?php echo (int) $i; ?>][note]" value="<?php echo esc_attr( $b['note'] ); ?>"></td>
							<td><button type="button" class="button fewo-del" aria-label="Zeile löschen">Löschen</button></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
				<template id="tpl-booking">
					<tr>
						<td><input type="date" name="booking[__i__][from]" required></td>
						<td><input type="date" name="booking[__i__][to]" required></td>
						<td><input type="text" name="booking[__i__][note]"></td>
						<td><button type="button" class="button fewo-del" aria-label="Zeile löschen">Löschen</button></td>
					</tr>
				</template>
				<p><button type="button" class="button fewo-add" data-target="booking">+ Belegung hinzufügen</button></p>
				<p class="description">Vergangene Buchungen werden nach 60 Tagen automatisch entfernt.</p>
			</div>

			<div class="fewo-card">
				<h2>Preise</h2>
				<p class="description">Felder leer lassen oder 0 eintragen, wenn ein Betrag nicht angezeigt werden soll. Ohne Grundpreis steht auf der Website „Preis auf Anfrage“.</p>
				<table class="form-table" role="presentation">
					<tr><th><label for="price">Grundpreis pro Nacht (€)</label></th><td><input id="price" name="price" type="text" inputmode="decimal" value="<?php echo esc_attr( $fmt( $s['price'] ) ); ?>" class="small-text"> <span class="description">gilt, wenn kein Saisonpreis passt</span></td></tr>
					<tr><th><label for="cleaning">Endreinigung (€)</label></th><td><input id="cleaning" name="cleaning" type="text" inputmode="decimal" value="<?php echo esc_attr( $fmt( $s['cleaning'] ) ); ?>" class="small-text"> <span class="description">einmalig pro Aufenthalt</span></td></tr>
					<tr><th><label for="tax">Gästetaxe (€)</label></th><td><input id="tax" name="tax" type="text" inputmode="decimal" value="<?php echo esc_attr( $fmt( $s['tax'] ) ); ?>" class="small-text"> <span class="description">pro Erwachsenem und Nacht</span></td></tr>
					<tr><th><label for="min_nights">Mindestaufenthalt (Nächte)</label></th><td><input id="min_nights" name="min_nights" type="number" min="1" value="<?php echo (int) $s['min_nights']; ?>" class="small-text"></td></tr>
				</table>
			</div>

			<div class="fewo-card">
				<h2>Saisonpreise</h2>
				<p class="description">Optional: andere Preise für bestimmte Zeiträume, z. B. Weihnachten oder Hochsommer. Der Preisrechner verwendet automatisch den passenden Preis für jede Nacht.</p>
				<table class="widefat fewo-rows" data-name="season">
					<thead><tr><th>Bezeichnung</th><th>von</th><th>bis (einschließlich)</th><th>Preis pro Nacht (€)</th><th></th></tr></thead>
					<tbody>
					<?php foreach ( $s['seasons'] as $i => $r ) : ?>
						<tr>
							<td><input type="text" name="season[<?php echo (int) $i; ?>][name]" value="<?php echo esc_attr( $r['name'] ); ?>" placeholder="z. B. Hauptsaison Winter"></td>
							<td><input type="date" name="season[<?php echo (int) $i; ?>][from]" value="<?php echo esc_attr( $r['from'] ); ?>" required></td>
							<td><input type="date" name="season[<?php echo (int) $i; ?>][to]" value="<?php echo esc_attr( $r['to'] ); ?>" required></td>
							<td><input type="text" inputmode="decimal" name="season[<?php echo (int) $i; ?>][price]" value="<?php echo esc_attr( $fmt( $r['price'] ) ); ?>" class="small-text" required></td>
							<td><button type="button" class="button fewo-del" aria-label="Zeile löschen">Löschen</button></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
				<template id="tpl-season">
					<tr>
						<td><input type="text" name="season[__i__][name]" placeholder="z. B. Hauptsaison Winter"></td>
						<td><input type="date" name="season[__i__][from]" required></td>
						<td><input type="date" name="season[__i__][to]" required></td>
						<td><input type="text" inputmode="decimal" name="season[__i__][price]" class="small-text" required></td>
						<td><button type="button" class="button fewo-del" aria-label="Zeile löschen">Löschen</button></td>
					</tr>
				</template>
				<p><button type="button" class="button fewo-add" data-target="season">+ Saisonpreis hinzufügen</button></p>
			</div>

			<div class="fewo-card">
				<h2>Anfragen</h2>
				<table class="form-table" role="presentation">
					<tr><th><label for="email">Anfragen gehen an</label></th><td><input id="email" name="email" type="email" value="<?php echo esc_attr( $s['email'] ); ?>" class="regular-text"></td></tr>
				</table>
			</div>

			<p class="fewo-sticky"><button type="submit" class="button button-primary button-hero">Speichern</button></p>
		</form>

		<?php if ( current_user_can( 'manage_options' ) ) : ?>
			<div class="fewo-card fewo-setup">
				<h2>Website einrichten</h2>
				<?php echo wp_kses_post( fewo_setup_status_html() ); ?>
				<form method="post">
					<?php wp_nonce_field( 'fewo_setup', 'fewo_setup_nonce' ); ?>
					<p><button type="submit" class="button">Seiten anlegen / Sprachen verknüpfen</button></p>
				</form>
			</div>
		<?php endif; ?>
	</div>
	<?php
}
