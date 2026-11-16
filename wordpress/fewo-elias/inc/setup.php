<?php
/**
 * Einrichtung per Knopfdruck: Bilder in die Mediathek, Seiten anlegen,
 * Startseite festlegen und (wenn Polylang aktiv ist) Sprachen verknüpfen.
 */

defined( 'ABSPATH' ) || exit;

function fewo_setup_images() {
	return array(
		'hero-summer' => 'hero-haus.webp',
		'hero-winter' => 'galerie-winter-1.webp',
		'g1' => 'wohnzimmer-1.webp',
		'g2' => 'kueche-1.webp',
		'g3' => 'schlafzimmer-1.webp',
		'g4' => 'terrasse-1.webp',
		'g5' => 'schlafzimmer-2.webp',
		'g6' => 'bad-1.webp',
		'g7' => 'wohnzimmer-2.webp',
		'g8' => 'galerie-aussicht.webp',
		's1' => 'galerie-sommer-1.webp',
		's2' => 'lage-tal-aussicht.webp',
		's3' => 'galerie-sommer-2.webp',
		'w1' => 'lage-winter.webp',
		'w2' => 'galerie-winter-2.webp',
		'w3' => 'galerie-winter-1.webp',
	);
}

/**
 * Kopiert die mitgelieferten Fotos einmalig in die Mediathek.
 */
function fewo_import_media() {
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$done  = (array) get_option( 'fewo_media', array() );
	$files = array();
	foreach ( fewo_setup_images() as $key => $file ) {
		if ( ! empty( $done[ $file ] ) && get_post( $done[ $file ] ) ) {
			continue;
		}
		$src = FEWO_DIR . '/assets/img/' . $file;
		if ( ! file_exists( $src ) || isset( $files[ $file ] ) ) {
			continue;
		}
		$files[ $file ] = true;
		$up             = wp_upload_bits( $file, null, file_get_contents( $src ) ); // phpcs:ignore
		if ( ! empty( $up['error'] ) ) {
			continue;
		}
		$id = wp_insert_attachment(
			array(
				'post_mime_type' => 'image/webp',
				'post_title'     => preg_replace( '/\.\w+$/', '', $file ),
				'post_status'    => 'inherit',
			),
			$up['file']
		);
		if ( $id && ! is_wp_error( $id ) ) {
			wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $up['file'] ) );
			$done[ $file ] = $id;
		}
	}
	update_option( 'fewo_media', $done, false );

	$media = array();
	foreach ( fewo_setup_images() as $key => $file ) {
		$id            = isset( $done[ $file ] ) ? (int) $done[ $file ] : 0;
		$url           = $id ? wp_get_attachment_image_url( $id, 'large' ) : '';
		$media[ $key ] = array(
			'id'  => $id,
			'url' => $url ? $url : FEWO_URI . '/assets/img/' . $file,
		);
	}
	return $media;
}

function fewo_pll_languages() {
	if ( ! function_exists( 'pll_languages_list' ) ) {
		return array();
	}
	return (array) pll_languages_list( array( 'fields' => 'slug' ) );
}

/**
 * Seite anlegen, falls sie noch nicht existiert. Gibt die ID zurück.
 */
function fewo_ensure_page( $key, $title, $content, $status ) {
	$pages = (array) get_option( 'fewo_pages', array() );
	if ( ! empty( $pages[ $key ] ) && get_post( $pages[ $key ] ) && 'trash' !== get_post_status( $pages[ $key ] ) ) {
		$id = (int) $pages[ $key ];
		if ( 'publish' === $status && 'publish' !== get_post_status( $id ) ) {
			wp_update_post( array( 'ID' => $id, 'post_status' => 'publish' ) );
		}
		return $id;
	}
	$id = wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_title'   => $title,
			'post_content' => $content,
			'post_status'  => $status,
		)
	);
	if ( $id && ! is_wp_error( $id ) ) {
		$pages[ $key ] = $id;
		update_option( 'fewo_pages', $pages, false );
	}
	return (int) $id;
}

function fewo_run_setup() {
	$media = fewo_import_media();
	$langs = fewo_pll_languages();
	$pll   = count( array_intersect( array( 'de', 'en', 'nl' ), $langs ) ) === 3;

	$ids = array();
	foreach ( array( 'de', 'en', 'nl' ) as $lang ) {
		$t            = fewo_content_texts( $lang );
		$status       = ( 'de' === $lang || $pll ) ? 'publish' : 'draft';
		$title        = 'de' === $lang ? $t['pageTitle'] : $t['pageTitle'] . ' (' . strtoupper( $lang ) . ')';
		$ids[ $lang ] = fewo_ensure_page( 'front_' . $lang, $title, fewo_front_content( $lang, $media ), $status );
	}
	$imprint = fewo_ensure_page( 'imprint', 'Impressum', fewo_imprint_content(), 'publish' );
	$privacy = fewo_ensure_page( 'privacy', 'Datenschutz', fewo_privacy_content(), 'publish' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $ids['de'] );
	update_option( 'wp_page_for_privacy_policy', $privacy );

	if ( ! get_option( 'fewo_settings' ) ) {
		update_option( 'fewo_settings', fewo_settings_defaults(), false );
	}

	if ( $pll && function_exists( 'pll_set_post_language' ) ) {
		foreach ( $ids as $lang => $id ) {
			pll_set_post_language( $id, $lang );
		}
		pll_set_post_language( $imprint, 'de' );
		pll_set_post_language( $privacy, 'de' );
		pll_save_post_translations( $ids );
		return 'Fertig: Seiten angelegt, Startseite festgelegt und Deutsch, Englisch und Niederländisch verknüpft.';
	}

	return 'Fertig: Seiten angelegt und Startseite festgelegt. Die englische und niederländische Startseite liegen als Entwurf bereit. Sobald Polylang mit den Sprachen DE, EN und NL eingerichtet ist, hier nochmal klicken.';
}

/**
 * Übersicht, was schon eingerichtet ist.
 */
function fewo_setup_status_html() {
	$pages = (array) get_option( 'fewo_pages', array() );
	$langs = fewo_pll_languages();
	$items = array(
		array( ! empty( $pages['front_de'] ), 'Seiten angelegt (Startseite DE/EN/NL, Impressum, Datenschutz)' ),
		array( function_exists( 'pll_current_language' ), 'Plugin „Polylang“ installiert und aktiviert' ),
		array( count( array_intersect( array( 'de', 'en', 'nl' ), $langs ) ) === 3, 'In Polylang die Sprachen Deutsch, English und Nederlands angelegt' ),
	);
	$out = '<ul class="fewo-status">';
	foreach ( $items as $i ) {
		$out .= '<li class="' . ( $i[0] ? 'ok' : 'todo' ) . '">' . ( $i[0] ? '✔ ' : '○ ' ) . esc_html( $i[1] ) . '</li>';
	}
	$out .= '</ul><p class="description">Der Knopf kann gefahrlos mehrmals gedrückt werden – bestehende Seiten und eure Änderungen bleiben erhalten.</p>';
	return $out;
}

/* Hinweis nach dem Aktivieren des Themes. */
add_action(
	'admin_notices',
	function () {
		if ( ! current_user_can( 'manage_options' ) || get_option( 'fewo_pages' ) ) {
			return;
		}
		$screen = get_current_screen();
		if ( $screen && 'toplevel_page_fewo' === $screen->id ) {
			return;
		}
		printf(
			'<div class="notice notice-info"><p><strong>Ferienwohnung Elias:</strong> Theme aktiv. <a href="%s">Jetzt die Website einrichten →</a></p></div>',
			esc_url( admin_url( 'admin.php?page=fewo' ) )
		);
	}
);
