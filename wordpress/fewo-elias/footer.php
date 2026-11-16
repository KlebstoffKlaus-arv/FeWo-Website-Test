<?php
defined( 'ABSPATH' ) || exit;
$t     = fewo_strings( fewo_lang() );
$pages = (array) get_option( 'fewo_pages', array() );
?>
</main>
<footer class="site-footer">
	<div class="wrap foot">
		<span>© <?php echo esc_html( gmdate( 'Y' ) ); ?> Ferienwohnung Elias · Familie Grabherr · Eggstraße 15, 6991 Riezlern</span>
		<nav aria-label="<?php echo esc_attr( $t['imprint'] . ' / ' . $t['privacyPage'] ); ?>">
			<?php if ( ! empty( $pages['imprint'] ) ) : ?>
				<a href="<?php echo esc_url( get_permalink( $pages['imprint'] ) ); ?>"><?php echo esc_html( $t['imprint'] ); ?></a>
			<?php endif; ?>
			<?php if ( get_privacy_policy_url() ) : ?>
				<a href="<?php echo esc_url( get_privacy_policy_url() ); ?>"><?php echo esc_html( $t['privacyPage'] ); ?></a>
			<?php endif; ?>
		</nav>
	</div>
</footer>
<?php if ( is_front_page() ) : ?>
<div class="mbar" id="mbar">
	<div><b class="price-night"></b> <span class="price-unit"><?php echo esc_html( $t['perNight'] ); ?></span></div>
	<a class="btn btn-primary" href="#buchen"><?php echo esc_html( $t['mbar'] ); ?></a>
</div>
<div class="lightbox" id="lightbox" role="dialog" aria-modal="true" aria-label="<?php echo esc_attr( $t['image'] ); ?>">
	<button class="lb-btn lb-close" type="button" aria-label="<?php echo esc_attr( $t['close'] ); ?>">✕</button>
	<button class="lb-btn lb-prev" type="button" aria-label="‹">‹</button>
	<figure><img id="lb-img" alt=""><figcaption id="lb-cap"></figcaption></figure>
	<button class="lb-btn lb-next" type="button" aria-label="›">›</button>
</div>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
