<?php
/**
 * Stories — the newsroom stream. Ports stories.html verbatim: same
 * classes, same client-side filter chips (assets/js/concept2.js), same
 * "Upcoming" band pinned above the grid while any Convenings story is
 * flagged is_upcoming (see suluh_get_stories()).
 */
get_header();

$types           = get_terms( array( 'taxonomy' => 'story_type', 'hide_empty' => false ) );
$upcoming        = suluh_get_stories( null, 6, true );
$upcoming_ids    = wp_list_pluck( $upcoming->posts, 'ID' );
$q               = new WP_Query( array(
	'post_type'      => 'story',
	'posts_per_page' => -1,
	'post__not_in'   => $upcoming_ids ?: array( 0 ),
) );
?>

  <!-- ============ Page hero ============ -->
  <section class="stories-hero">
    <div class="wrap">
      <span class="eyebrow">Stories</span>
      <h1 style="font-family:var(--serif);font-weight:600;font-size:clamp(2.2rem,5vw,3.6rem);line-height:1.1;margin:16px 0 18px;color:var(--forest)">What we are doing,<br>and what we are learning</h1>
      <p class="lead2">News, convenings, podcast episodes and notes from the field. One place, updated as the work happens.</p>
    </div>
  </section>

  <section class="pad wrap" style="padding-top:0">
    <div class="filters story-filters" role="group" aria-label="Filter by type">
      <button class="chip on" data-type="All">All</button>
      <?php foreach ( $types as $t ) : ?>
        <button class="chip" data-type="<?php echo esc_attr( $t->name ); ?>"><?php echo esc_html( $t->name ); ?></button>
      <?php endforeach; ?>
    </div>

    <?php if ( $upcoming->have_posts() ) :
      $upcoming_posts = $upcoming->posts;
      $first          = $upcoming_posts[0];
      $first_data     = suluh_story_card_data( $first->ID );
      $rest           = array_slice( $upcoming_posts, 1 );
    ?>
    <!-- ============ Upcoming — pinned above the stream while any
         convening carries a future date. ============ -->
    <div class="upcoming-band reveal2">
      <div class="glow" aria-hidden="true"></div>
      <div class="upcoming-head">
        <div>
          <span class="eyebrow">Upcoming &middot; <?php echo count( $upcoming_posts ); ?> event<?php echo count( $upcoming_posts ) === 1 ? '' : 's'; ?></span>
          <h3><?php echo esc_html( $first_data['title'] ); ?></h3>
          <p><?php echo esc_html( $first_data['date'] ); ?><?php echo $first_data['location'] ? ' &middot; ' . esc_html( $first_data['location'] ) : ''; ?></p>
        </div>
        <a class="btn2" href="<?php echo esc_url( $first_data['link'] ); ?>">Details <svg><use href="#c2-ico-arrow"/></svg></a>
      </div>
      <?php if ( $rest ) : ?>
      <div class="upcoming-list">
        <?php foreach ( $rest as $u ) : $u_data = suluh_story_card_data( $u->ID ); ?>
        <a href="<?php echo esc_url( $u_data['link'] ); ?>">
          <span><?php echo esc_html( $u_data['title'] ); ?></span>
          <span class="d"><?php echo esc_html( $u_data['date'] ); ?></span>
        </a>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
    <?php wp_reset_postdata(); endif; ?>

    <div class="story-grid">
      <?php if ( $q->have_posts() ) : while ( $q->have_posts() ) : $q->the_post();
        suluh_render_story_card( get_the_ID() );
      endwhile; wp_reset_postdata(); endif; ?>
    </div>
    <p class="story-empty" id="storyEmpty" hidden>Nothing published in this category yet.</p>
  </section>

  <!-- ============ Closing ============ -->
  <section class="pillar-next wrap">
    <div class="pillar-next-head reveal2">
      <span class="eyebrow">Keep exploring</span>
      <h2>See the work behind the words</h2>
    </div>
    <div class="pillar-next-grid">
      <a class="bento-cell a reveal2" href="<?php echo esc_url( home_url( '/research/' ) ); ?>">
        <h3>Research &amp; Advocacy</h3>
        <p>Policy briefs, surveys and reports, filterable and downloadable.</p>
        <span class="go">Browse research <svg><use href="#c2-ico-arrow"/></svg></span>
      </a>
      <a class="bento-cell b reveal2" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
        <h3>Get in touch</h3>
        <p>For media enquiries, or to be added to a story.</p>
        <span class="go">Contact us <svg><use href="#c2-ico-arrow"/></svg></span>
      </a>
    </div>
  </section>

<?php get_footer(); ?>
