<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Alfath_Migration_Admin_Page {
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
    }

    public function add_menu_page() {
        add_menu_page(
            'Alfath Migration',
            'Alfath Migration',
            'manage_options',
            'alfath-wp-migration',
            array( $this, 'render_page' ),
            'dashicons-migrate',
            80
        );
    }

    public function enqueue_scripts( $hook ) {
        if ( $hook !== 'toplevel_page_alfath-wp-migration' ) {
            return;
        }

        wp_enqueue_style( 'alfath-migration-admin-css', ALFATH_MIGRATION_URL . 'assets/css/admin.css', array(), ALFATH_MIGRATION_VERSION );
        wp_enqueue_script( 'alfath-migration-admin-js', ALFATH_MIGRATION_URL . 'assets/js/admin.js', array(), ALFATH_MIGRATION_VERSION, true );
        
        wp_localize_script( 'alfath-migration-admin-js', 'alfathMigrationObj', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce( 'alfath_migration_nonce' ),
        ) );
    }

    public function render_page() {
        ?>
        <div class="wrap alfath-migration-wrap">
            <h1>Alfath WP Migration</h1>
            
            <h2 class="nav-tab-wrapper">
                <a href="#export" class="nav-tab nav-tab-active">Export</a>
                <a href="#import" class="nav-tab">Import</a>
                <a href="#backups" class="nav-tab">Backups</a>
            </h2>

            <div class="alfath-migration-notice notice notice-warning">
                <p><strong>Limitation Notice:</strong> This plugin supports large migrations using step-by-step processing, but it is still limited by hosting storage, PHP execution limits, file permissions, and database permissions. It is not truly unlimited.</p>
            </div>

            <div id="tab-export" class="alfath-tab-content active">
                <div class="alfath-card">
                    <h3>Export Site</h3>
                    <p>Export your database and site files into a single .alfathpack file.</p>
                    
                    <label><input type="checkbox" id="export_db" checked> Database</label><br>
                    <label><input type="checkbox" id="export_uploads" checked> Media Uploads</label><br>
                    <label><input type="checkbox" id="export_themes" checked> Themes</label><br>
                    <label><input type="checkbox" id="export_plugins" checked> Plugins</label><br>
                    <label><input type="checkbox" id="export_mu_plugins" checked> Must-use Plugins</label><br>
                    <label><input type="checkbox" id="export_manifest" checked disabled> Manifest</label><br>

                    <h4 class="mt-10">Advanced Exclude Options:</h4>
                    <label><input type="checkbox" id="exclude_cache" checked> Exclude cache folders</label><br>
                    <label><input type="checkbox" id="exclude_backup" checked> Exclude backup folders</label><br>
                    <label><input type="checkbox" id="exclude_node_modules" checked> Exclude node_modules</label><br>
                    <label><input type="checkbox" id="exclude_git" checked> Exclude .git folders</label><br>
                    <label><input type="checkbox" id="exclude_storage" checked disabled> Exclude migration plugin storage folder</label><br>
                    
                    <button id="btn-start-export" class="button button-primary button-large mt-10">Create Export Package</button>
                    
                    <div id="export-progress-wrapper" class="alfath-progress-wrapper hidden mt-10">
                        <div class="alfath-progress-bar"><div class="alfath-progress" id="export-progress"></div></div>
                        <p id="export-status">Starting export...</p>
                    </div>
                    <div id="export-download-wrapper" class="hidden mt-10">
                    </div>
                </div>
            </div>

            <div id="tab-import" class="alfath-tab-content">
                <div class="alfath-card">
                    <h3>Import Site</h3>
                    <p>Upload your .alfathpack file to restore the site.</p>
                    <input type="file" id="import_file" accept=".alfathpack"><br>
                    <button id="btn-upload-import" class="button button-primary mt-10">Upload and Validate</button>
                    
                    <div id="import-details-wrapper" class="hidden mt-10">
                        <h4>Package Details</h4>
                        <p>Source URL: <span id="source_url_display"></span></p>
                        <p>Current URL: <span id="current_url_display"><?php echo esc_url( home_url() ); ?></span></p>
                        
                        <p class="description">Verify URLs before replacing.</p>
                        <input type="hidden" id="old_url">
                        <input type="hidden" id="new_url" value="<?php echo esc_url( home_url() ); ?>">
                        
                        <div class="notice notice-error inline"><p>Warning: Import will overwrite current site data.</p></div>
                        <br>
                        <button id="btn-start-import" class="button button-primary button-large mt-10">Confirm & Import</button>
                    </div>

                    <div id="import-progress-wrapper" class="alfath-progress-wrapper hidden mt-10">
                        <div class="alfath-progress-bar"><div class="alfath-progress" id="import-progress"></div></div>
                        <p id="import-status">Starting import...</p>
                    </div>
                </div>
            </div>

            <div id="tab-backups" class="alfath-tab-content">
                <div class="alfath-card">
                    <h3>Available Backups</h3>
                    <p>List of all generated export packages in the secure storage folder.</p>
                    <table class="wp-list-table widefat fixed striped mt-10">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>Date Modified</th>
                                <th>Size</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $exports_dir = Alfath_Migration_Helpers::get_storage_dir( 'exports' );
                            if ( is_dir( $exports_dir ) ) {
                                $files = glob( $exports_dir . '/*.alfathpack' );
                                if ( ! empty( $files ) ) {
                                    usort( $files, function( $a, $b ) {
                                        return filemtime( $b ) - filemtime( $a );
                                    });
                                    foreach ( $files as $file ) {
                                        $file_name = basename( $file );
                                        $size = size_format( filesize( $file ) );
                                        $date = date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), filemtime( $file ) );
                                        $download_url = wp_nonce_url( admin_url( 'admin-post.php?action=alfath_wp_migration_download&file=' . rawurlencode( $file_name ) ), 'alfath_wp_migration_download_' . $file_name );
                                        ?>
                                        <tr>
                                            <td><strong><?php echo esc_html( $file_name ); ?></strong></td>
                                            <td><?php echo esc_html( $date ); ?></td>
                                            <td><?php echo esc_html( $size ); ?></td>
                                            <td>
                                                <a href="<?php echo esc_url( $download_url ); ?>" class="button button-small button-primary">Download</a>
                                                <button class="button button-small btn-delete-backup" data-file="<?php echo esc_attr( $file_name ); ?>">Delete</button>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="4">No backups found.</td></tr>';
                                }
                            } else {
                                echo '<tr><td colspan="4">No backups found.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
    }
}
