<?php
/**
 * Plugin Name: Storeberry Gradient Background Container for Elementor
 * Description: Storeberry-style blurred gradient for Elementor Containers and a stable gradient wrapper widget.
 * Version: 2.1.0
 * Author: Muhammad Alfath Aditya
 * Text Domain: storeberry-gradient-bg-container
 * Requires at least: 5.6
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'STOREBERRY_GBC_VERSION', '2.1.0' );
define( 'STOREBERRY_GBC_PATH', plugin_dir_path( __FILE__ ) );
define( 'STOREBERRY_GBC_URL', plugin_dir_url( __FILE__ ) );

add_action( 'plugins_loaded', 'storeberry_gbc_init' );

/**
 * Bootstrap plugin after Elementor is available.
 */
function storeberry_gbc_init() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'storeberry_gbc_admin_notice' );
		return;
	}

	require_once STOREBERRY_GBC_PATH . 'includes/container-gradient-controls.php';

	add_action( 'elementor/elements/categories_registered', 'storeberry_gbc_add_category' );
	add_action( 'elementor/widgets/register', 'storeberry_gbc_register_widget' );
	add_action( 'wp_enqueue_scripts', 'storeberry_gbc_register_styles', 5 );
	add_action( 'elementor/editor/before_enqueue_scripts', 'storeberry_gbc_register_styles' );
}

/**
 * Admin notice when Elementor is missing.
 */
function storeberry_gbc_admin_notice() {
	echo '<div class="notice notice-warning is-dismissible"><p>'
		. esc_html__( 'Storeberry Gradient Background Container requires Elementor to be installed and active.', 'storeberry-gradient-bg-container' )
		. '</p></div>';
}

/**
 * Register custom Elementor category.
 *
 * @param \Elementor\Elements_Manager $elements_manager Elements manager instance.
 */
function storeberry_gbc_add_category( $elements_manager ) {
	$elements_manager->add_category(
		'storeberry',
		array(
			'title' => esc_html__( 'Storeberry', 'storeberry-gradient-bg-container' ),
			'icon'  => 'fa fa-plug',
		)
	);
}

/**
 * Register stable gradient widget.
 *
 * @param \Elementor\Widgets_Manager $widgets_manager Widgets manager instance.
 */
function storeberry_gbc_register_widget( $widgets_manager ) {
	require_once STOREBERRY_GBC_PATH . 'widgets/storeberry-gradient-bg-container-widget.php';
	$widgets_manager->register( new Storeberry_Gradient_Bg_Container_Widget() );
}

/**
 * Register frontend stylesheet.
 */
function storeberry_gbc_register_styles() {
	$css_file = STOREBERRY_GBC_PATH . 'assets/css/storeberry-gradient-bg-container.css';
	$version  = file_exists( $css_file ) ? (string) filemtime( $css_file ) : STOREBERRY_GBC_VERSION;

	wp_register_style(
		'storeberry-gradient-bg-container',
		STOREBERRY_GBC_URL . 'assets/css/storeberry-gradient-bg-container.css',
		array(),
		$version
	);

	wp_enqueue_style( 'storeberry-gradient-bg-container' );
}
