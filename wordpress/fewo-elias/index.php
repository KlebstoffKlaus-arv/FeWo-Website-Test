<?php
defined( 'ABSPATH' ) || exit;
get_header();
?>
<article class="page-plain wrap">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<h1><?php the_title(); ?></h1>
			<div class="page-content"><?php the_content(); ?></div>
		<?php endwhile; ?>
	<?php else : ?>
		<h1>404</h1>
		<p><a href="<?php echo esc_url( fewo_home_url() ); ?>">← Ferienwohnung Elias</a></p>
	<?php endif; ?>
</article>
<?php
get_footer();
