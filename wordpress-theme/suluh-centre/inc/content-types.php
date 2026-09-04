<?php
/**
 * Content model for the two CMS-driven surfaces: Research & Advocacy
 * (publication) and the Stories newsroom stream (story). Grounded is NOT
 * a separate post type — it's a filtered view of "story" where
 * story_type = grounded (see page-templates/grounded.php and
 * suluh_get_stories() in template-tags.php).
 *
 * Every other page on the site (Home, About, Contact, Work, People, the
 * pillar pages, the programme pages) is a plain Elementor-built Page and
 * needs no post type of its own.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function suluh_register_taxonomies() {

	// Story type: drives the /stories filter chips and the /grounded
	// filtered view.
	register_taxonomy(
		'story_type',
		array( 'story' ),
		array(
			'labels' => array(
				'name'          => __( 'Story Types', 'suluh-centre' ),
				'singular_name' => __( 'Story Type', 'suluh-centre' ),
			),
			'public'       => true,
			'hierarchical' => true,
			'show_in_rest' => true,
		)
	);

	// Publication type: Policy Brief / Survey / Report / Commentary —
	// drives the /research filter chips.
	register_taxonomy(
		'publication_type',
		array( 'publication' ),
		array(
			'labels' => array(
				'name'          => __( 'Publication Types', 'suluh-centre' ),
				'singular_name' => __( 'Publication Type', 'suluh-centre' ),
			),
			'public'       => true,
			'hierarchical' => true,
			'show_in_rest' => true,
		)
	);
}
add_action( 'init', 'suluh_register_taxonomies', 0 );

function suluh_register_post_types() {

	// Publication — Research & Advocacy library item. Archive lives at
	// /research (matches research.html) and is rendered by
	// archive-publication.php.
	register_post_type(
		'publication',
		array(
			'labels' => array(
				'name'          => __( 'Publications', 'suluh-centre' ),
				'singular_name' => __( 'Publication', 'suluh-centre' ),
				'add_new_item'  => __( 'Add New Publication', 'suluh-centre' ),
			),
			'public'       => true,
			'has_archive'  => 'research',
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-media-document',
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
			'rewrite'      => array( 'slug' => 'research', 'with_front' => false ),
		)
	);

	// Story — the single newsroom stream item (news, convenings, podcast
	// episodes, field write-ups). Archive lives at /stories (matches
	// stories.html) and single posts at /stories/{slug} (matches
	// story-detail.html). /grounded is a filtered view of this same post
	// type, not a separate one.
	register_post_type(
		'story',
		array(
			'labels' => array(
				'name'          => __( 'Stories', 'suluh-centre' ),
				'singular_name' => __( 'Story', 'suluh-centre' ),
				'add_new_item'  => __( 'Add New Story', 'suluh-centre' ),
			),
			'public'       => true,
			'has_archive'  => 'stories',
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-megaphone',
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
			'rewrite'      => array( 'slug' => 'stories', 'with_front' => false ),
		)
	);
}
add_action( 'init', 'suluh_register_post_types' );

/**
 * Default terms for the taxonomies above. Idempotent: only inserts if
 * missing, safe to run on every load via the `after_switch_theme` hook.
 */
function suluh_seed_terms() {
	$story_types = array(
		'news'           => 'News',
		'convenings'     => 'Convenings',
		'grounded'       => 'Grounded',
		'from-the-field' => 'From the field',
		'notes'          => 'Notes',
	);
	foreach ( $story_types as $slug => $name ) {
		if ( ! term_exists( $slug, 'story_type' ) ) {
			wp_insert_term( $name, 'story_type', array( 'slug' => $slug ) );
		}
	}

	$pub_types = array(
		'policy-brief' => 'Policy brief',
		'survey'       => 'Survey',
		'report'       => 'Report',
		'commentary'   => 'Commentary',
	);
	foreach ( $pub_types as $slug => $name ) {
		if ( ! term_exists( $slug, 'publication_type' ) ) {
			wp_insert_term( $name, 'publication_type', array( 'slug' => $slug ) );
		}
	}
}
add_action( 'after_switch_theme', 'suluh_seed_terms' );
