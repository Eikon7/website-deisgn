<?php
/**
 * Small template helpers shared across the three CMS templates
 * (archive-publication.php, archive-story.php, single-story.php) and
 * page-templates/grounded.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The reusable icon sprite, defined once per page. Same markup as the
 * static build's inline <symbol> sprite (see research.html / stories.html
 * / story-detail.html / grounded.html).
 */
function suluh_svg_sprite() {
	?>
	<svg width="0" height="0" style="position:absolute" aria-hidden="true">
	  <symbol id="c2-mark" viewBox="0 0 64 100">
	    <defs>
	      <mask id="c2-mark-cut">
	        <rect width="64" height="100" fill="#fff"/>
	        <path d="M22 32C22 23 46 23 46 36C46 47 22 49 22 61C22 73 46 73 46 65" stroke="#000" stroke-width="9" fill="none" stroke-linecap="round"/>
	      </mask>
	    </defs>
	    <path d="M32 2C44 20 60 34 60 52C60 72 46 88 32 98C18 88 4 72 4 52C4 34 20 20 32 2Z" fill="var(--coral)" mask="url(#c2-mark-cut)"/>
	    <path d="M32 2C44 20 60 34 60 52C60 60 58 67 55 73C53 52 46 33 32 14Z" fill="var(--blush)" opacity=".65" mask="url(#c2-mark-cut)"/>
	  </symbol>
	  <symbol id="c2-flame-shape" viewBox="0 0 64 100">
	    <path d="M32 2C44 20 60 34 60 52C60 72 46 88 32 98C18 88 4 72 4 52C4 34 20 20 32 2Z"/>
	  </symbol>
	  <symbol id="c2-ico-arrow" viewBox="0 0 16 16" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
	    <path d="M2 8h11M8.5 3.5 13 8l-4.5 4.5"/>
	  </symbol>
	  <symbol id="c2-ico-close" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round">
	    <path d="M5 5l10 10M15 5 5 15"/>
	  </symbol>
	  <symbol id="c2-ico-download" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
	    <path d="M8 1.5v9M4.5 7 8 10.5 11.5 7M2 12.5h12"/>
	  </symbol>
	</svg>
	<?php
}

/**
 * get_term_link() can return WP_Error. Templates should never have to
 * guard against that individually.
 */
function suluh_term_link( $term, $taxonomy ) {
	$link = get_term_link( $term, $taxonomy );
	return is_wp_error( $link ) ? '#' : $link;
}

/**
 * Maps a story's story_type term slug to the CSS modifier class used on
 * .story-img / .story-tag in pages2.css (t-convenings / t-grounded /
 * t-field / t-news). Unstyled/future term slugs (e.g. "notes") fall back
 * to no modifier, same as an unstyled News card.
 */
function suluh_story_type_class( $slug ) {
	$map = array(
		'convenings'     => 't-convenings',
		'grounded'       => 't-grounded',
		'from-the-field' => 't-field',
		'news'           => 't-news',
	);
	return isset( $map[ $slug ] ) ? $map[ $slug ] : '';
}

/**
 * Story stream query helper. /grounded is a filtered view of this same
 * "story" stream rather than a separate post type, so it shares this one
 * query function with the main Stories archive.
 *
 * @param string|null $type_slug     story_type term slug to filter to, or null for all.
 * @param int         $count         number of stories to return.
 * @param bool|null   $upcoming_only pass true to return only stories flagged upcoming.
 */
function suluh_get_stories( $type_slug = null, $count = 12, $upcoming_only = false ) {
	$args = array(
		'post_type'      => 'story',
		'posts_per_page' => $count,
		'post_status'    => 'publish',
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	if ( $type_slug ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'story_type',
				'field'    => 'slug',
				'terms'    => $type_slug,
			),
		);
	}

	if ( $upcoming_only ) {
		$args['meta_key']   = 'is_upcoming';
		$args['meta_value'] = '1';
		$args['orderby']    = 'meta_value';
		$args['order']      = 'ASC';
	}

	return new WP_Query( $args );
}

/**
 * Format a story's card fields consistently across Stories and Grounded
 * (the .story-card component in pages2.css).
 */
function suluh_story_card_data( $post_id ) {
	$types      = get_the_terms( $post_id, 'story_type' );
	$term       = ( $types && ! is_wp_error( $types ) ) ? $types[0] : null;
	$episode    = get_field( 'episode_number', $post_id );
	$tag_label  = $term ? $term->name : '';
	if ( $term && 'grounded' === $term->slug && $episode ) {
		$tag_label .= ' &middot; Ep ' . esc_html( $episode );
	}

	return array(
		'type_slug'  => $term ? $term->slug : '',
		'type_class' => $term ? suluh_story_type_class( $term->slug ) : '',
		'tag'        => $tag_label,
		'title'      => get_the_title( $post_id ),
		'dek'        => get_field( 'dek', $post_id ),
		'date'       => get_field( 'display_date', $post_id ) ?: get_the_date( 'j F Y', $post_id ),
		'location'   => get_field( 'location', $post_id ),
		'link'       => get_permalink( $post_id ),
	);
}

/**
 * Renders one .story-card block — shared by archive-story.php (the main
 * Stories grid) and page-templates/grounded.php ("All episodes"), so the
 * two never drift apart.
 */
function suluh_render_story_card( $post_id ) {
	$row      = suluh_story_card_data( $post_id );
	$is_audio = 'grounded' === $row['type_slug'];
	$thumb    = get_the_post_thumbnail_url( $post_id, 'large' );
	?>
	<a class="story-card reveal2" href="<?php echo esc_url( $row['link'] ); ?>">
		<?php if ( $thumb ) : ?>
			<div class="story-img <?php echo esc_attr( $row['type_class'] ); ?>" style="background-image:url(<?php echo esc_url( $thumb ); ?>);background-size:cover;background-position:center"></div>
		<?php else : ?>
			<div class="story-img <?php echo esc_attr( $row['type_class'] ); ?>"><?php echo $is_audio ? 'Episode audio' : 'Photograph'; ?></div>
		<?php endif; ?>
		<?php if ( $row['tag'] ) : ?><span class="eyebrow story-tag <?php echo esc_attr( $row['type_class'] ); ?>"><?php echo wp_kses_post( $row['tag'] ); ?></span><?php endif; ?>
		<h4><?php echo esc_html( $row['title'] ); ?></h4>
		<?php if ( $row['dek'] ) : ?><p><?php echo esc_html( $row['dek'] ); ?></p><?php endif; ?>
		<div class="story-meta"><?php echo esc_html( $row['date'] ); ?><?php echo $row['location'] ? ' &middot; ' . esc_html( $row['location'] ) : ''; ?></div>
	</a>
	<?php
}
