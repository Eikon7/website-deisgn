<?php
/**
 * ACF field groups for the five document types (Master Brief §8).
 *
 * NOTE ON FIELD SCHEMAS: the Master Brief defers full field-level schemas to
 * the Website Information Architecture document, which is referenced but not
 * included in this build's source material. The fields below are a
 * reasonable first pass inferred from the brief, the wireframe, and the
 * component list (§10.3) — confirm against the IA doc and adjust before
 * content entry begins in earnest.
 *
 * NOTE ON BILINGUAL: Polylang duplicates a post per language and links the
 * pair as translations of each other, rather than storing EN/BM in one post.
 * These ACF fields therefore hold ONE language's values; the KL team fills
 * in the same field group again on the linked BM post. This satisfies
 * "every text field is bilingual" (§12) without a bespoke dual-field UI.
 *
 * NOTE ON ACF FREE VS PRO: Repeater, Gallery and Flexible Content are PRO-only
 * fields. This local dev environment runs ACF Free (no license key available
 * in this sandbox), so the fields below use `acf_is_pro()` to register the
 * real Repeater/Gallery fields when PRO is installed, and fall back to a
 * fixed number of Group fields on Free so the admin still works today.
 * Buy and activate ACF PRO before real content entry begins — key facts,
 * partners, voices and the photo set on the Programme template are all
 * naturally variable-length lists, which only Free's fallback approximates.
 *
 * Registered in PHP (not the ACF UI) so the field groups live in version
 * control and travel with the theme on deploy.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', 'suluh_register_acf_fields' );

function suluh_acf_pro() {
	return function_exists( 'acf_is_pro' ) && acf_is_pro();
}

function suluh_register_acf_fields() {

	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$pro = suluh_acf_pro();

	// ---------------------------------------------------------------
	// Programme — the deepest template. Ten sections per §10.3 #9.
	// ---------------------------------------------------------------
	$programme_fields = array(
		array( 'key' => 'field_prog_tense', 'label' => 'Tense line', 'name' => 'tense_line', 'type' => 'text', 'instructions' => 'e.g. "The present." — sits above the title block.' ),
	);

	if ( $pro ) {
		$programme_fields[] = array( 'key' => 'field_prog_keyfacts', 'label' => 'Key facts strip', 'name' => 'key_facts', 'type' => 'repeater', 'layout' => 'table', 'sub_fields' => array(
			array( 'key' => 'field_kf_label', 'label' => 'Label', 'name' => 'label', 'type' => 'text' ),
			array( 'key' => 'field_kf_value', 'label' => 'Value', 'name' => 'value', 'type' => 'text' ),
		) );
	} else {
		for ( $i = 1; $i <= 4; $i++ ) {
			$programme_fields[] = array( 'key' => "field_prog_kf_{$i}", 'label' => "Key fact {$i}", 'name' => "key_fact_{$i}", 'type' => 'group', 'instructions' => $i === 1 ? 'ACF Free fallback: up to 4 fixed fact slots. Upgrade to ACF PRO for an unlimited repeater.' : '', 'sub_fields' => array(
				array( 'key' => "field_kf_{$i}_label", 'label' => 'Label', 'name' => 'label', 'type' => 'text' ),
				array( 'key' => "field_kf_{$i}_value", 'label' => 'Value', 'name' => 'value', 'type' => 'text' ),
			) );
		}
	}

	$programme_fields[] = array( 'key' => 'field_prog_hero', 'label' => 'Hero band image', 'name' => 'hero_image', 'type' => 'image', 'instructions' => 'Falls back to the Forest Green flame field when empty (§11 design test).', 'return_format' => 'url' );
	$programme_fields[] = array( 'key' => 'field_prog_what', 'label' => 'What it is', 'name' => 'what_it_is', 'type' => 'wysiwyg', 'tabs' => 'visual', 'toolbar' => 'basic' );
	$programme_fields[] = array( 'key' => 'field_prog_why', 'label' => 'Why it exists', 'name' => 'why_it_exists', 'type' => 'wysiwyg', 'tabs' => 'visual', 'toolbar' => 'basic' );
	$programme_fields[] = array( 'key' => 'field_prog_how', 'label' => 'How it works', 'name' => 'how_it_works', 'type' => 'wysiwyg', 'tabs' => 'visual', 'toolbar' => 'basic' );

	if ( $pro ) {
		$programme_fields[] = array( 'key' => 'field_prog_partners', 'label' => 'Partners', 'name' => 'partners', 'type' => 'repeater', 'layout' => 'table', 'sub_fields' => array(
			array( 'key' => 'field_partner_name', 'label' => 'Name', 'name' => 'name', 'type' => 'text' ),
			array( 'key' => 'field_partner_logo', 'label' => 'Logo', 'name' => 'logo', 'type' => 'image', 'return_format' => 'url' ),
			array( 'key' => 'field_partner_url', 'label' => 'URL', 'name' => 'url', 'type' => 'url' ),
		) );
		$programme_fields[] = array( 'key' => 'field_prog_voices', 'label' => 'Voices (quotes)', 'name' => 'voices', 'type' => 'repeater', 'layout' => 'block', 'sub_fields' => array(
			array( 'key' => 'field_voice_quote', 'label' => 'Quote', 'name' => 'quote', 'type' => 'textarea', 'rows' => 2 ),
			array( 'key' => 'field_voice_name', 'label' => 'Name', 'name' => 'name', 'type' => 'text' ),
			array( 'key' => 'field_voice_role', 'label' => 'Role', 'name' => 'role', 'type' => 'text' ),
			array( 'key' => 'field_voice_portrait', 'label' => 'Portrait', 'name' => 'portrait', 'type' => 'image', 'return_format' => 'url' ),
		) );
		$programme_fields[] = array( 'key' => 'field_prog_gallery', 'label' => 'Photo set', 'name' => 'photo_set', 'type' => 'gallery', 'return_format' => 'url' );
	} else {
		for ( $i = 1; $i <= 3; $i++ ) {
			$programme_fields[] = array( 'key' => "field_prog_partner_{$i}", 'label' => "Partner {$i}", 'name' => "partner_{$i}", 'type' => 'group', 'instructions' => $i === 1 ? 'ACF Free fallback: up to 3 fixed partner slots (brief allows a max of 3 before an acknowledgement frame anyway).' : '', 'sub_fields' => array(
				array( 'key' => "field_partner_{$i}_name", 'label' => 'Name', 'name' => 'name', 'type' => 'text' ),
				array( 'key' => "field_partner_{$i}_logo", 'label' => 'Logo', 'name' => 'logo', 'type' => 'image', 'return_format' => 'url' ),
				array( 'key' => "field_partner_{$i}_url", 'label' => 'URL', 'name' => 'url', 'type' => 'url' ),
			) );
		}
		for ( $i = 1; $i <= 2; $i++ ) {
			$programme_fields[] = array( 'key' => "field_prog_voice_{$i}", 'label' => "Voice {$i}", 'name' => "voice_{$i}", 'type' => 'group', 'instructions' => $i === 1 ? 'ACF Free fallback: up to 2 fixed voice slots. Upgrade to ACF PRO for an unlimited repeater.' : '', 'sub_fields' => array(
				array( 'key' => "field_voice_{$i}_quote", 'label' => 'Quote', 'name' => 'quote', 'type' => 'textarea', 'rows' => 2 ),
				array( 'key' => "field_voice_{$i}_name", 'label' => 'Name', 'name' => 'name', 'type' => 'text' ),
				array( 'key' => "field_voice_{$i}_role", 'label' => 'Role', 'name' => 'role', 'type' => 'text' ),
				array( 'key' => "field_voice_{$i}_portrait", 'label' => 'Portrait', 'name' => 'portrait', 'type' => 'image', 'return_format' => 'url' ),
			) );
		}
		for ( $i = 1; $i <= 6; $i++ ) {
			$programme_fields[] = array( 'key' => "field_prog_photo_{$i}", 'label' => "Photo set image {$i}", 'name' => "photo_{$i}", 'type' => 'image', 'return_format' => 'url', 'instructions' => $i === 1 ? 'ACF Free fallback: up to 6 fixed image slots. Upgrade to ACF PRO for a proper gallery field.' : '' );
		}
	}

	$programme_fields[] = array( 'key' => 'field_prog_next', 'label' => 'What comes next', 'name' => 'next', 'type' => 'textarea', 'rows' => 3 );
	$programme_fields[] = array( 'key' => 'field_prog_programme_page', 'label' => 'Is this a full or thin programme page?', 'name' => 'depth', 'type' => 'select', 'choices' => array( 'full' => 'Full (all ten sections)', 'thin' => 'Thin (title, hero, what/why/how only)' ), 'default_value' => 'full' );

	acf_add_local_field_group( array(
		'key'      => 'group_programme',
		'title'    => 'Programme Details',
		'fields'   => $programme_fields,
		'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'programme' ) ) ),
	) );

	// ---------------------------------------------------------------
	// Publication — Research & Advocacy library row.
	// ---------------------------------------------------------------
	acf_add_local_field_group( array(
		'key'    => 'group_publication',
		'title'  => 'Publication Details',
		'fields' => array(
			array( 'key' => 'field_pub_year', 'label' => 'Year', 'name' => 'year', 'type' => 'number' ),
			array( 'key' => 'field_pub_docid', 'label' => 'Document ID', 'name' => 'document_id', 'type' => 'text', 'instructions' => 'Displayed on the publication row, e.g. SC-RES-2026-014.' ),
			array( 'key' => 'field_pub_cover', 'label' => 'Cover image', 'name' => 'cover_image', 'type' => 'image', 'return_format' => 'url' ),
			array( 'key' => 'field_pub_pdf', 'label' => 'PDF file', 'name' => 'pdf_file', 'type' => 'file', 'return_format' => 'url' ),
			array( 'key' => 'field_pub_authors', 'label' => 'Authors / attribution', 'name' => 'authors', 'type' => 'text' ),
			array( 'key' => 'field_pub_partners', 'label' => 'Related programmes', 'name' => 'related_programmes', 'type' => 'relationship', 'post_type' => array( 'programme' ) ),
			array( 'key' => 'field_pub_external', 'label' => 'External commentary?', 'name' => 'is_external_commentary', 'type' => 'true_false', 'instructions' => 'Commentary authored by individuals and published elsewhere lists separately and links out (§8), rather than sitting in the index alongside studies.' ),
		),
		'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'publication' ) ) ),
	) );

	// ---------------------------------------------------------------
	// Story — single newsroom stream item.
	// ---------------------------------------------------------------
	acf_add_local_field_group( array(
		'key'    => 'group_story',
		'title'  => 'Story Details',
		'fields' => array(
			array( 'key' => 'field_story_dek', 'label' => 'Standfirst / dek', 'name' => 'dek', 'type' => 'textarea', 'rows' => 2, 'instructions' => 'One-line summary shown on story cards.' ),
			array( 'key' => 'field_story_date', 'label' => 'Display date', 'name' => 'display_date', 'type' => 'date_picker', 'display_format' => 'j F Y', 'return_format' => 'j F Y' ),
			array( 'key' => 'field_story_location', 'label' => 'Location', 'name' => 'location', 'type' => 'text' ),
			array( 'key' => 'field_story_upcoming', 'label' => 'Upcoming (for Convenings)', 'name' => 'is_upcoming', 'type' => 'true_false' ),
			array( 'key' => 'field_story_episode', 'label' => 'Episode number (Grounded only)', 'name' => 'episode_number', 'type' => 'number' ),
			array( 'key' => 'field_story_audio', 'label' => 'Audio embed URL (Grounded only)', 'name' => 'audio_url', 'type' => 'url' ),
			array( 'key' => 'field_story_related_pillar', 'label' => 'Related pillar', 'name' => 'related_pillar_tag', 'type' => 'taxonomy', 'taxonomy' => 'pillar', 'field_type' => 'select', 'allow_null' => 1 ),
			array( 'key' => 'field_story_related_programme', 'label' => 'Related programme', 'name' => 'related_programme', 'type' => 'post_object', 'post_type' => array( 'programme' ), 'allow_null' => 1 ),
		),
		'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'story' ) ) ),
	) );

	// ---------------------------------------------------------------
	// Person — Leadership and Advisors.
	// ---------------------------------------------------------------
	acf_add_local_field_group( array(
		'key'    => 'group_person',
		'title'  => 'Person Details',
		'fields' => array(
			array( 'key' => 'field_person_group', 'label' => 'Group', 'name' => 'person_group', 'type' => 'select', 'choices' => array( 'leadership' => 'Leadership', 'advisors' => 'Advisors' ) ),
			array( 'key' => 'field_person_role', 'label' => 'Role', 'name' => 'role', 'type' => 'text' ),
			array( 'key' => 'field_person_bio', 'label' => 'Bio', 'name' => 'bio', 'type' => 'textarea', 'rows' => 3, 'instructions' => 'Same visual weight for every entry, the Chair included (§4).' ),
			array( 'key' => 'field_person_consent', 'label' => 'Publish consent recorded?', 'name' => 'consent_recorded', 'type' => 'true_false', 'instructions' => 'Nobody publishes without recorded consent.' ),
		),
		'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'person' ) ) ),
	) );
}
