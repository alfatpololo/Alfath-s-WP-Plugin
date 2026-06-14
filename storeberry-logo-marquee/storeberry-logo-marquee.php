<?php
/**
 * Plugin Name: Storeberry Logo Marquee for Elementor
 * Description: A lightweight Elementor widget for creating editable Storeberry-style brand logo marquee sections.
 * Version: 1.0.6
 * Author: Muhammad Alfath Aditya
 * Text Domain: storeberry-logo-marquee
 * Requires at least: 5.6
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'STOREBERRY_LM_VERSION', '1.0.6' );
define( 'STOREBERRY_LM_PATH', plugin_dir_path( __FILE__ ) );
define( 'STOREBERRY_LM_URL', plugin_dir_url( __FILE__ ) );

add_action( 'plugins_loaded', 'storeberry_lm_init' );

function storeberry_lm_init() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'storeberry_lm_admin_notice' );
		return;
	}
	add_action( 'elementor/elements/categories_registered', 'storeberry_lm_add_category' );
	add_action( 'elementor/widgets/register', 'storeberry_lm_register_widget' );
	
	// Register style for Elementor widget to depend on.
	add_action( 'wp_enqueue_scripts', 'storeberry_lm_register_styles', 5 );
	add_action( 'elementor/editor/before_enqueue_scripts', 'storeberry_lm_register_styles' );
}

function storeberry_lm_admin_notice() {
	echo '<div class="notice notice-warning is-dismissible"><p>'
		. esc_html__( 'Storeberry Logo Marquee requires Elementor to be installed and active.', 'storeberry-logo-marquee' )
		. '</p></div>';
}

function storeberry_lm_add_category( $elements_manager ) {
	$elements_manager->add_category(
		'storeberry',
		array(
			'title' => esc_html__( 'Storeberry', 'storeberry-logo-marquee' ),
			'icon'  => 'fa fa-plug',
		)
	);
}

function storeberry_lm_register_widget() {
	require_once STOREBERRY_LM_PATH . 'widgets/storeberry-logo-marquee-widget.php';
	\Elementor\Plugin::instance()->widgets_manager->register( new \Storeberry_Logo_Marquee_Widget() );
}

function storeberry_lm_register_styles() {
	// Use filemtime for bulletproof cache busting.
	$css_file = STOREBERRY_LM_PATH . 'assets/css/storeberry-logo-marquee.css';
	$version  = file_exists( $css_file ) ? filemtime( $css_file ) : STOREBERRY_LM_VERSION;
	
	wp_register_style(
		'storeberry-logo-marquee',
		STOREBERRY_LM_URL . 'assets/css/storeberry-logo-marquee.css',
		array(),
		$version
	);
	
	// Also enqueue it globally just to be safe.
	wp_enqueue_style( 'storeberry-logo-marquee' );
}
