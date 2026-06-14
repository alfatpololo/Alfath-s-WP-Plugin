<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Alfath_Migration_Package_Reader {
    public function read_manifest( $package_path ) {
        if ( ! class_exists( 'ZipArchive' ) ) return false;

        $zip = new ZipArchive();
        if ( $zip->open( $package_path ) === true ) {
            $manifest_json = $zip->getFromName( 'manifest.json' );
            $zip->close();

            if ( $manifest_json ) {
                return json_decode( $manifest_json, true );
            }
        }
        return false;
    }
}
