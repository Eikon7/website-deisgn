<?php
/**
 * Fallback template (required by WordPress). Real templates in use:
 * page.php (every Elementor-built page, including Home), archive-story.php
 * (Stories), single-story.php, archive-publication.php (Research),
 * page-templates/grounded.php.
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
