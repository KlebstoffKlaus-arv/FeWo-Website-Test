<?php
/**
 * Ferienwohnung Elias – Theme-Funktionen.
 */

defined( 'ABSPATH' ) || exit;

define( 'FEWO_VERSION', '1.0.0' );
define( 'FEWO_DIR', get_template_directory() );
define( 'FEWO_URI', get_template_directory_uri() );
define( 'FEWO_LOGO_W', 440 );
define( 'FEWO_LOGO_H', 263 );

require FEWO_DIR . '/inc/strings.php';
require FEWO_DIR . '/inc/content.php';
require FEWO_DIR . '/inc/settings.php';
require FEWO_DIR . '/inc/blocks.php';
require FEWO_DIR . '/inc/form.php';
require FEWO_DIR . '/inc/setup.php';

/**
 * Aktuelle Sprache: de, en oder nl.
 */
function fewo_lang() {
	$lang = '';
	if ( function_exists( 'pll_current_language' ) ) {
		$lang = (string) pll_current_language( 'slug' );
	}
	// Ohne Polylang ist die Website deutsch (die Startseite ist auf Deutsch angelegt).
	return in_array( $lang, array( 'de', 'en', 'nl' ), true ) ? $lang : 'de';
}

/**
 * Startseiten-URL in der aktuellen Sprache.
 */
function fewo_home_url() {
	if ( function_exists( 'pll_home_url' ) ) {
		return pll_home_url();
	}
	return home_url( '/' );
}

add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'html5', array( 'style', 'script', 'gallery', 'caption' ) );
		add_theme_support( 'custom-logo', array( 'height' => 120, 'width' => 200, 'flex-width' => true, 'flex-height' => true ) );
		add_theme_support( 'editor-styles' );
		add_editor_style( array( 'assets/css/site.css', 'assets/css/editor.css' ) );
		remove_theme_support( 'core-block-patterns' );
	}
);

add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style( 'fewo-site', FEWO_URI . '/assets/css/site.css', array(), FEWO_VERSION );
		wp_enqueue_script( 'fewo-site', FEWO_URI . '/assets/js/site.js', array(), FEWO_VERSION, true );
		wp_add_inline_script( 'fewo-site', 'window.FEWO=' . wp_json_encode( fewo_js_data() ) . ';', 'before' );
		// Nicht benötigte WordPress-Extras weglassen.
		wp_dequeue_style( 'classic-theme-styles' );
	}
);

/**
 * Daten für die Skripte (Sprache, Texte, Einstellungen).
 */
function fewo_js_data() {
	$lang = fewo_lang();
	$s    = fewo_settings();
	return array(
		'lang'     => $lang,
		'locale'   => array( 'de' => 'de-AT', 'en' => 'en-GB', 'nl' => 'nl-NL' )[ $lang ],
		't'        => fewo_strings( $lang ),
		'prices'   => array(
			'base'     => (float) $s['price'],
			'cleaning' => (float) $s['cleaning'],
			'tax'      => (float) $s['tax'],
			'minNights'=> (int) $s['min_nights'],
			'seasons'  => array_values( $s['seasons'] ),
		),
		'booked'   => array_values( $s['bookings_public'] ),
		'formUrl'  => esc_url_raw( rest_url( 'fewo/v1/anfrage' ) ),
	);
}

/* Sommer/Winter schon vor dem ersten Anzeigen setzen (kein Flackern). */
add_action(
	'wp_body_open',
	function () {
		echo "<script>(function(){var m=new Date().getMonth();document.body.classList.add(m>=10||m<=2?'winter':'summer');document.documentElement.classList.add('js');})();</script>\n";
	}
);

/* Keine Kommentare auf dieser Website. */
add_action(
	'init',
	function () {
		remove_post_type_support( 'page', 'comments' );
		remove_post_type_support( 'post', 'comments' );
	}
);
add_filter( 'comments_open', '__return_false' );

/* Emojis-Skript und unnötige Header-Einträge entfernen (schneller, weniger Fremdverbindungen). */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'wp_generator' );

/* Vorschaubild für geteilte Links. */
add_action(
	'wp_head',
	function () {
		$img = FEWO_URI . '/assets/img/hero-haus.webp';
		printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $img ) );
		printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( wp_get_document_title() ) );
		printf( '<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n", esc_url( FEWO_URI . '/assets/fonts/bricolage-grotesque-latin-wght-normal.woff2' ) );
	},
	2
);

/**
 * Logo ausgeben: eigenes Logo aus dem Customizer oder das mitgelieferte.
 */
function fewo_logo() {
	$label = 'Ferienwohnung Elias';
	if ( has_custom_logo() ) {
		$id = get_theme_mod( 'custom_logo' );
		printf(
			'<a class="logo logo-custom" href="%s" aria-label="%s">%s</a>',
			esc_url( fewo_home_url() ),
			esc_attr( $label ),
			wp_get_attachment_image( $id, 'medium', false, array( 'alt' => $label ) )
		);
		return;
	}
	printf(
		'<a class="logo" href="%s" aria-label="%s"><img src="%s" alt="%s" width="%d" height="%d"></a>',
		esc_url( fewo_home_url() ),
		esc_attr( $label ),
		esc_url( FEWO_URI . '/assets/img/logo.png' ),
		esc_attr( $label ),
		FEWO_LOGO_W,
		FEWO_LOGO_H
	);
}

/**
 * Link zu einem Abschnitt der Startseite (#wohnung usw.).
 */
function fewo_anchor( $id ) {
	return is_front_page() ? '#' . $id : trailingslashit( fewo_home_url() ) . '#' . $id;
}
