<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Alfath_Migration_Database_Exporter {
    public function export() {
        global $wpdb;
        $temp_dir = Alfath_Migration_Helpers::get_storage_dir( 'temp' );
        $sql_file = $temp_dir . '/database.sql';
        
        $handle = fopen( $sql_file, 'w' );
        if ( ! $handle ) return false;

        $tables = $wpdb->get_col( "SHOW TABLES LIKE '{$wpdb->prefix}%'" );
        
        fwrite( $handle, "SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';\n" );
        fwrite( $handle, "SET time_zone = '+00:00';\n\n" );

        foreach ( $tables as $table ) {
            // Table structure
            $create_table = $wpdb->get_row( "SHOW CREATE TABLE {$table}", ARRAY_N );
            fwrite( $handle, "DROP TABLE IF EXISTS `{$table}`;\n" );
            fwrite( $handle, $create_table[1] . ";\n\n" );

            // Table data
            $rows = $wpdb->get_results( "SELECT * FROM {$table}", ARRAY_N );
            if ( $rows ) {
                foreach ( $rows as $row ) {
                    $values = array_map( function($val) use ($wpdb) {
                        if ( is_null( $val ) ) return 'NULL';
                        return "'" . esc_sql( $val ) . "'";
                    }, $row );
                    $values_str = implode( ',', $values );
                    fwrite( $handle, "INSERT INTO `{$table}` VALUES({$values_str});\n" );
                }
                fwrite( $handle, "\n" );
            }
        }

        fclose( $handle );
        return true;
    }
}
