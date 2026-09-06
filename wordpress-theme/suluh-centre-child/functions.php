<?php
/**
 * Suluh Center Child theme bootstrap.
 *
 * This file runs IN ADDITION to the parent theme's functions.php (unlike
 * templates — e.g. archive-story.php — where a child theme's copy would
 * fully replace the parent's), so everything the parent registers — post
 * types, ACF fields, the download-leads AJAX endpoint, the Grounded
 * admin menu — keeps working untouched. Add new site-specific PHP here;
 * don't duplicate anything the parent already does.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load the parent theme's stylesheet, then this child theme's own — the
 * standard WordPress child-theme pattern. The parent's style.css itself
 * carries no visible CSS (it's just the theme header comment; the real
 * styles are assets/css/concept2.css and pages2.css, enqueued separately
 * by the parent's own suluh_assets() and unaffected by which theme is
 * active), but enqueuing it here is still correct practice in case that
 * ever changes.
 */
function suluh_child_enqueue_styles() {
	$parent = wp_get_theme( get_template() );
	wp_enqueue_style(
		'suluh-parent-style',
		get_template_directory_uri() . '/style.css',
		array(),
		$parent->get( 'Version' )
	);
	wp_enqueue_style(
		'suluh-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'suluh-parent-style' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'suluh_child_enqueue_styles' );
