<?php
/**
 * Anfrageformular: nimmt Anfragen entgegen und schickt sie per E-Mail.
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'fewo/v1',
			'/anfrage',
			array(
				'methods'             => 'POST',
				'callback'            => 'fewo_handle_enquiry',
				'permission_callback' => '__return_true',
			)
		);
	}
);

function fewo_handle_enquiry( WP_REST_Request $req ) {
	$p = $req->get_params();

	// Spam-Falle: Feld ist für Menschen unsichtbar.
	if ( ! empty( $p['website'] ) ) {
		return array( 'success' => true );
	}

	// Einfache Bremse: höchstens 5 Anfragen pro Stunde und Adresse.
	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$key = 'fewo_rl_' . md5( $ip );
	$cnt = (int) get_transient( $key );
	if ( $cnt >= 5 ) {
		return new WP_REST_Response( array( 'success' => false ), 429 );
	}
	set_transient( $key, $cnt + 1, HOUR_IN_SECONDS );

	$name    = sanitize_text_field( $p['name'] ?? '' );
	$email   = sanitize_email( $p['email'] ?? '' );
	$from    = fewo_valid_date( $p['from'] ?? '' );
	$to      = fewo_valid_date( $p['to'] ?? '' );
	$guests  = sanitize_text_field( $p['guests'] ?? '' );
	$message = sanitize_textarea_field( $p['message'] ?? '' );
	$lang    = in_array( $p['lang'] ?? '', array( 'de', 'en', 'nl' ), true ) ? $p['lang'] : 'de';
	$total   = sanitize_text_field( $p['estimate'] ?? '' );

	if ( '' === $name || ! is_email( $email ) || empty( $p['consent'] ) ) {
		return new WP_REST_Response( array( 'success' => false ), 400 );
	}

	$fmt = function ( $d ) {
		return $d ? date_i18n( 'd.m.Y', strtotime( $d ) ) : '–';
	};

	$body  = "Neue Anfrage über die Website:\n\n";
	$body .= "Name: {$name}\n";
	$body .= "E-Mail: {$email}\n";
	$body .= 'Anreise: ' . $fmt( $from ) . "\n";
	$body .= 'Abreise: ' . $fmt( $to ) . "\n";
	$body .= 'Personen: ' . ( $guests ? $guests : '–' ) . "\n";
	if ( $total ) {
		$body .= "Vom Preisrechner geschätzt: {$total}\n";
	}
	$body .= 'Sprache der Anfrage: ' . strtoupper( $lang ) . "\n\n";
	$body .= "Nachricht:\n" . ( $message ? $message : '–' ) . "\n\n";
	$body .= "Zum Antworten einfach auf diese E-Mail antworten.\n";

	$to_addr = fewo_settings()['email'];
	$subject = 'Anfrage Ferienwohnung Elias: ' . $name . ( $from ? ' (' . $fmt( $from ) . ' – ' . $fmt( $to ) . ')' : '' );
	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

	$ok = wp_mail( $to_addr, $subject, $body, $headers );

	return new WP_REST_Response( array( 'success' => (bool) $ok ), $ok ? 200 : 500 );
}
