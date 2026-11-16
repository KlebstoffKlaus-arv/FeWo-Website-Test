<?php
defined( 'ABSPATH' ) || exit;
get_header();
while ( have_posts() ) {
	the_post();
	echo '<div class="front">';
	the_content();
	echo '</div>';
}
get_footer();
