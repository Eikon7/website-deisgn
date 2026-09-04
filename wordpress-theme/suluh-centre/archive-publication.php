<?php
/**
 * Research & Advocacy — the credibility page. A reference library, not a
 * feed. Horizontal rows so it scans fast (Master Brief §10.3 #7).
 */
get_header();
$active_type = isset( $_GET['type'] ) ? sanitize_title( wp_unslash( $_GET['type'] ) ) : '';
$types = get_terms( array( 'taxonomy' => 'publication_type', 'hide_empty' => false ) );

$args = array( 'post_type' => 'publication', 'posts_per_page' => 20, 'meta_key' => 'year', 'orderby' => 'meta_value_num', 'order' => 'DESC' );
if ( $active_type ) {
	$args['tax_query'] = array( array( 'taxonomy' => 'publication_type', 'field' => 'slug', 'terms' => $active_type ) );
}
$q = new WP_Query( $args );
?>
  <section class="page-head wrap">
    <span class="eyebrow">Where research meets impact</span>
    <h1>Research &amp; Advocacy</h1>
    <p class="dek">Research generates the evidence. Advocacy carries it to change. Policy briefs, surveys, round tables and parliamentary engagement, across all three pillars.</p>
  </section>
  <section class="pad wrap">
    <div class="filters">
      <a href="<?php echo esc_url( home_url( '/research' ) ); ?>" class="<?php echo $active_type ? '' : 'on'; ?>">All</a>
      <?php foreach ( $types as $t ) : ?>
        <a href="<?php echo esc_url( add_query_arg( 'type', $t->slug, home_url( '/research' ) ) ); ?>" class="<?php echo $active_type === $t->slug ? 'on' : ''; ?>"><?php echo esc_html( $t->name ); ?></a>
      <?php endforeach; ?>
    </div>
    <?php if ( $q->have_posts() ) : ?>
      <?php while ( $q->have_posts() ) : $q->the_post();
        $year = get_field( 'year' );
        $docid = get_field( 'document_id' );
        $pdf = get_field( 'pdf_file' );
        $cover = get_field( 'cover_image' );
        $pub_types = get_the_terms( get_the_ID(), 'publication_type' );
      ?>
      <div class="pub-row">
        <?php if ( $cover ) : ?><img class="cover" src="<?php echo esc_url( $cover ); ?>" alt=""><?php else : ?><div class="cover"></div><?php endif; ?>
        <div>
          <div style="font-family:var(--serif);font-style:italic;color:var(--coral-deep);font-size:.95rem"><?php echo esc_html( $year ); ?></div>
          <h4><?php the_title(); ?></h4>
          <p><?php echo esc_html( get_the_excerpt() ); ?></p>
          <?php if ( $docid ) : ?><div class="docid"><?php echo esc_html( $docid ); ?></div><?php endif; ?>
        </div>
        <div class="dl">
          <?php if ( $pub_types && ! is_wp_error( $pub_types ) ) : ?><div><?php echo esc_html( $pub_types[0]->name ); ?></div><?php endif; ?>
          <?php if ( $pdf ) : ?><a href="<?php echo esc_url( $pdf ); ?>">PDF &rarr;</a><?php endif; ?>
        </div>
      </div>
      <?php endwhile; wp_reset_postdata(); ?>
    <?php else : ?>
      <p class="empty-note">No publications in this filter yet.</p>
    <?php endif; ?>
    <p style="margin-top:24px;max-width:660px;font-size:.9rem;color:var(--muted)">Commentary authored by individuals and published elsewhere is listed separately, attributed to its author, and linked out. It does not sit in the index alongside the studies.</p>
  </section>
<?php get_footer(); ?>
