<?php
/**
 * Content model per Website Master Brief §8: five document types
 * (programme, publication, story, person, plus pillar and strand),
 * relationally cross-linked so pillars contain programmes and
 * stories/research/programmes cross-link by pillar and programme tags.
 *
 * /grounded and /events are NOT separate post types — they are filtered
 * views of the single "story" stream (Master Brief §9, Rule 6: one
 * publishing stream). See template-tags.php for the query helpers.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function suluh_register_taxonomies() {

	// Pillar: Community / Youth & Education / Ideas, Ethics & Society.
	register_taxonomy(
		'pillar',
		array( 'programme', 'story', 'publication' ),
		array(
			'labels' => array(
				'name'          => __( 'Pillars', 'suluh-centre' ),
				'singular_name' => __( 'Pillar', 'suluh-centre' ),
			),
			'public'            => true,
			'hierarchical'      => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'work' ),
		)
	);

	// Strand: sub-topics within a pillar (e.g. Women's leadership, Care & wellbeing).
	register_taxonomy(
		'strand',
		array( 'programme' ),
		array(
			'labels' => array(
				'name'          => __( 'Strands', 'suluh-centre' ),
				'singular_name' => __( 'Strand', 'suluh-centre' ),
			),
			'public'            => true,
			'hierarchical'      => true,
			'show_in_rest'      => true,
		)
	);

	// Story type: drives the /stories filters and the /grounded, /events
	// filtered views. One stream, tagged by type, per the seven rules.
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

	// Publication type: Policy brief / Survey / Report / Commentary.
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

	// Programme — the deepest page type. Ten sections per Master Brief §10.3.
	//
	// URL note: the Master Brief's sitemap (§7) shows programme pages flat
	// under /work/{slug}, alongside the three pillar pages at that same
	// depth. WordPress can't register two different content types (a
	// taxonomy archive and a CPT single) on the identical rewrite pattern
	// without the two fighting over which one a given slug resolves to —
	// in testing this produced an intermittent wrong-template bug (the
	// query correctly found the programme post, but WP's is_home flag was
	// also left true from the taxonomy rule, and is_home wins template
	// selection). Rather than paper over a core rewrite-priority conflict,
	// programmes get their own segment. Flag this URL change for Wartek's
	// sign-off since IA/URLs are their call per §5; content and copy are
	// unaffected either way.
	register_post_type(
		'programme',
		array(
			'labels' => array(
				'name'          => __( 'Programmes', 'suluh-centre' ),
				'singular_name' => __( 'Programme', 'suluh-centre' ),
				'add_new_item'  => __( 'Add New Programme', 'suluh-centre' ),
			),
			'public'       => true,
			'hierarchical' => false,
			'has_archive'  => false,
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-groups',
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
			'rewrite'      => array( 'slug' => 'work/programme', 'with_front' => false ),
		)
	);

	// Publication — Research & Advocacy library item.
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

	// Story — the single newsroom stream (news, convenings, podcast episodes,
	// field write-ups). /grounded and /events are filtered archive views.
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

	// Person — Leadership and Advisors, listed on /about/people. No public
	// single template per the brief (the institution is the subject, not
	// individuals) but kept as a CPT so the KL team manages people centrally.
	register_post_type(
		'person',
		array(
			'labels' => array(
				'name'          => __( 'People', 'suluh-centre' ),
				'singular_name' => __( 'Person', 'suluh-centre' ),
				'add_new_item'  => __( 'Add New Person', 'suluh-centre' ),
			),
			'public'       => true,
			'has_archive'  => false,
			'publicly_queryable' => false,
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-admin-users',
			'supports'     => array( 'title', 'thumbnail', 'revisions' ),
		)
	);
}
add_action( 'init', 'suluh_register_post_types' );

/**
 * Default terms for the taxonomies above. Idempotent: only inserts if
 * missing, safe to run on every load via the `after_switch_theme` hook.
 */
function suluh_seed_terms() {
	$pillars = array(
		'community'            => 'Community',
		'youth-education'      => 'Youth & Education',
		'ideas-ethics-society' => 'Ideas, Ethics & Society',
	);
	foreach ( $pillars as $slug => $name ) {
		if ( ! term_exists( $slug, 'pillar' ) ) {
			wp_insert_term( $name, 'pillar', array( 'slug' => $slug ) );
		}
	}

	$story_types = array(
		'news'         => 'News',
		'convenings'   => 'Convenings',
		'grounded'     => 'Grounded',
		'from-the-field' => 'From the Field',
	);
	foreach ( $story_types as $slug => $name ) {
		if ( ! term_exists( $slug, 'story_type' ) ) {
			wp_insert_term( $name, 'story_type', array( 'slug' => $slug ) );
		}
	}

	$pub_types = array(
		'policy-brief' => 'Policy Brief',
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
