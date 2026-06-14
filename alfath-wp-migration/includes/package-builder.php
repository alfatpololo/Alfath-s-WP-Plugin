<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Alfath_Migration_Package_Builder {
    public function build( $options = array() ) {
        global $wpdb;
        $temp_dir = Alfath_Migration_Helpers::get_storage_dir( 'temp' );
        $exports_dir = Alfath_Migration_Helpers::get_storage_dir( 'exports' );
        
        global $wp_version;

        $active_plugins = get_option('active_plugins');
        $active_theme = get_option('stylesheet'); // Current active theme folder

        $manifest = array(
            'plugin_version' => ALFATH_MIGRATION_VERSION,
            'export_date' => current_time( 'mysql' ),
            'site_url' => get_option('siteurl'),
            'home_url' => get_option('home'),
            'table_prefix' => $wpdb->prefix,
            'wordpress_version' => $wp_version,
            'php_version' => phpversion(),
            'mysql_version' => $wpdb->db_version(),
            'active_theme' => $active_theme,
            'active_plugins' => $active_plugins,
            'export_options' => $options
        );

        file_put_contents( $temp_dir . '/manifest.json', wp_json_encode( $manifest, JSON_PRETTY_PRINT ) );

        $package_name = 'alfath-export-' . date('Ymd-His') . '.alfathpack';
        $package_path = $exports_dir . '/' . $package_name;

        if ( ! class_exists( 'ZipArchive' ) ) return false;

        $zip = new ZipArchive();
        if ( $zip->open( $package_path, ZipArchive::CREATE | ZipArchive::OVERWRITE ) !== true ) {
            return false;
        }

        $zip->addFile( $temp_dir . '/manifest.json', 'manifest.json' );
        
        $files_to_add = array(
            'database.sql' => 'database.sql',
            'uploads.zip' => 'files/uploads.zip',
            'themes.zip' => 'files/themes.zip',
            'plugins.zip' => 'files/plugins.zip',
            'mu-plugins.zip' => 'files/mu-plugins.zip'
        );

        foreach ( $files_to_add as $local_file => $zip_path ) {
            $full_path = $temp_dir . '/' . $local_file;
            if ( file_exists( $full_path ) ) {
                $zip->addFile( $full_path, $zip_path );
            }
        }

        $zip->close();

        // Cleanup temp
        @unlink( $temp_dir . '/manifest.json' );
        foreach ( $files_to_add as $local_file => $zip_path ) {
            @unlink( $temp_dir . '/' . $local_file );
        }

        $file_size = filesize( $package_path );
        $download_url = wp_nonce_url( admin_url( 'admin-post.php?action=alfath_wp_migration_download&file=' . rawurlencode( $package_name ) ), 'alfath_wp_migration_download_' . $package_name );

        return array(
            'file_name' => $package_name,
            'file_size' => size_format( $file_size ),
            'download_url' => $download_url
        );
    }
}
