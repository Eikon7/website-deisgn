<?php
/**
 * Generic page template — About, Contact, Privacy, Terms. Anything needing
 * a bespoke layout (About's continuity table, Contact's form) overrides
 * this with its own page-{slug}.php per the template hierarchy.
 */
get_header();
while ( have_posts() ) : the_post();
?>
  <section class="page-head wrap">
    <h1><?php the_title(); ?></h1>
    <?php if ( has_excerpt() ) : ?><p class="dek"><?php the_excerpt(); ?></p><?php endif; ?>
  </section>
  <section class="pad wrap">
    <div class="prose"><?php the_content(); ?></div>
  </section>
<?php endwhile; get_footer(); ?>
