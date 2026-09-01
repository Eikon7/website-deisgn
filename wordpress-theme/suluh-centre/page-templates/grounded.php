<?php
/**
 * Template Name: Grounded (podcast)
 *
 * Filtered view of the story stream (story_type = grounded), not a
 * separate content type. Permanent URL for podcast directories per §7.
 */
get_header();
$q = suluh_get_stories( 'grounded', 12 );
?>
  <section class="page-head wrap">
    <span class="eyebrow">The podcast</span>
    <h1>Grounded</h1>
    <p class="dek">Conversations that bridge complex ideas and public understanding. Formerly POLITHINKERS.</p>
  </section>
  <section class="pad wrap">
    <?php if ( $q->have_posts() ) : ?>
    <div class="story-spread" style="display:grid;grid-template-columns:1fr;gap:20px">
      <?php while ( $q->have_posts() ) : $q->the_post(); $row = suluh_story_card_data( get_the_ID() ); ?>
      <a class="list-story" href="<?php echo esc_url( $row['link'] ); ?>" style="display:flex">
        <div class="yr"><?php echo esc_html( $row['date'] ); ?></div>
        <div>
          <h4><?php the_title(); ?></h4>
          <?php if ( $row['dek'] ) : ?><p><?php echo esc_html( $row['dek'] ); ?></p><?php endif; ?>
        </div>
      </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <?php else : ?>
      <p class="empty-note">No episodes published yet.</p>
    <?php endif; ?>
  </section>
<?php get_footer(); ?>
