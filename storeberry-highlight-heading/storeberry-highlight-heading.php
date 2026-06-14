<?php
/**
 * Plugin Name: Storeberry Highlight Heading
 * Description: Editable highlighted heading widget for Elementor.
 * Version: 1.0.0
 * Author: Muhammad Alfath Aditya
 * Text Domain: storeberry-highlight-heading
 * Requires at least: 5.6
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'STOREBERRY_HH_VERSION', '1.0.0' );
define( 'STOREBERRY_HH_PATH', plugin_dir_path( __FILE__ ) );
define( 'STOREBERRY_HH_URL', plugin_dir_url( __FILE__ ) );

add_action( 'plugins_loaded', 'storeberry_hh_init' );

/**
 * Bootstrap plugin after Elementor is available.
 */
function storeberry_hh_init() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'storeberry_hh_admin_notice' );
		return;
	}

	add_action( 'elementor/elements/categories_registered', 'storeberry_hh_add_category' );
	add_action( 'elementor/widgets/register', 'storeberry_hh_register_widget' );
	add_action( 'wp_enqueue_scripts', 'storeberry_hh_register_styles', 5 );
	add_action( 'elementor/editor/before_enqueue_scripts', 'storeberry_hh_register_styles' );
}

/**
 * Admin notice when Elementor is missing.
 */
function storeberry_hh_admin_notice() {
	echo '<div class="notice notice-warning is-dismissible"><p>'
		. esc_html__( 'Storeberry Highlight Heading requires Elementor to be installed and active.', 'storeberry-highlight-heading' )
		. '</p></div>';
}

/**
 * Register custom Elementor category.
 *
 * @param \Elementor\Elements_Manager $elements_manager Elements manager instance.
 */
function storeberry_hh_add_category( $elements_manager ) {
	$elements_manager->add_category(
		'storeberry',
		array(
			'title' => esc_html__( 'Storeberry', 'storeberry-highlight-heading' ),
			'icon'  => 'fa fa-plug',
		)
	);
}

/**
 * Register widget class.
 */
function storeberry_hh_register_widget() {
	require_once STOREBERRY_HH_PATH . 'widgets/storeberry-highlight-heading-widget.php';
	\Elementor\Plugin::instance()->widgets_manager->register( new \Storeberry_Highlight_Heading_Widget() );
}

/**
 * Register frontend stylesheet.
 */
function storeberry_hh_register_styles() {
	$css_file = STOREBERRY_HH_PATH . 'assets/css/storeberry-highlight-heading.css';
	$version  = file_exists( $css_file ) ? (string) filemtime( $css_file ) : STOREBERRY_HH_VERSION;

	wp_register_style(
		'storeberry-highlight-heading',
		STOREBERRY_HH_URL . 'assets/css/storeberry-highlight-heading.css',
		array(),
		$version
	);
}
