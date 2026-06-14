<?php
/**
 * Plugin Name: Alfath WP Migration
 * Description: Export and import WordPress sites using a single migration package file.
 * Version: 1.0.0
 * Author: Muhammad Alfath Aditya
 * Text Domain: alfath-wp-migration
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

define( 'ALFATH_MIGRATION_VERSION', '1.0.0' );
define( 'ALFATH_MIGRATION_DIR', plugin_dir_path( __FILE__ ) );
define( 'ALFATH_MIGRATION_URL', plugin_dir_url( __FILE__ ) );

// Include required files
require_once ALFATH_MIGRATION_DIR . 'includes/helpers.php';
require_once ALFATH_MIGRATION_DIR . 'includes/admin-page.php';
require_once ALFATH_MIGRATION_DIR . 'includes/database-exporter.php';
require_once ALFATH_MIGRATION_DIR . 'includes/file-exporter.php';
require_once ALFATH_MIGRATION_DIR . 'includes/package-builder.php';
require_once ALFATH_MIGRATION_DIR . 'includes/exporter.php';
require_once ALFATH_MIGRATION_DIR . 'includes/package-reader.php';
require_once ALFATH_MIGRATION_DIR . 'includes/database-importer.php';
require_once ALFATH_MIGRATION_DIR . 'includes/file-importer.php';
require_once ALFATH_MIGRATION_DIR . 'includes/url-replacer.php';
require_once ALFATH_MIGRATION_DIR . 'includes/importer.php';

// Initialization hook
add_action( 'plugins_loaded', 'alfath_migration_init' );

function alfath_migration_init() {
    Alfath_Migration_Helpers::create_storage_directories();
    new Alfath_Migration_Admin_Page();
    new Alfath_Migration_Exporter();
    new Alfath_Migration_Importer();
}

// Activation hook
register_activation_hook( __FILE__, array( 'Alfath_Migration_Helpers', 'create_storage_directories' ) );
