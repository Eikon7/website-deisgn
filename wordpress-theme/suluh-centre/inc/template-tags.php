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
 * The reusable icon sprite, defined once per page. Mostly the same
 * markup as the static build's inline <symbol> sprite (see research.html
 * / stories.html / story-detail.html / grounded.html), plus five brand
 * icons (Facebook, Instagram, Threads, LinkedIn, TikTok) added for the
 * footer's social links — those aren't in the static build, since the
 * footer there has no social row. Facebook/Instagram/Threads/TikTok
 * paths are from Simple Icons (CC0); LinkedIn isn't in Simple Icons
 * (removed at LinkedIn's request), so that one path is from Bootstrap
 * Icons (MIT) instead.
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
	  <symbol id="c2-ico-facebook" viewBox="0 0 24 24" fill="currentColor">
	    <path d="M9.101 23.691v-7.98H6.627v-3.667h2.474v-1.58c0-4.085 1.848-5.978 5.858-5.978.401 0 .955.042 1.468.103a8.68 8.68 0 0 1 1.141.195v3.325a8.623 8.623 0 0 0-.653-.036 26.805 26.805 0 0 0-.733-.009c-.707 0-1.259.096-1.675.309a1.686 1.686 0 0 0-.679.622c-.258.42-.374.995-.374 1.752v1.297h3.919l-.386 2.103-.287 1.564h-3.246v8.245C19.396 23.238 24 18.179 24 12.044c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.628 3.874 10.35 9.101 11.647Z"/>
	  </symbol>
	  <symbol id="c2-ico-instagram" viewBox="0 0 24 24" fill="currentColor">
	    <path d="M7.0301.084c-1.2768.0602-2.1487.264-2.911.5634-.7888.3075-1.4575.72-2.1228 1.3877-.6652.6677-1.075 1.3368-1.3802 2.127-.2954.7638-.4956 1.6365-.552 2.914-.0564 1.2775-.0689 1.6882-.0626 4.947.0062 3.2586.0206 3.6671.0825 4.9473.061 1.2765.264 2.1482.5635 2.9107.308.7889.72 1.4573 1.388 2.1228.6679.6655 1.3365 1.0743 2.1285 1.38.7632.295 1.6361.4961 2.9134.552 1.2773.056 1.6884.069 4.9462.0627 3.2578-.0062 3.668-.0207 4.9478-.0814 1.28-.0607 2.147-.2652 2.9098-.5633.7889-.3086 1.4578-.72 2.1228-1.3881.665-.6682 1.0745-1.3378 1.3795-2.1284.2957-.7632.4966-1.636.552-2.9124.056-1.2809.0692-1.6898.063-4.948-.0063-3.2583-.021-3.6668-.0817-4.9465-.0607-1.2797-.264-2.1487-.5633-2.9117-.3084-.7889-.72-1.4568-1.3876-2.1228C21.2982 1.33 20.628.9208 19.8378.6165 19.074.321 18.2017.1197 16.9244.0645 15.6471.0093 15.236-.005 11.977.0014 8.718.0076 8.31.0215 7.0301.0839m.1402 21.6932c-1.17-.0509-1.8053-.2453-2.2287-.408-.5606-.216-.96-.4771-1.3819-.895-.422-.4178-.6811-.8186-.9-1.378-.1644-.4234-.3624-1.058-.4171-2.228-.0595-1.2645-.072-1.6442-.079-4.848-.007-3.2037.0053-3.583.0607-4.848.05-1.169.2456-1.805.408-2.2282.216-.5613.4762-.96.895-1.3816.4188-.4217.8184-.6814 1.3783-.9003.423-.1651 1.0575-.3614 2.227-.4171 1.2655-.06 1.6447-.072 4.848-.079 3.2033-.007 3.5835.005 4.8495.0608 1.169.0508 1.8053.2445 2.228.408.5608.216.96.4754 1.3816.895.4217.4194.6816.8176.9005 1.3787.1653.4217.3617 1.056.4169 2.2263.0602 1.2655.0739 1.645.0796 4.848.0058 3.203-.0055 3.5834-.061 4.848-.051 1.17-.245 1.8055-.408 2.2294-.216.5604-.4763.96-.8954 1.3814-.419.4215-.8181.6811-1.3783.9-.4224.1649-1.0577.3617-2.2262.4174-1.2656.0595-1.6448.072-4.8493.079-3.2045.007-3.5825-.006-4.848-.0608M16.953 5.5864A1.44 1.44 0 1 0 18.39 4.144a1.44 1.44 0 0 0-1.437 1.4424M5.8385 12.012c.0067 3.4032 2.7706 6.1557 6.173 6.1493 3.4026-.0065 6.157-2.7701 6.1506-6.1733-.0065-3.4032-2.771-6.1565-6.174-6.1498-3.403.0067-6.156 2.771-6.1496 6.1738M8 12.0077a4 4 0 1 1 4.008 3.9921A3.9996 3.9996 0 0 1 8 12.0077"/>
	  </symbol>
	  <symbol id="c2-ico-threads" viewBox="0 0 24 24" fill="currentColor">
	    <path d="M18.263 11.097c-.03-3.486-1.92-5.586-5.111-5.586-2.13 0-3.922.963-4.863 2.499l2.062 1.438c.535-.843 1.272-1.543 2.628-1.543 1.528 0 2.318.85 2.544 2.431a15 15 0 0 0-2.236-.173c-4.125 0-6.068 1.867-6.068 4.336s1.943 3.99 4.804 3.99c3.139 0 5.013-2.115 5.781-4.735.798.361 1.348 1.204 1.348 2.47 0 3.387-3.907 5.232-7.22 5.232-4.885 0-8.077-3.207-8.077-8.424 0-6.392 4.223-10.487 9.9-10.487 3.808 0 5.69 1.671 6.97 3.914l2.108-1.475C21.44 2.078 18.331 0 13.663 0 6.227 0 1.168 5.277 1.168 12.934c0 7 4.953 11.066 10.856 11.066 4.878 0 9.809-2.846 9.809-7.716 0-2.545-1.46-4.231-3.569-5.187m-6.33 4.855c-1.077 0-2.026-.512-2.026-1.453 0-1.483 1.822-1.934 3.606-1.934.678 0 1.34.045 1.927.173-.422 1.927-1.671 3.215-3.508 3.214Z"/>
	  </symbol>
	  <symbol id="c2-ico-linkedin" viewBox="0 0 16 16" fill="currentColor">
	    <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z"/>
	  </symbol>
	  <symbol id="c2-ico-tiktok" viewBox="0 0 24 24" fill="currentColor">
	    <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
	  </symbol>
	</svg>
	<?php
}

/**
 * Safe wrapper around ACF's get_field(). Every Story/Publication field
 * (dek, display_date, year, pdf_file, etc.) is optional data layered on
 * top of the post — if the ACF plugin isn't installed or gets
 * deactivated, the page should still render (just without that field),
 * not fatal with "Call to undefined function get_field()". Every
 * get_field() call in this theme goes through here rather than calling
 * ACF's function directly.
 */
function suluh_field( $name, $post_id = null ) {
	if ( ! function_exists( 'get_field' ) ) {
		return null;
	}
	return get_field( $name, $post_id );
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
	$types      = ( $types && ! is_wp_error( $types ) ) ? $types : array();
	// A post can carry more than one Publication Type checkbox in
	// wp-admin, but the card only has room to show one badge — so the
	// FIRST assigned term still drives the visible tag/badge/class, same
	// as before. The filter chips, though, need to match on ANY assigned
	// term, not just the first — see 'type_names' below and its use in
	// suluh_render_story_card() / assets/js/concept2.js.
	$term       = $types ? $types[0] : null;
	$episode    = suluh_field( 'episode_number', $post_id );
	$tag_label  = $term ? $term->name : '';
	if ( $term && 'grounded' === $term->slug && $episode ) {
		$tag_label .= ' &middot; Ep ' . esc_html( $episode );
	}

	return array(
		'type_slug'  => $term ? $term->slug : '',
		'type_name'  => $term ? $term->name : '',
		'type_names' => implode( '|', wp_list_pluck( $types, 'name' ) ),
		'type_class' => $term ? suluh_story_type_class( $term->slug ) : '',
		'tag'        => $tag_label,
		'title'      => get_the_title( $post_id ),
		'dek'        => suluh_field( 'dek', $post_id ),
		'date'       => suluh_field( 'display_date', $post_id ) ?: get_the_date( 'j F Y', $post_id ),
		'location'   => suluh_field( 'location', $post_id ),
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
	<a class="story-card reveal2" href="<?php echo esc_url( $row['link'] ); ?>" data-type="<?php echo esc_attr( $row['type_names'] ); ?>">
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
