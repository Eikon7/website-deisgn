<?php
/**
 * Suluh Centre theme bootstrap.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SULUH_THEME_VERSION', '0.1.0' );

/**
 * Theme supports and nav menus.
 */
function suluh_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'align-wide' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Navigation', 'suluh-centre' ),
			'footer_work' => __( 'Footer: Work', 'suluh-centre' ),
			'footer_read' => __( 'Footer: Read', 'suluh-centre' ),
			'footer_org' => __( 'Footer: Organisation', 'suluh-centre' ),
		)
	);
}
add_action( 'after_setup_theme', 'suluh_setup' );

/**
 * Styles and scripts. Same asset pipeline as the design sample
 * (concept2.css / concept2.js), just served through WP's enqueue system.
 */
function suluh_assets() {
	wp_enqueue_style( 'suluh-fonts', 'https://fonts.googleapis.com/css2?family=Inria+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Manrope:wght@400;500;600;700;800&display=swap', array(), null );
	wp_enqueue_style( 'suluh-main', get_template_directory_uri() . '/assets/css/concept2.css', array(), SULUH_THEME_VERSION );
	wp_enqueue_style( 'suluh-pages', get_template_directory_uri() . '/assets/css/pages.css', array( 'suluh-main' ), SULUH_THEME_VERSION );
	wp_enqueue_script( 'suluh-main', get_template_directory_uri() . '/assets/js/concept2.js', array(), SULUH_THEME_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'suluh_assets' );

/**
 * These content types are almost entirely ACF-driven (title + custom
 * fields, little to no free-form body copy), so the classic editor keeps
 * the ACF fields immediately visible instead of buried in Gutenberg's
 * collapsed "Meta Boxes" drawer — clearer for a non-technical KL team.
 */
function suluh_classic_editor_for_cpts( $use_block_editor, $post_type ) {
	if ( in_array( $post_type, array( 'programme', 'publication', 'person' ), true ) ) {
		return false;
	}
	return $use_block_editor;
}
add_filter( 'use_block_editor_for_post_type', 'suluh_classic_editor_for_cpts', 10, 2 );

/**
 * Content model, taxonomies, and admin field groups.
 */
require get_template_directory() . '/inc/content-types.php';
require get_template_directory() . '/inc/acf-fields.php';
require get_template_directory() . '/inc/template-tags.php';
