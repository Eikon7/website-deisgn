<?php
/**
 * Story detail — one item from the newsroom stream. Same template for
 * every story_type; Convenings and Grounded differ only by the
 * conditional blocks below (fact box, photo vs. audio player), same as
 * story-detail.html.
 */
get_header();
while ( have_posts() ) : the_post();
	$row      = suluh_story_card_data( get_the_ID() );
	$terms    = get_the_terms( get_the_ID(), 'story_type' );
	$type     = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0] : null;
	$is_conv  = $type && 'convenings' === $type->slug;
	$audio    = suluh_field( 'audio_url' );
	$location = suluh_field( 'location' );
	$partners = suluh_field( 'partners' );
	$scale    = suluh_field( 'scale' );
	$thumb    = get_the_post_thumbnail_url( get_the_ID(), 'full' );
	$has_factbox = $is_conv && ( $location || $partners || $scale );
?>

  <!-- ============ Story header ============ -->
  <section class="story-hero-s">
    <div class="wrap" style="max-width:860px">
      <p class="crumb"><a href="<?php echo esc_url( home_url( '/stories/' ) ); ?>">Stories</a><?php echo $type ? ' / ' . esc_html( $type->name ) : ''; ?></p>
      <?php if ( $row['tag'] ) : ?><span class="eyebrow story-tag <?php echo esc_attr( $row['type_class'] ); ?>"><?php echo wp_kses_post( $row['tag'] ); ?></span><?php endif; ?>
      <h1 style="font-family:var(--serif);font-weight:600;font-size:clamp(2rem,4.4vw,3.2rem);line-height:1.15;margin:14px 0 20px;color:var(--forest)"><?php the_title(); ?></h1>
      <?php if ( $row['dek'] ) : ?><p class="lead2"><?php echo esc_html( $row['dek'] ); ?></p><?php endif; ?>
      <p class="story-date"><?php echo esc_html( $row['date'] ); ?></p>
    </div>
  </section>

  <section class="pad wrap" style="padding-top:36px;max-width:860px">
    <!-- Media block: an <audio> player for Grounded episodes, a photo
         (or placeholder) for everything else. -->
    <?php if ( $audio ) : ?>
      <div class="story-media" style="background:var(--cream)">
        <audio controls style="width:90%" src="<?php echo esc_url( $audio ); ?>"></audio>
      </div>
    <?php elseif ( $thumb ) : ?>
      <div class="story-media">
        <img src="<?php echo esc_url( $thumb ); ?>" alt="" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover">
      </div>
    <?php else : ?>
      <div class="story-media">
        <span class="ph-label">Photography</span>
      </div>
    <?php endif; ?>

    <!-- Fact box: Convenings-only, and only when at least one field is
         filled in. -->
    <?php if ( $has_factbox ) : ?>
    <div class="factbox">
      <dl>
        <dt>Date</dt><dd><?php echo esc_html( $row['date'] ); ?></dd>
        <?php if ( $location ) : ?><dt>Location</dt><dd><?php echo esc_html( $location ); ?></dd><?php endif; ?>
        <?php if ( $partners ) : ?><dt>Partners</dt><dd><?php echo esc_html( $partners ); ?></dd><?php endif; ?>
        <?php if ( $scale ) : ?><dt>Scale</dt><dd><?php echo esc_html( $scale ); ?></dd><?php endif; ?>
      </dl>
    </div>
    <?php endif; ?>

    <div class="story-prose">
      <?php the_content(); ?>
    </div>

    <a class="story-back" href="<?php echo esc_url( home_url( '/stories/' ) ); ?>"><svg width="13" height="13"><use href="#c2-ico-arrow"/></svg> All stories</a>
  </section>

<?php endwhile; get_footer(); ?>
