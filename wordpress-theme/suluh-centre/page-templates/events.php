<?php
/**
 * Template Name: Convenings (events)
 *
 * Filtered view of the story stream (story_type = convenings), split into
 * Upcoming / Past by the `is_upcoming` field. Permanent URL per §7.
 */
get_header();
$upcoming = suluh_get_stories( 'convenings', 6, true );
$past = suluh_get_stories( 'convenings', 12 );
?>
  <section class="page-head wrap">
    <span class="eyebrow">Convenings</span>
    <h1>Bringing people into the same room</h1>
    <p class="dek">Conferences, round tables and network gatherings. Communities, civil society and institutions together.</p>
  </section>
  <section class="pad wrap">
    <?php if ( $upcoming->have_posts() ) : ?>
    <div class="section-block">
      <h2>Upcoming</h2>
      <div class="story-spread" style="display:grid;grid-template-columns:1fr;gap:20px">
        <?php while ( $upcoming->have_posts() ) : $upcoming->the_post(); $row = suluh_story_card_data( get_the_ID() ); ?>
        <a class="list-story" href="<?php echo esc_url( $row['link'] ); ?>" style="display:flex">
          <div class="yr"><?php echo esc_html( $row['date'] ); ?></div>
          <div><h4><?php the_title(); ?></h4><?php if ( $row['dek'] ) : ?><p><?php echo esc_html( $row['dek'] ); ?></p><?php endif; ?></div>
        </a>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    </div>
    <?php endif; ?>
    <div class="section-block">
      <h2>Past</h2>
      <?php if ( $past->have_posts() ) : ?>
      <div class="story-spread" style="display:grid;grid-template-columns:1fr;gap:20px">
        <?php while ( $past->have_posts() ) : $past->the_post(); $row = suluh_story_card_data( get_the_ID() ); ?>
        <a class="list-story" href="<?php echo esc_url( $row['link'] ); ?>" style="display:flex">
          <div class="yr"><?php echo esc_html( $row['date'] ); ?></div>
          <div><h4><?php the_title(); ?></h4><?php if ( $row['dek'] ) : ?><p><?php echo esc_html( $row['dek'] ); ?></p><?php endif; ?></div>
        </a>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
      <?php else : ?>
        <p class="empty-note">No past convenings published yet.</p>
      <?php endif; ?>
    </div>
  </section>
<?php get_footer(); ?>
