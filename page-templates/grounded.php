<?php
/**
 * Template Name: Grounded (podcast)
 *
 * Not a separate content type — a filtered view of the story stream
 * (story_type = grounded), per the wireframe's own design note. Assign
 * this template to a normal Page titled "Grounded" so it gets a stable
 * permalink for podcast directories. Ports grounded.html verbatim for
 * the hero + platform links; the episode grid reuses the exact same
 * .story-card partial as the main Stories archive
 * (suluh_render_story_card() in inc/template-tags.php).
 */
get_header();
$q = suluh_get_stories( 'grounded', 24 );
?>

  <!-- ============ Page hero ============ -->
  <section class="grounded-hero">
    <div class="glow" aria-hidden="true"></div>
    <svg class="grounded-hero-flame" viewBox="0 0 64 100" aria-hidden="true"><use href="#c2-flame-shape" fill="#fff"/></svg>
    <div class="wrap">
      <p class="crumb"><a href="<?php echo esc_url( home_url( '/stories/' ) ); ?>">Stories</a> / Grounded</p>
      <span class="eyebrow">The podcast</span>
      <h1>Grounded</h1>
      <p class="lead2">Conversations that bridge complex ideas and public understanding. Formerly POLITHINKERS.</p>
      <div class="grounded-links">
        <a class="gl-apple" href="#">Apple Podcasts</a>
        <a class="gl-spotify" href="#">Spotify</a>
        <a class="gl-rss" href="#">RSS</a>
      </div>
    </div>
  </section>

  <!-- ============ All episodes ============ -->
  <section class="pad wrap">
    <div class="section-head2 reveal2">
      <span class="eyebrow">All episodes</span>
      <h2>Every conversation</h2>
    </div>
    <div class="story-grid">
      <?php if ( $q->have_posts() ) : while ( $q->have_posts() ) : $q->the_post();
        suluh_render_story_card( get_the_ID() );
      endwhile; wp_reset_postdata(); else : ?>
        <p class="story-empty">No episodes published yet.</p>
      <?php endif; ?>
    </div>
  </section>

  <!-- ============ Closing ============ -->
  <section class="pillar-next wrap">
    <div class="pillar-next-head reveal2">
      <span class="eyebrow">Keep exploring</span>
      <h2>See the work behind the words</h2>
    </div>
    <div class="pillar-next-grid">
      <a class="bento-cell a reveal2" href="<?php echo esc_url( home_url( '/stories/' ) ); ?>">
        <h3>All stories</h3>
        <p>News, convenings, podcast episodes and notes from the field.</p>
        <span class="go">Browse stories <svg><use href="#c2-ico-arrow"/></svg></span>
      </a>
      <a class="bento-cell b reveal2" href="<?php echo esc_url( home_url( '/research/' ) ); ?>">
        <h3>Research &amp; Advocacy</h3>
        <p>Policy briefs, surveys and reports, filterable and downloadable.</p>
        <span class="go">Browse research <svg><use href="#c2-ico-arrow"/></svg></span>
      </a>
    </div>
  </section>

<?php get_footer(); ?>
