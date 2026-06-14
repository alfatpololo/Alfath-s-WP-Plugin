<?php
/**
 * Plugin Name: Storeberry AI Feature Tabs
 * Description: Custom Elementor widget for Storeberry-style AI feature tabs with editable tab descriptions and flexible content.
 * Version: 1.0.4
 * Author: Muhammad Alfath Aditya
 * Text Domain: storeberry-ai-feature-tabs
 * Requires at least: 5.6
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'STOREBERRY_AFT_VERSION', '1.0.4' );
define( 'STOREBERRY_AFT_PATH', plugin_dir_path( __FILE__ ) );
define( 'STOREBERRY_AFT_URL', plugin_dir_url( __FILE__ ) );

add_action( 'plugins_loaded', 'storeberry_aft_init' );

/**
 * Bootstrap plugin after Elementor is available.
 */
function storeberry_aft_init() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'storeberry_aft_admin_notice' );
		return;
	}

	add_action( 'elementor/elements/categories_registered', 'storeberry_aft_add_category' );
	add_action( 'elementor/widgets/register', 'storeberry_aft_register_widget' );
	add_action( 'wp_enqueue_scripts', 'storeberry_aft_register_assets', 5 );
	add_action( 'elementor/editor/before_enqueue_scripts', 'storeberry_aft_register_assets' );
}

/**
 * Admin notice when Elementor is missing.
 */
function storeberry_aft_admin_notice() {
	echo '<div class="notice notice-warning is-dismissible"><p>'
		. esc_html__( 'Storeberry AI Feature Tabs requires Elementor to be installed and active.', 'storeberry-ai-feature-tabs' )
		. '</p></div>';
}

/**
 * Register custom Elementor category.
 *
 * @param \Elementor\Elements_Manager $elements_manager Elements manager instance.
 */
function storeberry_aft_add_category( $elements_manager ) {
	$elements_manager->add_category(
		'storeberry',
		array(
			'title' => esc_html__( 'Storeberry', 'storeberry-ai-feature-tabs' ),
			'icon'  => 'fa fa-plug',
		)
	);
}

/**
 * Register widget class.
 */
function storeberry_aft_register_widget() {
	require_once STOREBERRY_AFT_PATH . 'widgets/storeberry-ai-feature-tabs-widget.php';
	\Elementor\Plugin::instance()->widgets_manager->register( new \Storeberry_AI_Feature_Tabs_Widget() );
}

/**
 * Register and enqueue frontend assets.
 */
function storeberry_aft_register_assets() {
	$css_file = STOREBERRY_AFT_PATH . 'assets/css/storeberry-ai-feature-tabs.css';
	$js_file  = STOREBERRY_AFT_PATH . 'assets/js/storeberry-ai-feature-tabs.js';

	$css_version = file_exists( $css_file ) ? (string) filemtime( $css_file ) : STOREBERRY_AFT_VERSION;
	$js_version  = file_exists( $js_file ) ? (string) filemtime( $js_file ) : STOREBERRY_AFT_VERSION;

	$style_deps = array();
	if ( wp_style_is( 'elementor-frontend', 'registered' ) ) {
		$style_deps[] = 'elementor-frontend';
	}

	wp_register_style(
		'storeberry-ai-feature-tabs',
		STOREBERRY_AFT_URL . 'assets/css/storeberry-ai-feature-tabs.css',
		$style_deps,
		$css_version
	);

	wp_register_script(
		'storeberry-ai-feature-tabs',
		STOREBERRY_AFT_URL . 'assets/js/storeberry-ai-feature-tabs.js',
		array(),
		$js_version,
		true
	);
}
