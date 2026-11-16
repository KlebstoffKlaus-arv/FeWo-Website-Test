<?php
defined( 'ABSPATH' ) || exit;
get_header();
while ( have_posts() ) {
	the_post();
	?>
	<article class="page-plain wrap">
		<h1><?php the_title(); ?></h1>
		<div class="page-content"><?php the_content(); ?></div>
	</article>
	<?php
}
get_footer();
