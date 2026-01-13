<?php

Class MS_Admin {

    private $page;
    private $settings;
    
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
    }



    public function add_admin_menu() {
        add_menu_page(
            'Movie Search',
            'Movie Search',
            'manage_options',
            'movie-search',
            array( $this, 'render_settings_page' ),
            'dashicons-admin-generic',
            81
        );
    }



    public function render_settings_page() {
        $this->page = $this->get_page();
        $this->settings = MS_Settings::getInstance();

        // Handle POSTs
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $this->handle_post();
        }

        include MS_PLUGIN_DIR . 'admin/views/root.php';
    }


    public function enqueue_admin_assets( $hook ) {
        if (!str_contains(get_current_screen()->base, 'movie-search')) {
            return;
        }
        wp_enqueue_style('ms-admin', MS_PLUGIN_URL . 'admin/assets/css/styles.css', false, '1.0.0');
        wp_enqueue_script('ms-admin', MS_PLUGIN_URL . 'admin/assets/js/movie-search.js', array(), '1.0.0', true);
    }



    public function handle_post() {
        if (!isset( $_POST['nonce'] ) || !wp_verify_nonce($_POST['nonce'], 'ms_nonce')) {
            wp_die( 'Invalid nonce' );
        }

        $action = $_POST['action'] ?? '';
        $group = $_POST['group'] ?? '';

        if ($group === 'settings') {
            $this->settings->handle_post($_POST);
        } else {

        }

        $redirect = $_POST['redirect'] ?? admin_url('admin.php?page=movie-search');
        wp_safe_redirect($redirect);
        exit;
    }





    // Helper functions
    private function get_page() {
        $page = $_GET['pane'] ?? 'main';
        $is_valid = false;

        // Get all the files from the admin/vies/pages directory without the .php extension
        $pages = array_map( function( $file ) {
            if (in_array( $file, array( '.', '..' ))) return null;
            return str_replace( '.php', '', $file );
        }, scandir( MS_PLUGIN_DIR . 'admin/views/pages/' ) );

        // Filter out null values
        $pages = array_filter($pages);

        foreach ( $pages as $valid_page ) {
            if ( $page === $valid_page ) {
                $page = $this->get_page_path($valid_page);
                $is_valid = true;
                break;
            }
        }

        if (!$is_valid) $page = $this->get_page_path('invalid');

        return $page;
    }

    private function get_page_path($page) {
        return MS_PLUGIN_DIR . "admin/views/pages/{$page}.php";
    }
}