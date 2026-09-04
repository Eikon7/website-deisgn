<?php
/**
 * Records who downloads which Research publication. The gate itself
 * (name + email required before the file downloads) is still enforced
 * client-side in assets/js/concept2.js, same as the approved static
 * build — this just adds the piece that was deliberately deferred
 * until now: actually keeping the submission somewhere you can look it
 * up, instead of validating and discarding it.
 *
 * Storage is a private "download_lead" post per submission (title
 * doubles as the admin search index: "Name <email> — Publication
 * title"), rather than a bespoke database table, so the admin list,
 * sorting, and search all come from WordPress core for free.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function suluh_register_download_lead_cpt() {
	register_post_type( 'download_lead', array(
		'labels' => array(
			'name'          => __( 'Downloads', 'suluh-centre' ),
			'singular_name' => __( 'Download', 'suluh-centre' ),
			'all_items'     => __( 'Downloads', 'suluh-centre' ),
		),
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'menu_icon'          => 'dashicons-download',
		'menu_position'      => 26,
		'capabilities'       => array(
			'create_posts' => 'do_not_allow', // Log entries are created by the AJAX handler below, never by hand in wp-admin.
		),
		'map_meta_cap'       => true,
		'supports'           => array( 'title' ),
		'show_in_rest'       => false,
	) );
}
add_action( 'init', 'suluh_register_download_lead_cpt' );

/**
 * Admin list columns: Name, Email, Publication, Date — everything you
 * need to answer "who downloaded what, and when" without opening each
 * entry.
 */
function suluh_download_lead_columns( $columns ) {
	$columns = array(
		'cb'          => $columns['cb'],
		'lead_name'   => __( 'Name', 'suluh-centre' ),
		'lead_email'  => __( 'Email', 'suluh-centre' ),
		'publication' => __( 'Publication', 'suluh-centre' ),
		'date'        => __( 'Date', 'suluh-centre' ),
	);
	return $columns;
}
add_filter( 'manage_download_lead_posts_columns', 'suluh_download_lead_columns' );

function suluh_download_lead_column_content( $column, $post_id ) {
	switch ( $column ) {
		case 'lead_name':
			echo esc_html( get_post_meta( $post_id, 'lead_name', true ) );
			break;
		case 'lead_email':
			$email = get_post_meta( $post_id, 'lead_email', true );
			echo $email ? '<a href="' . esc_url( 'mailto:' . $email ) . '">' . esc_html( $email ) . '</a>' : '';
			break;
		case 'publication':
			$pub_id = (int) get_post_meta( $post_id, 'publication_id', true );
			$title  = get_post_meta( $post_id, 'publication_title', true );
			if ( $pub_id && get_post( $pub_id ) ) {
				echo '<a href="' . esc_url( get_edit_post_link( $pub_id ) ) . '">' . esc_html( $title ) . '</a>';
			} else {
				echo esc_html( $title );
			}
			break;
	}
}
add_action( 'manage_download_lead_posts_custom_column', 'suluh_download_lead_column_content', 10, 2 );

function suluh_download_lead_sortable_columns( $columns ) {
	$columns['lead_name']  = 'lead_name';
	$columns['lead_email'] = 'lead_email';
	return $columns;
}
add_filter( 'manage_edit-download_lead_sortable_columns', 'suluh_download_lead_sortable_columns' );

/**
 * The AJAX endpoint the gated-download modal posts to. Validates
 * server-side (never trust the client-side check alone), records the
 * lead, and hands back the real PDF URL for the browser to download —
 * looked up from the Publication post itself by ID, not from anything
 * the client sent, since a request is just as easy to forge as the
 * download link it's meant to gate.
 */
function suluh_capture_download_lead() {
	check_ajax_referer( 'suluh_download', 'nonce' );

	$name   = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email  = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$pub_id = isset( $_POST['pub_id'] ) ? absint( $_POST['pub_id'] ) : 0;

	if ( ! $name || ! is_email( $email ) ) {
		wp_send_json_error( array( 'message' => __( 'Please enter your name and a valid email address.', 'suluh-centre' ) ), 400 );
	}

	$publication = $pub_id ? get_post( $pub_id ) : null;
	if ( ! $publication || 'publication' !== $publication->post_type ) {
		wp_send_json_error( array( 'message' => __( 'That publication could not be found.', 'suluh-centre' ) ), 404 );
	}

	$pdf_url = suluh_field( 'pdf_file', $pub_id );
	if ( ! $pdf_url ) {
		wp_send_json_error( array( 'message' => __( 'No PDF is attached to this publication yet.', 'suluh-centre' ) ), 404 );
	}

	$lead_id = wp_insert_post( array(
		'post_type'   => 'download_lead',
		'post_status' => 'publish',
		'post_title'  => sprintf( '%s <%s> — %s', $name, $email, $publication->post_title ),
	), true );

	if ( is_wp_error( $lead_id ) ) {
		wp_send_json_error( array( 'message' => __( 'Something went wrong recording your request. Please try again.', 'suluh-centre' ) ), 500 );
	}

	update_post_meta( $lead_id, 'lead_name', $name );
	update_post_meta( $lead_id, 'lead_email', $email );
	update_post_meta( $lead_id, 'publication_id', $pub_id );
	update_post_meta( $lead_id, 'publication_title', $publication->post_title );

	wp_send_json_success( array( 'download_url' => esc_url_raw( $pdf_url ) ) );
}
add_action( 'wp_ajax_suluh_capture_download_lead', 'suluh_capture_download_lead' );
add_action( 'wp_ajax_nopriv_suluh_capture_download_lead', 'suluh_capture_download_lead' );

/**
 * Hands the AJAX URL + a nonce to assets/js/concept2.js. The same JS
 * file also runs unchanged on the plain static HTML build (no
 * WordPress, no admin-ajax.php) — it checks for this object before
 * trying to use it, and falls back to the old client-only behavior
 * when it's absent.
 */
function suluh_localize_download_gate() {
	wp_localize_script( 'suluh-main', 'suluhDownloadGate', array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'suluh_download' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'suluh_localize_download_gate', 20 );
