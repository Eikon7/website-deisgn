<?php
/**
 * Story page — a single item from the newsroom stream (news, convenings,
 * podcast episodes, field write-ups). §7.
 */
get_header();
while ( have_posts() ) : the_post();
	$data = suluh_story_card_data( get_the_ID() );
	$audio = get_field( 'audio_url' );
	$location = get_field( 'location' );
?>
  <section class="page-head wrap">
    <?php if ( $data['tag'] ) : ?><span class="tag"><?php echo esc_html( $data['tag'] ); ?></span><?php endif; ?>
    <h1><?php the_title(); ?></h1>
    <?php if ( $data['dek'] ) : ?><p class="dek"><?php echo esc_html( $data['dek'] ); ?></p><?php endif; ?>
    <div class="meta-row">
      <span><?php echo esc_html( $data['date'] ); ?></span>
      <?php if ( $location ) : ?><span><?php echo esc_html( $location ); ?></span><?php endif; ?>
    </div>
  </section>
  <section class="pad wrap">
    <?php if ( has_post_thumbnail() ) : ?>
      <div class="thumb" style="border-radius:16px;overflow:hidden;margin-bottom:36px;aspect-ratio:16/9">
        <?php the_post_thumbnail( 'large', array( 'style' => 'width:100%;height:100%;object-fit:cover' ) ); ?>
      </div>
    <?php endif; ?>
    <?php if ( $audio ) : ?>
      <div class="section-block">
        <audio controls style="width:100%" src="<?php echo esc_url( $audio ); ?>"></audio>
      </div>
    <?php endif; ?>
    <div class="prose"><?php the_content(); ?></div>
  </section>
<?php endwhile; get_footer(); ?>
