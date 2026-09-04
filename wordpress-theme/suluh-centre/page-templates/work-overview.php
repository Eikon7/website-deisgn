<?php
/**
 * Template Name: Our Work (pillar overview)
 */
get_header();
$pillars = get_terms( array( 'taxonomy' => 'pillar', 'hide_empty' => false ) );
?>
  <section class="page-head wrap">
    <span class="eyebrow">Our work</span>
    <h1>Three sources of light, one method running through them</h1>
    <p class="dek">Community, Youth &amp; Education, and Ideas, Ethics &amp; Society, with research and advocacy running through all three as the method rather than a fourth pillar.</p>
  </section>
  <section class="pad wrap">
    <div class="bento">
      <?php $i = 0; foreach ( $pillars as $p ) : $i++; ?>
      <a class="bento-cell <?php echo $i === 1 ? 'lg' : ( $i === 2 ? 'a' : 'b' ); ?>" href="<?php echo esc_url( suluh_term_link( $p, 'pillar' ) ); ?>">
        <span class="num"><?php echo esc_html( str_pad( $i, 2, '0', STR_PAD_LEFT ) ); ?></span>
        <h3><?php echo esc_html( $p->name ); ?></h3>
        <p><?php echo esc_html( $p->description ?: 'Explore this pillar\'s programmes and stories.' ); ?></p>
        <span class="go">Explore <svg width="16" height="16"><use href="#c2-ico-arrow"/></svg></span>
      </a>
      <?php endforeach; ?>
    </div>
    <div class="bento" style="margin-top:20px">
      <a class="bento-cell c" href="<?php echo esc_url( home_url( '/research' ) ); ?>" style="grid-column:1/-1">
        <span class="num">04</span>
        <h3>Research &amp; Advocacy</h3>
        <p>The spine, not a fourth pillar. Turning evidence into policy, and policy into change on the ground.</p>
        <span class="go">Browse research <svg width="16" height="16"><use href="#c2-ico-arrow"/></svg></span>
      </a>
    </div>
  </section>
<?php get_footer(); ?>
