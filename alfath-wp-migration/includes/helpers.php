<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Alfath_Migration_Helpers {
    public static function get_storage_dir( $type = '' ) {
        $upload_dir = wp_upload_dir();
        $base_dir = $upload_dir['basedir'] . '/alfath-wp-migration';
        
        if ( ! empty( $type ) ) {
            $base_dir .= '/' . $type;
        }
        
        return $base_dir;
    }

    public static function create_storage_directories() {
        $dirs = array(
            self::get_storage_dir(),
            self::get_storage_dir( 'exports' ),
            self::get_storage_dir( 'imports' ),
            self::get_storage_dir( 'temp' ),
            self::get_storage_dir( 'logs' ),
        );

        foreach ( $dirs as $dir ) {
            if ( ! file_exists( $dir ) ) {
                wp_mkdir_p( $dir );
            }
            
            $htaccess_file = $dir . '/.htaccess';
            if ( ! file_exists( $htaccess_file ) ) {
                file_put_contents( $htaccess_file, "Deny from all\nOptions -Indexes" );
            }
            
            $index_file = $dir . '/index.php';
            if ( ! file_exists( $index_file ) ) {
                file_put_contents( $index_file, "<?php\n// Silence is golden." );
            }
        }
    }
    
    public static function delete_directory( $dir ) {
        if ( ! file_exists( $dir ) ) {
            return true;
        }
        if ( ! is_dir( $dir ) ) {
            return unlink( $dir );
        }
        foreach ( scandir( $dir ) as $item ) {
            if ( $item == '.' || $item == '..' ) {
                continue;
            }
            if ( ! self::delete_directory( $dir . DIRECTORY_SEPARATOR . $item ) ) {
                return false;
            }
        }
        return rmdir( $dir );
    }
}
