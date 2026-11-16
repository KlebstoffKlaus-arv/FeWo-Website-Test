<?php
/**
 * Wird nur von WordPress Playground ausgeführt (siehe blueprint.json):
 * legt in Polylang Deutsch, Englisch und Niederländisch an und richtet die Website ein.
 * Auf dem echten Server wird diese Datei nicht gebraucht.
 */
define( 'WP_ADMIN', true );
require '/wordpress/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/admin.php';
wp_set_current_user( 1 );

update_option( 'permalink_structure', '/%postname%/' );

$langs = array(
	array( 'name' => 'Deutsch', 'slug' => 'de', 'locale' => 'de_DE', 'rtl' => 0, 'term_group' => 0, 'flag' => 'at' ),
	array( 'name' => 'English', 'slug' => 'en', 'locale' => 'en_GB', 'rtl' => 0, 'term_group' => 1, 'flag' => 'gb' ),
	array( 'name' => 'Nederlands', 'slug' => 'nl', 'locale' => 'nl_NL', 'rtl' => 0, 'term_group' => 2, 'flag' => 'nl' ),
);

if ( function_exists( 'PLL' ) && PLL() ) {
	$model = PLL()->model;
	foreach ( $langs as $args ) {
		try {
			if ( isset( $model->languages ) && is_object( $model->languages ) && method_exists( $model->languages, 'add' ) ) {
				$model->languages->add( $args );
			} elseif ( method_exists( $model, 'add_language' ) ) {
				$model->add_language( $args );
			} elseif ( class_exists( 'PLL_Admin_Model' ) ) {
				( new PLL_Admin_Model( get_option( 'polylang' ) ) )->add_language( $args );
			}
		} catch ( Throwable $e ) {
			error_log( 'Polylang: ' . $e->getMessage() );
		}
	}
	if ( method_exists( $model, 'clean_languages_cache' ) ) {
		$model->clean_languages_cache();
	}
	delete_transient( 'pll_languages_list' );
}

if ( function_exists( 'fewo_run_setup' ) ) {
	echo fewo_run_setup();
}

// Beispielwerte, damit Preisrechner und Kalender etwas zeigen.
$d = function ( $n ) { return gmdate( 'Y-m-d', strtotime( "+$n days" ) ); };
update_option(
	'fewo_settings',
	array(
		'price'      => 94,
		'cleaning'   => 60,
		'tax'        => 0,
		'min_nights' => 3,
		'email'      => 'fewoelias@gmail.com',
		'seasons'    => array(),
		'bookings'   => array(
			array( 'from' => $d( 9 ), 'to' => $d( 14 ), 'note' => 'Beispiel' ),
			array( 'from' => $d( 24 ), 'to' => $d( 31 ), 'note' => 'Beispiel' ),
		),
	),
	false
);

flush_rewrite_rules();
