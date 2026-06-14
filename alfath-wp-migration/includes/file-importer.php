<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Alfath_Migration_File_Importer {
    public function import_files( $type ) {
        if ( ! class_exists( 'ZipArchive' ) ) return false;

        $temp_dir = Alfath_Migration_Helpers::get_storage_dir( 'temp' );
        $files_dir = $temp_dir . '/files';
        
        if ( ! is_dir( $files_dir ) ) {
            return true; // No files to import
        }

        $upload_dir = wp_upload_dir();
        $zip_name = '';
        $dest_dir = '';

        switch ( $type ) {
            case 'uploads':
                $zip_name = 'uploads.zip';
                $dest_dir = $upload_dir['basedir'];
                break;
            case 'themes':
                $zip_name = 'themes.zip';
                $dest_dir = WP_CONTENT_DIR . '/themes';
                break;
            case 'plugins':
                $zip_name = 'plugins.zip';
                $dest_dir = WP_CONTENT_DIR . '/plugins';
                break;
            case 'mu-plugins':
                $zip_name = 'mu-plugins.zip';
                $dest_dir = WP_CONTENT_DIR . '/mu-plugins';
                break;
            default:
                return false;
        }

        $zip_path = $files_dir . '/' . $zip_name;
        if ( file_exists( $zip_path ) ) {
            if ( ! file_exists( $dest_dir ) ) {
                wp_mkdir_p( $dest_dir );
            }

            @set_time_limit(0);
            @ini_set('memory_limit', '1024M');

            $zip = new ZipArchive();
            if ( $zip->open( $zip_path ) === true ) {
                $zip->extractTo( $dest_dir );
                $zip->close();
            }
        }

        return true;
    }
}
