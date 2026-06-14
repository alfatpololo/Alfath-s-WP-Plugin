<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Alfath_Migration_Exporter {
    public function __construct() {
        add_action( 'wp_ajax_export_database_step', array( $this, 'export_database_step' ) );
        add_action( 'wp_ajax_export_files_step', array( $this, 'export_files_step' ) );
        add_action( 'wp_ajax_build_package', array( $this, 'build_package' ) );
        
        add_action( 'admin_post_alfath_wp_migration_download', array( $this, 'download_package' ) );
        add_action( 'wp_ajax_delete_backup', array( $this, 'delete_backup' ) );
    }

    private function verify_access() {
        check_ajax_referer( 'alfath_migration_nonce', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( 'Unauthorized' );
        }
    }

    public function export_database_step() {
        $this->verify_access();
        $exporter = new Alfath_Migration_Database_Exporter();
        $result = $exporter->export();
        if ( $result ) {
            wp_send_json_success( 'Database exported' );
        } else {
            wp_send_json_error( 'Failed to export database' );
        }
    }

    public function export_files_step() {
        $this->verify_access();
        $type = isset( $_POST['export_type'] ) ? sanitize_text_field( $_POST['export_type'] ) : '';
        $options = $this->get_options_from_post();

        $exporter = new Alfath_Migration_File_Exporter();
        $result = $exporter->export_folder( $type, $options );
        
        if ( $result ) {
            wp_send_json_success( ucfirst($type) . ' exported' );
        } else {
            wp_send_json_error( 'Failed to export ' . $type );
        }
    }

    public function build_package() {
        $this->verify_access();
        $options = $this->get_options_from_post();
        
        $builder = new Alfath_Migration_Package_Builder();
        $result = $builder->build( $options );
        
        if ( $result ) {
            wp_send_json_success( $result );
        } else {
            wp_send_json_error( 'Failed to build package' );
        }
    }

    private function get_options_from_post() {
        return array(
            'exclude_cache' => !empty($_POST['exclude_cache']) ? 1 : 0,
            'exclude_backup' => !empty($_POST['exclude_backup']) ? 1 : 0,
            'exclude_node_modules' => !empty($_POST['exclude_node_modules']) ? 1 : 0,
            'exclude_git' => !empty($_POST['exclude_git']) ? 1 : 0,
        );
    }

    public function download_package() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Unauthorized access.' );
        }

        $file_name = isset( $_GET['file'] ) ? sanitize_text_field( wp_unslash( $_GET['file'] ) ) : '';
        $file_name = basename( $file_name );
        
        if ( empty( $file_name ) || pathinfo( $file_name, PATHINFO_EXTENSION ) !== 'alfathpack' ) {
            wp_die( 'Invalid file requested.' );
        }

        check_admin_referer( 'alfath_wp_migration_download_' . $file_name );

        $exports_dir = Alfath_Migration_Helpers::get_storage_dir( 'exports' );
        $file_path = wp_normalize_path( $exports_dir . '/' . $file_name );

        if ( strpos( $file_path, wp_normalize_path( $exports_dir ) ) !== 0 || ! file_exists( $file_path ) ) {
            wp_die( 'File not found on server.' );
        }

        // Send headers for forcing download
        header( 'Content-Description: File Transfer' );
        header( 'Content-Type: application/octet-stream' );
        header( 'Content-Disposition: attachment; filename="' . $file_name . '"' );
        header( 'Expires: 0' );
        header( 'Cache-Control: no-cache, must-revalidate' );
        header( 'Pragma: public' );
        header( 'Content-Length: ' . filesize( $file_path ) );

        // Securely read the file and exit
        readfile( $file_path );
        exit;
    }

    public function delete_backup() {
        $this->verify_access();
        $file_name = isset( $_POST['file'] ) ? sanitize_text_field( wp_unslash( $_POST['file'] ) ) : '';
        $file_name = basename( $file_name );

        if ( empty( $file_name ) || pathinfo( $file_name, PATHINFO_EXTENSION ) !== 'alfathpack' ) {
            wp_send_json_error( 'Invalid file format.' );
        }

        $exports_dir = Alfath_Migration_Helpers::get_storage_dir( 'exports' );
        $file_path = wp_normalize_path( $exports_dir . '/' . $file_name );

        if ( strpos( $file_path, wp_normalize_path( $exports_dir ) ) === 0 && file_exists( $file_path ) ) {
            unlink( $file_path );
            wp_send_json_success( 'Backup successfully deleted.' );
        } else {
            wp_send_json_error( 'File not found.' );
        }
    }
}
