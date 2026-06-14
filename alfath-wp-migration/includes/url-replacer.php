<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Alfath_Migration_Url_Replacer {
    public function replace( $old_url, $new_url ) {
        global $wpdb;
        
        $old_url = rtrim( $old_url, '/' );
        $new_url = rtrim( $new_url, '/' );

        if ( $old_url === $new_url ) {
            return;
        }

        $tables = $wpdb->get_col( "SHOW TABLES LIKE '{$wpdb->prefix}%'" );

        foreach ( $tables as $table ) {
            $columns = $wpdb->get_results( "SHOW COLUMNS FROM `{$table}`" );
            $primary_key = '';
            $text_columns = array();

            foreach ( $columns as $column ) {
                if ( $column->Key === 'PRI' ) {
                    $primary_key = $column->Field;
                }
                if ( strpos( $column->Type, 'text' ) !== false || strpos( $column->Type, 'varchar' ) !== false || strpos( $column->Type, 'longtext' ) !== false ) {
                    $text_columns[] = $column->Field;
                }
            }

            if ( empty( $primary_key ) || empty( $text_columns ) ) {
                continue;
            }

            foreach ( $text_columns as $column ) {
                $rows = $wpdb->get_results( "SELECT `{$primary_key}`, `{$column}` FROM `{$table}` WHERE `{$column}` LIKE '%" . $wpdb->esc_like( $old_url ) . "%'" );

                foreach ( $rows as $row ) {
                    $old_value = $row->$column;
                    $new_value = $this->recursive_replace( $old_url, $new_url, $old_value );

                    if ( $old_value !== $new_value ) {
                        $wpdb->update(
                            $table,
                            array( $column => $new_value ),
                            array( $primary_key => $row->$primary_key )
                        );
                    }
                }
            }
        }
    }

    private function recursive_replace( $search, $replace, $data ) {
        if ( is_string( $data ) ) {
            $unserialized = @unserialize( $data );
            if ( $unserialized !== false || $data === 'b:0;' ) {
                $replaced = $this->recursive_replace( $search, $replace, $unserialized );
                return serialize( $replaced );
            }
            // For simple strings
            return str_replace( $search, $replace, $data );
        } elseif ( is_array( $data ) ) {
            $new_array = array();
            foreach ( $data as $key => $value ) {
                $new_array[ $key ] = $this->recursive_replace( $search, $replace, $value );
            }
            return $new_array;
        } elseif ( is_object( $data ) ) {
            $new_object = new stdClass();
            foreach ( $data as $key => $value ) {
                $new_object->$key = $this->recursive_replace( $search, $replace, $value );
            }
            return $new_object;
        }
        return $data;
    }
}
