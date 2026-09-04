<?php
/**
 * Publication page — individual research item.
 */
get_header();
while ( have_posts() ) : the_post();
	$year = get_field( 'year' );
	$docid = get_field( 'document_id' );
	$pdf = get_field( 'pdf_file' );
	$authors = get_field( 'authors' );
?>
  <section class="page-head wrap">
    <span class="eyebrow"><?php echo esc_html( $year ); ?><?php if ( $docid ) : ?> &middot; <?php echo esc_html( $docid ); ?><?php endif; ?></span>
    <h1><?php the_title(); ?></h1>
    <?php if ( $authors ) : ?><p class="dek"><?php echo esc_html( $authors ); ?></p><?php endif; ?>
    <?php if ( $pdf ) : ?><div class="meta-row"><a class="btn2" href="<?php echo esc_url( $pdf ); ?>" style="margin-top:10px">Download PDF</a></div><?php endif; ?>
  </section>
  <section class="pad wrap">
    <div class="prose"><?php the_content(); ?></div>
  </section>
<?php endwhile; get_footer(); ?>
