<?php
/**
 * Programme page — the deepest and most important page type (Master Brief
 * §10.3 #9). Ten sections: title block + key-facts strip, hero band, what
 * it is, why it exists, how it works, partners, voices, photo set, what
 * comes next, related. Falls back cleanly with zero photography (§11).
 */
get_header();
while ( have_posts() ) : the_post();
	$pillars = get_the_terms( get_the_ID(), 'pillar' );
	$tense = get_field( 'tense_line' );
	$hero_image = get_field( 'hero_image' );
	$next = get_field( 'next' );
	$is_pro = function_exists( 'suluh_acf_pro' ) && suluh_acf_pro();
?>
  <section class="page-head wrap">
    <?php if ( $tense ) : ?><span class="eyebrow"><?php echo esc_html( $tense ); ?></span><?php endif; ?>
    <h1><?php the_title(); ?></h1>
    <?php if ( $pillars && ! is_wp_error( $pillars ) ) : ?>
      <div class="meta-row">
        <?php foreach ( $pillars as $p ) : ?><a href="<?php echo esc_url( suluh_term_link( $p, 'pillar' ) ); ?>" style="color:var(--coral-deep);font-weight:600"><?php echo esc_html( $p->name ); ?></a><?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php
    // Key facts strip.
    $facts = array();
    if ( $is_pro ) {
        $facts = get_field( 'key_facts' ) ?: array();
    } else {
        for ( $i = 1; $i <= 4; $i++ ) {
            $g = get_field( "key_fact_{$i}" );
            if ( $g && ! empty( $g['label'] ) ) { $facts[] = $g; }
        }
    }
    if ( $facts ) :
    ?>
    <div class="key-facts">
      <?php foreach ( $facts as $f ) : ?>
        <div><div class="l"><?php echo esc_html( $f['label'] ); ?></div><div class="v"><?php echo esc_html( $f['value'] ); ?></div></div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </section>

  <!-- Hero band: falls back to the Forest Green flame field when no image. -->
  <section class="wrap" style="margin:32px auto">
    <div style="position:relative;border-radius:20px;overflow:hidden;aspect-ratio:16/6;<?php echo $hero_image ? '' : 'background:var(--forest)'; ?>">
      <?php if ( $hero_image ) : ?>
        <img src="<?php echo esc_url( $hero_image ); ?>" alt="" style="width:100%;height:100%;object-fit:cover">
      <?php else : ?>
        <svg viewBox="0 0 64 100" style="position:absolute;right:-8%;top:50%;transform:translateY(-50%);width:38%;opacity:.16" aria-hidden="true"><path d="M32 2C44 20 60 34 60 52C60 72 46 88 32 98C18 88 4 72 4 52C4 34 20 20 32 2Z" fill="#EC6B6E"/></svg>
      <?php endif; ?>
    </div>
  </section>

  <section class="pad wrap">
    <?php if ( get_field( 'what_it_is' ) ) : ?>
    <div class="section-block"><h2>What it is</h2><div class="prose"><?php the_field( 'what_it_is' ); ?></div></div>
    <?php endif; ?>

    <?php if ( get_field( 'why_it_exists' ) ) : ?>
    <div class="section-block"><h2>Why it exists</h2><div class="prose"><?php the_field( 'why_it_exists' ); ?></div></div>
    <?php endif; ?>

    <?php if ( get_field( 'how_it_works' ) ) : ?>
    <div class="section-block"><h2>How it works</h2><div class="prose"><?php the_field( 'how_it_works' ); ?></div></div>
    <?php endif; ?>

    <?php
    // Partners.
    $partners = array();
    if ( $is_pro ) {
        $partners = get_field( 'partners' ) ?: array();
    } else {
        for ( $i = 1; $i <= 3; $i++ ) {
            $g = get_field( "partner_{$i}" );
            if ( $g && ! empty( $g['name'] ) ) { $partners[] = $g; }
        }
    }
    if ( $partners ) :
    ?>
    <div class="section-block">
      <h2>Partners</h2>
      <div class="partner-row">
        <?php foreach ( $partners as $p ) : ?>
          <?php if ( ! empty( $p['logo'] ) ) : ?>
            <a href="<?php echo esc_url( $p['url'] ?: '#' ); ?>"><img src="<?php echo esc_url( $p['logo'] ); ?>" alt="<?php echo esc_attr( $p['name'] ); ?>"></a>
          <?php else : ?>
            <span style="font-weight:600;color:var(--forest)"><?php echo esc_html( $p['name'] ); ?></span>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <?php
    // Voices.
    $voices = array();
    if ( $is_pro ) {
        $voices = get_field( 'voices' ) ?: array();
    } else {
        for ( $i = 1; $i <= 2; $i++ ) {
            $g = get_field( "voice_{$i}" );
            if ( $g && ! empty( $g['quote'] ) ) { $voices[] = $g; }
        }
    }
    if ( $voices ) :
    ?>
    <div class="section-block">
      <h2>Voices</h2>
      <?php foreach ( $voices as $v ) : ?>
      <div class="voice-card">
        <p class="quote">&ldquo;<?php echo esc_html( $v['quote'] ); ?>&rdquo;</p>
        <p class="attr"><b><?php echo esc_html( $v['name'] ); ?></b><?php if ( ! empty( $v['role'] ) ) : ?> &middot; <?php echo esc_html( $v['role'] ); ?><?php endif; ?></p>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php
    // Photo set.
    $photos = array();
    if ( $is_pro ) {
        $photos = get_field( 'photo_set' ) ?: array();
    } else {
        for ( $i = 1; $i <= 6; $i++ ) {
            $img = get_field( "photo_{$i}" );
            if ( $img ) { $photos[] = $img; }
        }
    }
    if ( $photos ) :
    ?>
    <div class="section-block">
      <h2>Photo set</h2>
      <div class="photo-grid">
        <?php foreach ( $photos as $img ) : $src = is_array( $img ) ? $img['url'] : $img; ?>
          <img src="<?php echo esc_url( $src ); ?>" alt="">
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <?php if ( $next ) : ?>
    <div class="section-block" style="border-left:4px solid var(--coral);padding-left:24px">
      <h4 style="font-family:var(--serif);font-style:italic;color:var(--forest);margin-bottom:9px">What comes next</h4>
      <p style="color:var(--muted)"><?php echo esc_html( $next ); ?></p>
    </div>
    <?php endif; ?>
  </section>
<?php endwhile; get_footer(); ?>
