<?php
/**
 * Stories — the newsroom stream. §9 Rule 6: one publishing stream, tagged
 * by type, rather than several thin sections. Filters narrow to a type
 * without leaving this template.
 */
get_header();
$active_type = isset( $_GET['type'] ) ? sanitize_title( wp_unslash( $_GET['type'] ) ) : '';
$types = get_terms( array( 'taxonomy' => 'story_type', 'hide_empty' => false ) );
?>
  <section class="page-head wrap">
    <span class="eyebrow">From the ground</span>
    <h1>Stories</h1>
    <p class="dek">News, convenings, podcast episodes and field write-ups, all in one place.</p>
  </section>
  <section class="pad wrap">
    <div class="filters">
      <a href="<?php echo esc_url( home_url( '/stories' ) ); ?>" class="<?php echo $active_type ? '' : 'on'; ?>">All</a>
      <?php foreach ( $types as $t ) : ?>
        <a href="<?php echo esc_url( add_query_arg( 'type', $t->slug, home_url( '/stories' ) ) ); ?>" class="<?php echo $active_type === $t->slug ? 'on' : ''; ?>"><?php echo esc_html( $t->name ); ?></a>
      <?php endforeach; ?>
    </div>
    <?php
    $q = suluh_get_stories( $active_type ?: null, 12 );
    if ( $q->have_posts() ) :
    ?>
    <div class="story-grid" style="display:grid;grid-template-columns:1fr;gap:24px;margin-top:8px">
      <?php while ( $q->have_posts() ) : $q->the_post(); $row = suluh_story_card_data( get_the_ID() ); ?>
      <a class="list-story" href="<?php echo esc_url( $row['link'] ); ?>" style="display:flex">
        <div class="yr"><?php echo esc_html( $row['date'] ); ?></div>
        <div>
          <?php if ( $row['tag'] ) : ?><span class="tag2"><?php echo esc_html( $row['tag'] ); ?></span><?php endif; ?>
          <h4><?php the_title(); ?></h4>
          <?php if ( $row['dek'] ) : ?><p><?php echo esc_html( $row['dek'] ); ?></p><?php endif; ?>
        </div>
      </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <?php else : ?>
      <p class="empty-note">Nothing published in this filter yet.</p>
    <?php endif; ?>
  </section>
<?php get_footer(); ?>
