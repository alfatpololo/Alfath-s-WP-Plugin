<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Alfath_Migration_File_Exporter {
    
    public function export_folder( $type, $options = array() ) {
        if ( ! class_exists( 'ZipArchive' ) ) return false;

        $target_dir = '';
        $zip_name = '';

        switch ( $type ) {
            case 'uploads':
                $upload_dir = wp_upload_dir();
                $target_dir = $upload_dir['basedir'];
                $zip_name = 'uploads.zip';
                break;
            case 'themes':
                $target_dir = WP_CONTENT_DIR . '/themes';
                $zip_name = 'themes.zip';
                break;
            case 'plugins':
                $target_dir = WP_CONTENT_DIR . '/plugins';
                $zip_name = 'plugins.zip';
                break;
            case 'mu-plugins':
                $target_dir = WP_CONTENT_DIR . '/mu-plugins';
                $zip_name = 'mu-plugins.zip';
                break;
            default:
                return false;
        }

        if ( empty( $target_dir ) || ! file_exists( $target_dir ) ) {
            return true; // If folder doesn't exist (like mu-plugins), skip it gracefully
        }

        $temp_dir = Alfath_Migration_Helpers::get_storage_dir( 'temp' );
        $zip_file = $temp_dir . '/' . $zip_name;

        // Ensure temp dir exists
        if ( ! file_exists( $temp_dir ) ) {
            wp_mkdir_p( $temp_dir );
        }

        $zip = new ZipArchive();
        if ( $zip->open( $zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE ) !== true ) {
            return false;
        }

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryWalker( $target_dir ),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        $exclude_cache = !empty($options['exclude_cache']);
        $exclude_backup = !empty($options['exclude_backup']);
        $exclude_node = !empty($options['exclude_node_modules']);
        $exclude_git = !empty($options['exclude_git']);

        $target_dir = wp_normalize_path($target_dir);

        foreach ( $files as $name => $file ) {
            if ( ! $file->isDir() ) {
                $file_path = wp_normalize_path($file->getRealPath());
                
                // Always exclude plugin's own storage
                if ( strpos( $file_path, 'alfath-wp-migration' ) !== false ) continue;
                
                if ( $exclude_cache && ( strpos( $file_path, '/cache/' ) !== false || strpos( $file_path, '/w3tc/' ) !== false || strpos( $file_path, '/wp-rocket/' ) !== false ) ) continue;
                if ( $exclude_backup && ( strpos( $file_path, '/ai1wm-backups/' ) !== false || strpos( $file_path, '/updraft/' ) !== false ) ) continue;
                if ( $exclude_node && strpos( $file_path, '/node_modules/' ) !== false ) continue;
                if ( $exclude_git && strpos( $file_path, '/.git/' ) !== false ) continue;

                $relative_path = ltrim( substr( $file_path, strlen( $target_dir ) ), '/' );
                if ( !empty($relative_path) ) {
                    $zip->addFile( $file_path, $relative_path );
                }
            }
        }

        $zip->close();
        return true;
    }
}

class RecursiveDirectoryWalker extends RecursiveDirectoryIterator {
    public function hasChildren( $allow_links = false ): bool {
        return parent::hasChildren( $allow_links );
    }
}
