<?php
/**
 * Fallback template (required by WordPress). Real templates:
 * front-page.php (Home), archive-story.php (Stories/Grounded/Events),
 * single-story.php, single-programme.php, single-publication.php, page.php.
 */
get_header();
?>
<section class="pad wrap">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<h1><?php the_title(); ?></h1>
		<div><?php the_content(); ?></div>
	<?php endwhile; else : ?>
		<p>Nothing found.</p>
	<?php endif; ?>
</section>
<?php get_footer(); ?>
