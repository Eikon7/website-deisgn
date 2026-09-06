<?php
/**
 * Suluh Center theme bootstrap.
 *
 * Scope: this theme exists ONLY to back the three CMS-driven surfaces —
 * Research (publication post type, at /research/), Publications (story
 * post type, at /publications/ — see inc/content-types.php for why the
 * PHP post_type keys don't match these labels), and Grounded (a filtered
 * view of the story stream). Every other page
 * (Home, About, Contact, Work, People, the three pillar pages, the
 * programme pages) is a plain WordPress Page built and edited in
 * Elementor — this theme just needs to get out of their way (header.php /
 * footer.php wrap them, the_content() renders Elementor's output).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SULUH_THEME_VERSION', '0.2.0' );

/**
 * Theme supports.
 */
function suluh_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'align-wide' );

	// The header nav and mobile drawer both pull from this one location
	// (see header.php) so editing the menu once in Appearance > Menus
	// keeps both in sync. Nest "Community" / "Youth & Education" /
	// "Ideas, Ethics & Society" under a "Pillars" item to reproduce the
	// dropdown — see wordpress-theme/README.md for the exact structure.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'suluh-centre' ),
	) );
}
add_action( 'after_setup_theme', 'suluh_setup' );

/**
 * Styles and scripts — the exact same files as the static build
 * (assets/css/concept2.css, assets/css/pages2.css, assets/js/concept2.js),
 * just served through WP's enqueue system so every page (Elementor-built
 * or one of the three PHP templates below) shares one design system.
 */
function suluh_assets() {
	wp_enqueue_style( 'suluh-fonts', 'https://fonts.googleapis.com/css2?family=Inria+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Manrope:wght@400;500;600;700;800&display=swap', array(), null );
	wp_enqueue_style( 'suluh-main', get_template_directory_uri() . '/assets/css/concept2.css', array(), SULUH_THEME_VERSION );
	wp_enqueue_style( 'suluh-pages', get_template_directory_uri() . '/assets/css/pages2.css', array( 'suluh-main' ), SULUH_THEME_VERSION );
	wp_enqueue_script( 'suluh-main', get_template_directory_uri() . '/assets/js/concept2.js', array(), SULUH_THEME_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'suluh_assets' );

/**
 * Content model, taxonomies, and admin field groups for the `story` and
 * `publication` post types — the only two content types this theme
 * manages (see inc/content-types.php for their current "Publications"/
 * "Research" labels).
 */
require get_template_directory() . '/inc/content-types.php';
require get_template_directory() . '/inc/acf-fields.php';
require get_template_directory() . '/inc/template-tags.php';

/**
 * Who downloaded which Research item: the "Downloads" list in wp-admin,
 * and the AJAX endpoint the gated-download modal posts to.
 */
require get_template_directory() . '/inc/download-leads.php';

/**
 * The newsroom stream's archive moved from /stories/ to /publications/
 * when it was relabeled "Publications" (see inc/content-types.php). This
 * redirects anyone who still has an old /stories/ URL bookmarked or
 * linked, rather than leaving it 404.
 */
function suluh_redirect_old_stories_urls() {
	if ( ! is_404() ) {
		return;
	}
	$path = trim( wp_parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );
	if ( 'stories' === $path || 0 === strpos( $path, 'stories/' ) ) {
		$new_path = 'publications' . substr( $path, strlen( 'stories' ) );
		wp_safe_redirect( home_url( '/' . $new_path . '/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'suluh_redirect_old_stories_urls' );
