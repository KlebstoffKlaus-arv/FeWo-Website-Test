<?php
/**
 * Eigene Blöcke: Sommer/Winter-Schalter, Kalender mit Preisrechner, Anfrageformular.
 * Sie werden auf der Website von PHP ausgegeben; im Editor erscheint ein Platzhalter.
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	function () {
		wp_register_script(
			'fewo-blocks',
			FEWO_URI . '/assets/js/editor-blocks.js',
			array( 'wp-blocks', 'wp-element', 'wp-block-editor' ),
			FEWO_VERSION,
			true
		);

		$common = array(
			'api_version'   => 3,
			'category'      => 'widgets',
			'editor_script' => 'fewo-blocks',
			'supports'      => array( 'html' => false, 'reusable' => false, 'multiple' => false ),
		);

		register_block_type(
			'fewo/saison',
			array_merge( $common, array( 'title' => 'Sommer/Winter-Schalter', 'icon' => 'image-flip-horizontal', 'render_callback' => 'fewo_render_saison' ) )
		);
		register_block_type(
			'fewo/buchung',
			array_merge( $common, array( 'title' => 'Kalender & Preisrechner', 'icon' => 'calendar-alt', 'render_callback' => 'fewo_render_buchung' ) )
		);
		register_block_type(
			'fewo/anfrage',
			array_merge( $common, array( 'title' => 'Anfrageformular', 'icon' => 'email-alt', 'render_callback' => 'fewo_render_anfrage' ) )
		);
	}
);

function fewo_render_saison() {
	$t = fewo_strings( fewo_lang() );
	return sprintf(
		'<div class="season" role="group" aria-label="%s"><button type="button" data-season="summer">%s</button><button type="button" data-season="winter">%s</button></div>',
		esc_attr( $t['seasonAria'] ),
		esc_html( $t['summer'] ),
		esc_html( $t['winter'] )
	);
}

function fewo_render_buchung() {
	$t = fewo_strings( fewo_lang() );
	ob_start();
	?>
	<div class="booking">
		<div class="cal-card">
			<div class="cal-head">
				<button type="button" class="cal-prev" aria-label="<?php echo esc_attr( $t['prev'] ); ?>">‹</button>
				<strong class="cal-label" aria-live="polite"><?php echo esc_html( $t['pickIn'] ); ?></strong>
				<button type="button" class="cal-next" aria-label="<?php echo esc_attr( $t['next'] ); ?>">›</button>
			</div>
			<div class="cal-months"></div>
			<div class="legend">
				<span><i class="lg-booked"></i><?php echo esc_html( $t['booked'] ); ?></span>
				<span><i class="lg-inout"></i><?php echo esc_html( $t['inout'] ); ?></span>
				<span><i class="lg-stay"></i><?php echo esc_html( $t['stay'] ); ?></span>
			</div>
			<p class="note"><?php echo esc_html( $t['calNote'] ); ?></p>
		</div>
		<aside class="calc-card">
			<div class="price-big"><span class="price-night"></span> <small class="price-unit"><?php echo esc_html( $t['perNight'] ); ?></small></div>
			<div class="row2">
				<div class="field"><label for="in-from"><?php echo esc_html( $t['arrival'] ); ?></label><input type="date" id="in-from"></div>
				<div class="field"><label for="in-to"><?php echo esc_html( $t['departure'] ); ?></label><input type="date" id="in-to"></div>
			</div>
			<div class="row2">
				<div class="field"><label for="in-adults"><?php echo esc_html( $t['adults'] ); ?></label><select id="in-adults"><option>1</option><option selected>2</option><option>3</option><option>4</option><option>5</option></select></div>
				<div class="field"><label for="in-kids"><?php echo esc_html( $t['kids'] ); ?></label><select id="in-kids"><option selected>0</option><option>1</option><option>2</option><option>3</option></select></div>
			</div>
			<div class="lines"></div>
			<div class="total"><span><?php echo esc_html( $t['total'] ); ?></span><span class="total-sum">–</span></div>
			<a class="btn btn-primary btn-block" href="#kontakt"><?php echo esc_html( $t['bookCta'] ); ?></a>
			<p class="note"><?php echo esc_html( $t['calcNote'] ); ?></p>
		</aside>
	</div>
	<?php
	return ob_get_clean();
}

function fewo_render_anfrage() {
	$t       = fewo_strings( fewo_lang() );
	$privacy = get_privacy_policy_url();
	$link    = $privacy ? '<a href="' . esc_url( $privacy ) . '" target="_blank">' . esc_html( $t['privacyLink'] ) . '</a>' : esc_html( $t['privacyLink'] );
	$consent = str_replace( '{link}', $link, esc_html( $t['privacy'] ) );
	ob_start();
	?>
	<form class="fewo-form" novalidate>
		<div class="row2">
			<div class="field"><label for="f-name"><?php echo esc_html( $t['name'] ); ?></label><input id="f-name" name="name" required autocomplete="name"></div>
			<div class="field"><label for="f-mail"><?php echo esc_html( $t['email'] ); ?></label><input id="f-mail" name="email" type="email" required autocomplete="email"></div>
		</div>
		<div class="row2">
			<div class="field"><label for="f-from"><?php echo esc_html( $t['arrival'] ); ?></label><input id="f-from" name="from" type="date"></div>
			<div class="field"><label for="f-to"><?php echo esc_html( $t['departure'] ); ?></label><input id="f-to" name="to" type="date"></div>
		</div>
		<div class="field"><label for="f-guests"><?php echo esc_html( $t['guests'] ); ?></label><input id="f-guests" name="guests" placeholder="<?php echo esc_attr( $t['guestsPh'] ); ?>"></div>
		<div class="field"><label for="f-msg"><?php echo esc_html( $t['message'] ); ?></label><textarea id="f-msg" name="message" rows="4" placeholder="<?php echo esc_attr( $t['messagePh'] ); ?>"></textarea></div>
		<div class="hp" aria-hidden="true"><label for="f-web">Website</label><input id="f-web" name="website" tabindex="-1" autocomplete="off"></div>
		<label class="consent"><input type="checkbox" name="consent" value="1" required> <span><?php echo wp_kses( $consent, array( 'a' => array( 'href' => array(), 'target' => array() ) ) ); ?></span></label>
		<button class="btn btn-apricot btn-block" type="submit"><?php echo esc_html( $t['send'] ); ?></button>
		<p class="form-msg" aria-live="polite"></p>
	</form>
	<?php
	return ob_get_clean();
}
