<?php
/**
 * Plugin Name: Storeberry Feature Grid Tabs for Elementor
 * Description: Editable Storeberry-style feature tabs with flexible card grid layouts for Elementor Free.
 * Version: 1.0.7
 * Author: Muhammad Alfath Aditya
 * Text Domain: storeberry-feature-grid-tabs
 * Requires at least: 5.6
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'STOREBERRY_FGT_VERSION', '1.0.7' );
define( 'STOREBERRY_FGT_PATH', plugin_dir_path( __FILE__ ) );
define( 'STOREBERRY_FGT_URL', plugin_dir_url( __FILE__ ) );

add_action( 'plugins_loaded', 'storeberry_fgt_init' );

/**
 * Bootstrap plugin after Elementor is available.
 */
function storeberry_fgt_init() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'storeberry_fgt_admin_notice' );
		return;
	}

	add_action( 'elementor/elements/categories_registered', 'storeberry_fgt_add_category' );
	add_action( 'elementor/widgets/register', 'storeberry_fgt_register_widget' );
	add_action( 'wp_enqueue_scripts', 'storeberry_fgt_register_assets', 5 );
	add_action( 'elementor/editor/before_enqueue_scripts', 'storeberry_fgt_register_assets' );
}

/**
 * Admin notice when Elementor is missing.
 */
function storeberry_fgt_admin_notice() {
	echo '<div class="notice notice-warning is-dismissible"><p>'
		. esc_html__( 'Storeberry Feature Grid Tabs requires Elementor to be installed and active.', 'storeberry-feature-grid-tabs' )
		. '</p></div>';
}

/**
 * Register custom Elementor category.
 *
 * @param \Elementor\Elements_Manager $elements_manager Elements manager instance.
 */
function storeberry_fgt_add_category( $elements_manager ) {
	$elements_manager->add_category(
		'storeberry',
		array(
			'title' => esc_html__( 'Storeberry', 'storeberry-feature-grid-tabs' ),
			'icon'  => 'fa fa-plug',
		)
	);
}

/**
 * Register widget class.
 */
function storeberry_fgt_register_widget() {
	require_once STOREBERRY_FGT_PATH . 'widgets/storeberry-feature-grid-tabs-widget.php';
	\Elementor\Plugin::instance()->widgets_manager->register( new \Storeberry_Feature_Grid_Tabs_Widget() );
}

/**
 * Register and enqueue frontend assets.
 */
function storeberry_fgt_register_assets() {
	$css_file = STOREBERRY_FGT_PATH . 'assets/css/storeberry-feature-grid-tabs.css';
	$js_file  = STOREBERRY_FGT_PATH . 'assets/js/storeberry-feature-grid-tabs.js';

	$css_version = file_exists( $css_file ) ? (string) filemtime( $css_file ) : STOREBERRY_FGT_VERSION;
	$js_version  = file_exists( $js_file ) ? (string) filemtime( $js_file ) : STOREBERRY_FGT_VERSION;

	$style_deps = array();
	if ( wp_style_is( 'elementor-frontend', 'registered' ) ) {
		$style_deps[] = 'elementor-frontend';
	}

	wp_register_style(
		'storeberry-feature-grid-tabs',
		STOREBERRY_FGT_URL . 'assets/css/storeberry-feature-grid-tabs.css',
		$style_deps,
		$css_version
	);

	wp_register_script(
		'storeberry-feature-grid-tabs',
		STOREBERRY_FGT_URL . 'assets/js/storeberry-feature-grid-tabs.js',
		array(),
		$js_version,
		true
	);
}
