<?php
/**
 * Small template helpers shared across templates.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The reusable brand mark + icon sprite, defined once per page.
 * Same markup as the static design sample's inline <symbol> sprite.
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
	  <symbol id="c2-ico-arrow" viewBox="0 0 16 16" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
	    <path d="M2 8h11M8.5 3.5 13 8l-4.5 4.5"/>
	  </symbol>
	  <symbol id="c2-ico-flame-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
	    <path d="M12 2.5c3 3.4 6 6.6 6 10.4a6 6 0 1 1-12 0c0-3.8 3-7 6-10.4Z"/>
	  </symbol>
	  <symbol id="c2-ico-close" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round">
	    <path d="M5 5l10 10M15 5 5 15"/>
	  </symbol>
	</svg>
	<?php
}

/**
 * get_term_link() can return WP_Error (e.g. a term with no language yet
 * under Polylang's force_lang mode). Templates should never have to guard
 * against that individually.
 */
function suluh_term_link( $term, $taxonomy ) {
	$link = get_term_link( $term, $taxonomy );
	return is_wp_error( $link ) ? '#' : $link;
}

/**
 * Story stream query helper. /grounded and /events are filtered views of
 * the same "story" stream (Master Brief §9, Rule 6) rather than separate
 * post types, so they share this one query function.
 *
 * @param string|null $type_slug story_type term slug to filter to, or null for all.
 * @param int         $count     number of stories to return.
 * @param bool        $upcoming_only only return stories flagged as upcoming (Convenings).
 */
function suluh_get_stories( $type_slug = null, $count = 3, $upcoming_only = false ) {
	$args = array(
		'post_type'      => 'story',
		'posts_per_page' => $count,
		'post_status'    => 'publish',
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
	}

	return new WP_Query( $args );
}

/**
 * Format a story's card fields consistently across Home, Stories, Grounded
 * and Events (the "story card" component, Master Brief §10.3 #5).
 */
function suluh_story_card_data( $post_id ) {
	$types = get_the_terms( $post_id, 'story_type' );
	$type_label = ( $types && ! is_wp_error( $types ) ) ? $types[0]->name : '';

	return array(
		'tag'   => $type_label,
		'title' => get_the_title( $post_id ),
		'dek'   => get_field( 'dek', $post_id ),
		'date'  => get_field( 'display_date', $post_id ) ?: get_the_date( 'j F Y', $post_id ),
		'link'  => get_permalink( $post_id ),
		'image' => get_the_post_thumbnail_url( $post_id, 'large' ),
	);
}
