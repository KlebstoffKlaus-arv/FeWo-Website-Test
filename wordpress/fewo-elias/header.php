<?php
defined( 'ABSPATH' ) || exit;
$t = fewo_strings( fewo_lang() );
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php echo esc_html( 'de' === fewo_lang() ? 'Zum Inhalt springen' : ( 'nl' === fewo_lang() ? 'Naar de inhoud' : 'Skip to content' ) ); ?></a>
<header class="site-header<?php echo is_front_page() ? '' : ' scrolled solid'; ?>" id="site-header">
	<div class="wrap nav">
		<?php fewo_logo(); ?>
		<div class="nav-right">
			<nav class="links" id="links" aria-label="<?php echo esc_attr( $t['menuAria'] ); ?>">
				<a href="<?php echo esc_url( fewo_anchor( 'wohnung' ) ); ?>"><?php echo esc_html( $t['navApt'] ); ?></a>
				<a href="<?php echo esc_url( fewo_anchor( 'ausstattung' ) ); ?>"><?php echo esc_html( $t['navAmen'] ); ?></a>
				<a href="<?php echo esc_url( fewo_anchor( 'buchen' ) ); ?>"><?php echo esc_html( $t['navBook'] ); ?></a>
				<a href="<?php echo esc_url( fewo_anchor( 'umgebung' ) ); ?>"><?php echo esc_html( $t['navArea'] ); ?></a>
				<a href="<?php echo esc_url( fewo_anchor( 'faq' ) ); ?>"><?php echo esc_html( $t['navFaq'] ); ?></a>
				<a class="btn btn-primary" href="<?php echo esc_url( fewo_anchor( 'kontakt' ) ); ?>"><?php echo esc_html( $t['navCta'] ); ?></a>
			</nav>
			<?php
			if ( function_exists( 'pll_the_languages' ) ) {
				$langs = pll_the_languages( array( 'raw' => 1, 'hide_if_empty' => 0, 'hide_if_no_translation' => 0 ) );
				if ( is_array( $langs ) && count( $langs ) > 1 ) {
					echo '<div class="lang" aria-label="' . esc_attr( $t['langAria'] ) . '">';
					foreach ( $langs as $l ) {
						printf(
							'<a href="%s" hreflang="%s" lang="%s"%s>%s</a>',
							esc_url( $l['url'] ),
							esc_attr( $l['slug'] ),
							esc_attr( $l['slug'] ),
							! empty( $l['current_lang'] ) ? ' aria-current="true"' : '',
							esc_html( strtoupper( $l['slug'] ) )
						);
					}
					echo '</div>';
				}
			}
			?>
			<button class="menu-btn" type="button" aria-label="<?php echo esc_attr( $t['menuOpen'] ); ?>" aria-expanded="false" aria-controls="links">
				<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
			</button>
		</div>
	</div>
</header>
<main id="main">
