<?php
/**
 * Registers this theme's custom Elementor widgets. `elementor/widgets/register`
 * only ever fires if Elementor is actually active, so this file is safe
 * to always require from functions.php — it simply never runs if
 * Elementor isn't installed.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function suluh_register_elementor_widgets( $widgets_manager ) {
	require_once __DIR__ . '/elementor-widgets/class-suluh-latest-publications-widget.php';
	$widgets_manager->register( new Suluh_Latest_Publications_Widget() );
}
add_action( 'elementor/widgets/register', 'suluh_register_elementor_widgets' );
