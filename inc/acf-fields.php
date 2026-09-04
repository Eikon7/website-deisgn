<?php
/**
 * ACF field groups for the two CMS-driven post types: Story and
 * Publication. Registered in PHP (not the ACF UI) so the field groups
 * live in version control and travel with the theme on deploy.
 *
 * Requires the free ACF plugin (Advanced Custom Fields). No Pro-only
 * field types are used here.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', 'suluh_register_acf_fields' );

function suluh_register_acf_fields() {

	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	// ---------------------------------------------------------------
	// Publication — Research & Advocacy library row. Fields match the
	// gated-download PDF row on research.html: year, title, description
	// (excerpt), document ID, and the PDF file itself.
	// ---------------------------------------------------------------
	acf_add_local_field_group( array(
		'key'    => 'group_publication',
		'title'  => 'Publication Details',
		'fields' => array(
			array( 'key' => 'field_pub_year', 'label' => 'Year', 'name' => 'year', 'type' => 'number', 'instructions' => 'Shown above the title, e.g. 2026. Rows sort newest first by this value.' ),
			array( 'key' => 'field_pub_docid', 'label' => 'Document ID', 'name' => 'document_id', 'type' => 'text', 'instructions' => 'Displayed under the description, e.g. SULUH-SV-2026-01.' ),
			array( 'key' => 'field_pub_cover', 'label' => 'Cover image', 'name' => 'cover_image', 'type' => 'image', 'return_format' => 'url', 'instructions' => 'Optional — falls back to a plain "Cover" placeholder box when empty, same as research.html.' ),
			array( 'key' => 'field_pub_pdf', 'label' => 'PDF file', 'name' => 'pdf_file', 'type' => 'file', 'return_format' => 'url', 'instructions' => 'The gated download: a visitor must submit their name and a valid email in the modal before this file downloads.' ),
			array( 'key' => 'field_pub_external', 'label' => 'External commentary?', 'name' => 'is_external_commentary', 'type' => 'true_false', 'instructions' => 'Commentary authored by individuals and published elsewhere is listed separately and linked out, rather than sitting in the index alongside the studies.' ),
		),
		'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'publication' ) ) ),
	) );

	// ---------------------------------------------------------------
	// Story — single newsroom stream item. Fields match story-detail.html:
	// dek/lead, display date, location + partners/scale (Convenings fact
	// box, shown only when filled in), episode number + audio (Grounded).
	// ---------------------------------------------------------------
	acf_add_local_field_group( array(
		'key'    => 'group_story',
		'title'  => 'Story Details',
		'fields' => array(
			array( 'key' => 'field_story_dek', 'label' => 'Standfirst / dek', 'name' => 'dek', 'type' => 'textarea', 'rows' => 2, 'instructions' => 'One-line summary shown on the story card and under the headline on the story page.' ),
			array( 'key' => 'field_story_date', 'label' => 'Display date', 'name' => 'display_date', 'type' => 'date_picker', 'display_format' => 'j F Y', 'return_format' => 'j F Y' ),
			array( 'key' => 'field_story_upcoming', 'label' => 'Upcoming', 'name' => 'is_upcoming', 'type' => 'true_false', 'instructions' => 'Convenings only. Pins this story into the "Upcoming" band above the Stories stream until the date passes — then untick it and the story drops into the normal grid.' ),
			array(
				'key'   => 'field_story_factbox_tab',
				'label' => 'Fact box (Convenings)',
				'name'  => 'factbox_tab',
				'type'  => 'tab',
			),
			array( 'key' => 'field_story_location', 'label' => 'Location', 'name' => 'location', 'type' => 'text', 'instructions' => 'Shown in the fact box. Leave every fact-box field empty to hide the box entirely.' ),
			array( 'key' => 'field_story_partners', 'label' => 'Partners', 'name' => 'partners', 'type' => 'text' ),
			array( 'key' => 'field_story_scale', 'label' => 'Scale', 'name' => 'scale', 'type' => 'text', 'instructions' => 'e.g. "700+ attendees".' ),
			array(
				'key'   => 'field_story_grounded_tab',
				'label' => 'Podcast (Grounded)',
				'name'  => 'grounded_tab',
				'type'  => 'tab',
			),
			array( 'key' => 'field_story_episode', 'label' => 'Episode number', 'name' => 'episode_number', 'type' => 'number' ),
			array( 'key' => 'field_story_audio', 'label' => 'Audio embed URL', 'name' => 'audio_url', 'type' => 'url', 'instructions' => 'Renders an <audio> player in place of the photo block on the story page when filled in.' ),
		),
		'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'story' ) ) ),
	) );
}
