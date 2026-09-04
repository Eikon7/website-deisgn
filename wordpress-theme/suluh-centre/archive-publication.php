<?php
/**
 * Research & Advocacy — the credibility page. A reference library, not a
 * feed. Ports research.html verbatim: same classes, same client-side
 * filter chips, same gated-download modal (both driven by the shared
 * assets/js/concept2.js — see the "Research library" blocks in there).
 */
get_header();

$types = get_terms( array( 'taxonomy' => 'publication_type', 'hide_empty' => false ) );

// Sorting by 'year' via meta_key/orderby would silently exclude any
// publication where that ACF field was left empty (WP_Query requires the
// meta key to exist when it's used for ordering) — the same trap the
// Stories "Upcoming" query hit. Fetch everything and sort in PHP instead,
// so a publication published without a Year still shows up (just last).
$q = new WP_Query( array(
	'post_type'      => 'publication',
	'posts_per_page' => -1,
	'orderby'        => 'date',
	'order'          => 'DESC',
) );
usort( $q->posts, function( $a, $b ) {
	return (int) suluh_field( 'year', $b->ID ) <=> (int) suluh_field( 'year', $a->ID );
} );
?>

  <!-- ============ Page hero ============ -->
  <section class="research-hero">
    <div class="wrap">
      <span class="eyebrow">Where Research Meets Impact</span>
      <h1 style="font-family:var(--serif);font-weight:600;font-size:clamp(2.2rem,5vw,3.6rem);line-height:1.1;margin:16px 0 18px;color:var(--forest)">Research &amp; Advocacy</h1>
      <p class="lead2">Research generates the evidence. Advocacy carries it to change. Policy briefs, surveys, round tables and parliamentary engagement, across all three pillars.</p>
    </div>
  </section>

  <!-- ============ Library ============ -->
  <section class="pad wrap" style="padding-top:0">
    <div class="filters" role="group" aria-label="Filter by type">
      <button class="chip on" data-type="All">All</button>
      <?php foreach ( $types as $t ) : ?>
        <button class="chip" data-type="<?php echo esc_attr( $t->name ); ?>"><?php echo esc_html( $t->name ); ?></button>
      <?php endforeach; ?>
    </div>

    <div class="pub-list">
      <?php if ( $q->have_posts() ) : while ( $q->have_posts() ) : $q->the_post();
        $year   = suluh_field( 'year' );
        $docid  = suluh_field( 'document_id' );
        $pdf    = suluh_field( 'pdf_file' );
        $cover  = suluh_field( 'cover_image' );
        $terms  = get_the_terms( get_the_ID(), 'publication_type' );
        $type   = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
      ?>
      <div class="pubrow reveal2" data-type="<?php echo esc_attr( $type ); ?>">
        <?php if ( $cover ) : ?>
          <div class="pub-cover" style="background-image:url(<?php echo esc_url( $cover ); ?>);background-size:cover;background-position:center"></div>
        <?php else : ?>
          <div class="pub-cover">Cover</div>
        <?php endif; ?>
        <div class="pub-info">
          <?php if ( $year ) : ?><div class="yr"><?php echo esc_html( $year ); ?></div><?php endif; ?>
          <h4><?php the_title(); ?></h4>
          <p><?php echo esc_html( get_the_excerpt() ); ?></p>
          <?php if ( $docid ) : ?><div class="pub-docid"><?php echo esc_html( $docid ); ?></div><?php endif; ?>
        </div>
        <div class="pub-meta">
          <?php if ( $type ) : ?><div class="pub-type"><?php echo esc_html( $type ); ?></div><?php endif; ?>
          <?php if ( $pdf ) : ?>
          <button class="pub-dl" data-file="<?php echo esc_url( $pdf ); ?>" data-title="<?php echo esc_attr( get_the_title() ); ?>">PDF <svg><use href="#c2-ico-download"/></svg></button>
          <?php endif; ?>
        </div>
      </div>
      <?php endwhile; wp_reset_postdata(); else : ?>
        <p class="pub-empty">Nothing published yet.</p>
      <?php endif; ?>
    </div>
    <p class="pub-empty" id="pubEmpty" hidden>Nothing published in this category yet.</p>

    <p class="pub-note">Commentary authored by individuals and published elsewhere is listed separately, attributed to its author, and linked out. It does not sit in the index alongside the studies.</p>
  </section>

  <!-- ============ Closing ============ -->
  <section class="pillar-next wrap">
    <div class="pillar-next-head reveal2">
      <span class="eyebrow">Keep exploring</span>
      <h2>See the work behind the words</h2>
    </div>
    <div class="pillar-next-grid">
      <a class="bento-cell a reveal2" href="<?php echo esc_url( home_url( '/work/' ) ); ?>">
        <h3>Our Work</h3>
        <p>Community, Youth &amp; Education, and Ideas, Ethics &amp; Society.</p>
        <span class="go">Explore our work <svg><use href="#c2-ico-arrow"/></svg></span>
      </a>
      <a class="bento-cell b reveal2" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
        <h3>Get in touch</h3>
        <p>For research collaboration, media enquiries, or partnerships.</p>
        <span class="go">Contact us <svg><use href="#c2-ico-arrow"/></svg></span>
      </a>
    </div>
  </section>

<!-- ============ Gated download modal ============ -->
<div class="dl-modal-overlay" id="dlOverlay">
  <div class="dl-modal">
    <button class="dl-modal-close" id="dlClose" aria-label="Close">
      <svg width="14" height="14"><use href="#c2-ico-close"/></svg>
    </button>
    <span class="eyebrow">Download</span>
    <h4>Get this publication</h4>
    <p class="dl-doc-title">Please share your name and email to download <b id="dlDocTitle"></b>.</p>
    <form id="dlForm" novalidate>
      <div class="contact-field">
        <label for="dlName">Name</label>
        <input type="text" id="dlName" name="name" required>
      </div>
      <div class="contact-field">
        <label for="dlEmail">Email</label>
        <input type="email" id="dlEmail" name="email" required>
      </div>
      <button class="btn2" type="submit">Download PDF <svg><use href="#c2-ico-arrow"/></svg></button>
      <p class="contact-status" id="dlStatus" role="status" aria-live="polite"></p>
    </form>
  </div>
</div>

<?php get_footer(); ?>
