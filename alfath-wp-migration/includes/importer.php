<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Alfath_Migration_Importer {
    public function __construct() {
        add_action( 'wp_ajax_upload_import_package', array( $this, 'upload_import_package' ) );
        add_action( 'wp_ajax_upload_import_chunk', array( $this, 'upload_import_chunk' ) );
        add_action( 'wp_ajax_extract_package', array( $this, 'extract_package' ) );
        add_action( 'wp_ajax_import_database_step', array( $this, 'import_database_step' ) );
        add_action( 'wp_ajax_import_files_step', array( $this, 'import_files_step' ) );
        add_action( 'wp_ajax_replace_urls_step', array( $this, 'replace_urls_step' ) );

        // Add nopriv for steps that happen AFTER database import destroys the session!
        add_action( 'wp_ajax_nopriv_import_files_step', array( $this, 'import_files_step' ) );
        add_action( 'wp_ajax_nopriv_replace_urls_step', array( $this, 'replace_urls_step' ) );
    }

    private function verify_access() {
        $temp_dir = Alfath_Migration_Helpers::get_storage_dir( 'temp' );
        $token_file = $temp_dir . '/migration_token.txt';
        
        if ( file_exists( $token_file ) && isset( $_POST['migration_token'] ) ) {
            $saved_token = file_get_contents( $token_file );
            if ( ! empty( $saved_token ) && $saved_token === $_POST['migration_token'] ) {
                return true; // Bypass auth because we are mid-migration
            }
        }

        check_ajax_referer( 'alfath_migration_nonce', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( 'Unauthorized' );
        }
    }

    public function upload_import_package() {
        $this->verify_access();
        if ( empty( $_FILES['package'] ) || $_FILES['package']['error'] !== UPLOAD_ERR_OK ) wp_send_json_error( 'Upload failed' );
        $file = $_FILES['package'];
        if ( pathinfo( $file['name'], PATHINFO_EXTENSION ) !== 'alfathpack' ) wp_send_json_error( 'Invalid file type.' );
        $imports_dir = Alfath_Migration_Helpers::get_storage_dir( 'imports' );
        $target_path = $imports_dir . '/' . basename( $file['name'] );
        if ( move_uploaded_file( $file['tmp_name'], $target_path ) ) {
            $reader = new Alfath_Migration_Package_Reader();
            $manifest = $reader->read_manifest( $target_path );
            if ( $manifest ) wp_send_json_success( array( 'package_path' => $target_path, 'manifest' => $manifest ) );
            else wp_send_json_error( 'Invalid package or missing manifest' );
        } else wp_send_json_error( 'Could not save uploaded file' );
    }

    public function upload_import_chunk() {
        $this->verify_access();
        if ( empty( $_FILES['chunk'] ) || $_FILES['chunk']['error'] !== UPLOAD_ERR_OK ) wp_send_json_error( 'Chunk upload failed' );
        $chunk = $_FILES['chunk']['tmp_name'];
        $chunk_index = isset( $_POST['chunk_index'] ) ? intval( $_POST['chunk_index'] ) : 0;
        $total_chunks = isset( $_POST['total_chunks'] ) ? intval( $_POST['total_chunks'] ) : 1;
        $file_id = isset( $_POST['file_id'] ) ? sanitize_text_field( $_POST['file_id'] ) : '';
        $file_name = isset( $_POST['file_name'] ) ? sanitize_text_field( wp_unslash( $_POST['file_name'] ) ) : '';
        $file_name = basename( $file_name );
        if ( pathinfo( $file_name, PATHINFO_EXTENSION ) !== 'alfathpack' ) wp_send_json_error( 'Invalid file type.' );
        
        $temp_dir = Alfath_Migration_Helpers::get_storage_dir( 'temp' );
        $temp_file = $temp_dir . '/' . md5( $file_id ) . '.part';
        
        $out = fopen( $temp_file, $chunk_index === 0 ? 'w' : 'a' );
        if ( ! $out ) wp_send_json_error( 'Failed to open temp file.' );
        $in = fopen( $chunk, 'r' );
        if ( ! $in ) { fclose( $out ); wp_send_json_error( 'Failed to read chunk.' ); }
        while ( $buff = fread( $in, 4096 ) ) fwrite( $out, $buff );
        fclose( $in ); fclose( $out );

        if ( $chunk_index === $total_chunks - 1 ) {
            $imports_dir = Alfath_Migration_Helpers::get_storage_dir( 'imports' );
            $final_path = $imports_dir . '/' . $file_name;
            rename( $temp_file, $final_path );
            $reader = new Alfath_Migration_Package_Reader();
            $manifest = $reader->read_manifest( $final_path );
            if ( $manifest ) wp_send_json_success( array( 'package_path' => $final_path, 'manifest' => $manifest ) );
            else { unlink( $final_path ); wp_send_json_error( 'Invalid package or missing manifest.' ); }
        }
        wp_send_json_success( 'Chunk received' );
    }

    public function extract_package() {
        $this->verify_access();
        $package_path = sanitize_text_field( $_POST['package_path'] );
        if ( ! file_exists( $package_path ) || ! class_exists( 'ZipArchive' ) ) wp_send_json_error( 'File not found or ZipArchive missing' );

        $temp_dir = Alfath_Migration_Helpers::get_storage_dir( 'temp' );
        Alfath_Migration_Helpers::delete_directory( $temp_dir );
        wp_mkdir_p( $temp_dir );

        // GENERATE TOKEN for subsequent requests that might lose session due to DB overwrite
        $token = wp_generate_password( 32, false );
        file_put_contents( $temp_dir . '/migration_token.txt', $token );

        $zip = new ZipArchive();
        if ( $zip->open( $package_path ) === true ) {
            $zip->extractTo( $temp_dir );
            $zip->close();
            wp_send_json_success( array( 'message' => 'Package extracted to temp', 'migration_token' => $token ) );
        } else {
            wp_send_json_error( 'Extraction failed' );
        }
    }

    public function import_database_step() {
        $this->verify_access();
        $importer = new Alfath_Migration_Database_Importer();
        $result = $importer->import();
        if ( $result ) wp_send_json_success( 'Database imported' );
        else wp_send_json_error( 'Failed to import database' );
    }

    public function import_files_step() {
        $this->verify_access();
        $type = isset( $_POST['import_type'] ) ? sanitize_text_field( $_POST['import_type'] ) : '';
        if ( empty( $type ) ) wp_send_json_error( 'Type missing' );

        $importer = new Alfath_Migration_File_Importer();
        $result = $importer->import_files( $type );
        if ( $result ) wp_send_json_success( 'Files restored for ' . $type );
        else wp_send_json_error( 'Failed to restore files for ' . $type );
    }

    public function replace_urls_step() {
        $this->verify_access();
        $old_url = esc_url_raw( $_POST['old_url'] );
        $new_url = esc_url_raw( $_POST['new_url'] );
        
        $replacer = new Alfath_Migration_Url_Replacer();
        $replacer->replace( $old_url, $new_url );
        
        $temp_dir = Alfath_Migration_Helpers::get_storage_dir( 'temp' );
        $manifest_file = $temp_dir . '/manifest.json';
        if ( file_exists( $manifest_file ) ) {
            $manifest = json_decode( file_get_contents( $manifest_file ), true );
            if ( !empty( $manifest['active_theme'] ) ) switch_theme( $manifest['active_theme'] );
        }
        
        flush_rewrite_rules( true );
        if ( class_exists( '\Elementor\Plugin' ) ) {
            try { \Elementor\Plugin::$instance->files_manager->clear_cache(); } catch ( Exception $e ) {}
        }
        
        // Clean temp dir
        Alfath_Migration_Helpers::delete_directory( $temp_dir );

        wp_send_json_success( 'URLs replaced and cleanup done' );
    }
}
