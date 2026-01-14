<?php

if (!defined('ABSPATH')) exit;

class MS_Admin {

    private $settings;

    public function __construct() {
        $this->settings = new MS_Settings();

        add_action('admin_menu', [$this, 'add_menu']);
        add_action('admin_post_ms_save_settings', [$this, 'handle_post']);
    }

    public function add_menu() {
        add_menu_page(
            'Movie Search',
            'Movie Search',
            'manage_options',
            'movie-search',
            [$this, 'render_page'],
            'dashicons-video-alt2'
        );
    }

    public function render_page() {
        $settings = $this->settings;
        include MS_PLUGIN_DIR . 'admin/views/settings-page.php';
    }

    public function handle_post() {
        if (!current_user_can('manage_options')) {
            wp_die('Geen rechten');
        }

        check_admin_referer('ms_save_settings');

        $this->settings->save($_POST);

        wp_redirect(admin_url('admin.php?page=movie-search&updated=true'));
        exit;
    }
}
