<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Alfath_Migration_Database_Importer {
    public function import() {
        global $wpdb;
        $temp_dir = Alfath_Migration_Helpers::get_storage_dir( 'temp' );
        $sql_file = $temp_dir . '/database.sql';
        
        if ( ! file_exists( $sql_file ) ) {
            return false;
        }

        $query = '';
        $lines = file( $sql_file );
        
        foreach ( $lines as $line ) {
            $line = trim( $line );
            if ( empty( $line ) || strpos( $line, '--' ) === 0 || strpos( $line, '/*' ) === 0 ) {
                continue;
            }

            $query .= $line;
            if ( substr( $line, -1 ) === ';' ) {
                $wpdb->query( $query );
                $query = '';
            }
        }

        // Extremely critical: ensure the plugin remains active after DB replacement!
        $migration_plugin = plugin_basename( dirname(dirname(__FILE__)) . '/alfath-wp-migration.php' );
        $row = $wpdb->get_row( "SELECT option_value FROM {$wpdb->prefix}options WHERE option_name = 'active_plugins'" );
        if ( $row ) {
            $plugins = @unserialize( $row->option_value );
            if ( is_array( $plugins ) && ! in_array( $migration_plugin, $plugins ) ) {
                $plugins[] = $migration_plugin;
                $wpdb->update( 
                    "{$wpdb->prefix}options", 
                    array( 'option_value' => serialize( $plugins ) ), 
                    array( 'option_name' => 'active_plugins' ) 
                );
            }
        }

        return true;
    }
}
