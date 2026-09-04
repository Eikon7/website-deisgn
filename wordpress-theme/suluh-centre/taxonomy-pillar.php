<?php
/**
 * Pillar overview — one template, three instances (Community, Youth &
 * Education, Ideas Ethics & Society). Master Brief §10.3 #8.
 */
get_header();
$term = get_queried_object();
$programmes = new WP_Query( array(
	'post_type'      => 'programme',
	'posts_per_page' => 12,
	'tax_query'      => array( array( 'taxonomy' => 'pillar', 'field' => 'term_id', 'terms' => $term->term_id ) ),
) );
?>
  <section class="page-head wrap">
    <span class="eyebrow">Our work</span>
    <h1><?php echo esc_html( $term->name ); ?></h1>
    <?php if ( $term->description ) : ?><p class="dek"><?php echo esc_html( $term->description ); ?></p><?php endif; ?>
  </section>
  <section class="pad wrap">
    <div class="section-block">
      <h2>Programmes</h2>
      <?php if ( $programmes->have_posts() ) : ?>
      <div class="people-grid" style="grid-template-columns:repeat(auto-fill,minmax(240px,1fr))">
        <?php while ( $programmes->have_posts() ) : $programmes->the_post(); ?>
        <a class="person" href="<?php the_permalink(); ?>">
          <div class="av"></div>
          <h4><?php the_title(); ?></h4>
          <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 16 ) ); ?></p>
        </a>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
      <?php else : ?>
        <p class="empty-note">No programmes published under this pillar yet.</p>
      <?php endif; ?>
    </div>

    <div class="section-block">
      <h2>Related stories</h2>
      <?php
      $stories = new WP_Query( array(
          'post_type' => 'story', 'posts_per_page' => 3,
          'meta_query' => array( array( 'key' => 'related_pillar_tag', 'value' => $term->term_id ) ),
      ) );
      if ( $stories->have_posts() ) :
      ?>
      <div class="story-spread" style="display:grid;grid-template-columns:1fr;gap:20px">
        <?php while ( $stories->have_posts() ) : $stories->the_post(); $row = suluh_story_card_data( get_the_ID() ); ?>
        <a class="list-story" href="<?php echo esc_url( $row['link'] ); ?>" style="display:flex">
          <div class="yr"><?php echo esc_html( $row['date'] ); ?></div>
          <div><h4><?php the_title(); ?></h4></div>
        </a>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
      <?php else : ?>
        <p class="empty-note">No stories tagged to this pillar yet.</p>
      <?php endif; ?>
    </div>
  </section>
<?php get_footer(); ?>
