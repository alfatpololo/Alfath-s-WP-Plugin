<?php
/**
 * Plugin Name: Storeberry Feature Cards
 * Description: Editable Storeberry-style stacked feature cards widget for Elementor.
 * Version: 1.0.0
 * Author: Muhammad Alfath Aditya
 * Text Domain: storeberry-feature-cards
 * Requires at least: 5.6
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'STOREBERRY_FC_VERSION', '1.0.0' );
define( 'STOREBERRY_FC_PATH', plugin_dir_path( __FILE__ ) );
define( 'STOREBERRY_FC_URL', plugin_dir_url( __FILE__ ) );

add_action( 'plugins_loaded', 'storeberry_fc_init' );

/**
 * Bootstrap plugin after Elementor is available.
 */
function storeberry_fc_init() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'storeberry_fc_admin_notice' );
		return;
	}

	add_action( 'elementor/elements/categories_registered', 'storeberry_fc_add_category' );
	add_action( 'elementor/widgets/register', 'storeberry_fc_register_widget' );
	add_action( 'wp_enqueue_scripts', 'storeberry_fc_register_styles', 5 );
	add_action( 'elementor/editor/before_enqueue_scripts', 'storeberry_fc_register_styles' );
}

/**
 * Admin notice when Elementor is missing.
 */
function storeberry_fc_admin_notice() {
	echo '<div class="notice notice-warning is-dismissible"><p>'
		. esc_html__( 'Storeberry Feature Cards requires Elementor to be installed and active.', 'storeberry-feature-cards' )
		. '</p></div>';
}

/**
 * Register custom Elementor category.
 *
 * @param \Elementor\Elements_Manager $elements_manager Elements manager instance.
 */
function storeberry_fc_add_category( $elements_manager ) {
	$elements_manager->add_category(
		'storeberry',
		array(
			'title' => esc_html__( 'Storeberry', 'storeberry-feature-cards' ),
			'icon'  => 'fa fa-plug',
		)
	);
}

/**
 * Register widget class.
 */
function storeberry_fc_register_widget() {
	require_once STOREBERRY_FC_PATH . 'widgets/storeberry-feature-cards-widget.php';
	\Elementor\Plugin::instance()->widgets_manager->register( new \Storeberry_Feature_Cards_Widget() );
}

/**
 * Register frontend stylesheet.
 */
function storeberry_fc_register_styles() {
	$css_file = STOREBERRY_FC_PATH . 'assets/css/storeberry-feature-cards.css';
	$version  = file_exists( $css_file ) ? (string) filemtime( $css_file ) : STOREBERRY_FC_VERSION;

	wp_register_style(
		'storeberry-feature-cards',
		STOREBERRY_FC_URL . 'assets/css/storeberry-feature-cards.css',
		array(),
		$version
	);
}
