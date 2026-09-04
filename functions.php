<?php
/**
 * Suluh Centre theme bootstrap.
 *
 * Scope: this theme exists ONLY to back the three CMS-driven surfaces —
 * Research & Advocacy (publication post type), Stories (story post type),
 * and Grounded (a filtered view of the story stream). Every other page
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
 * Content model, taxonomies, and admin field groups for Story and
 * Publication — the only two content types this theme manages.
 */
require get_template_directory() . '/inc/content-types.php';
require get_template_directory() . '/inc/acf-fields.php';
require get_template_directory() . '/inc/template-tags.php';
