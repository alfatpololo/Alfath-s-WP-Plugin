<?php
/**
 * Plugin Name: Storeberry Booking Form for Elementor
 * Description: A clean Storeberry-style booking form widget for Elementor Free.
 * Version: 1.0.1
 * Author: Muhammad Alfath Aditya
 * Text Domain: storeberry-booking-form
 * Requires at least: 5.6
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'STOREBERRY_BF_VERSION', '1.0.1' );
define( 'STOREBERRY_BF_PATH', plugin_dir_path( __FILE__ ) );
define( 'STOREBERRY_BF_URL', plugin_dir_url( __FILE__ ) );

add_action( 'plugins_loaded', 'storeberry_bf_init' );

/**
 * Bootstrap plugin after Elementor is available.
 */
function storeberry_bf_init() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'storeberry_bf_admin_notice' );
		return;
	}

	require_once STOREBERRY_BF_PATH . 'includes/form-handler.php';
	Storeberry_Booking_Form_Handler::init();

	add_action( 'elementor/elements/categories_registered', 'storeberry_bf_add_category' );
	add_action( 'elementor/widgets/register', 'storeberry_bf_register_widget' );
	add_action( 'wp_enqueue_scripts', 'storeberry_bf_register_assets', 5 );
	add_action( 'elementor/editor/before_enqueue_scripts', 'storeberry_bf_register_assets' );
}

/**
 * Admin notice when Elementor is missing.
 */
function storeberry_bf_admin_notice() {
	echo '<div class="notice notice-warning is-dismissible"><p>'
		. esc_html__( 'Storeberry Booking Form requires Elementor to be installed and active.', 'storeberry-booking-form' )
		. '</p></div>';
}

/**
 * Register custom Elementor category.
 *
 * @param \Elementor\Elements_Manager $elements_manager Elements manager instance.
 */
function storeberry_bf_add_category( $elements_manager ) {
	$elements_manager->add_category(
		'storeberry',
		array(
			'title' => esc_html__( 'Storeberry', 'storeberry-booking-form' ),
			'icon'  => 'fa fa-plug',
		)
	);
}

/**
 * Register widget class.
 */
function storeberry_bf_register_widget() {
	require_once STOREBERRY_BF_PATH . 'widgets/storeberry-booking-form-widget.php';
	\Elementor\Plugin::instance()->widgets_manager->register( new \Storeberry_Booking_Form_Widget() );
}

/**
 * Register and enqueue frontend assets.
 */
function storeberry_bf_register_assets() {
	$css_file = STOREBERRY_BF_PATH . 'assets/css/storeberry-booking-form.css';
	$js_file  = STOREBERRY_BF_PATH . 'assets/js/storeberry-booking-form.js';

	$css_version = file_exists( $css_file ) ? (string) filemtime( $css_file ) : STOREBERRY_BF_VERSION;
	$js_version  = file_exists( $js_file ) ? (string) filemtime( $js_file ) : STOREBERRY_BF_VERSION;

	wp_register_style(
		'storeberry-booking-form',
		STOREBERRY_BF_URL . 'assets/css/storeberry-booking-form.css',
		array(),
		$css_version
	);

	wp_register_script(
		'storeberry-booking-form',
		STOREBERRY_BF_URL . 'assets/js/storeberry-booking-form.js',
		array(),
		$js_version,
		true
	);

	wp_localize_script(
		'storeberry-booking-form',
		'storeberryBookingForm',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'action'  => Storeberry_Booking_Form_Handler::AJAX_ACTION,
			'nonce'   => wp_create_nonce( Storeberry_Booking_Form_Handler::NONCE_ACTION ),
		)
	);
}
