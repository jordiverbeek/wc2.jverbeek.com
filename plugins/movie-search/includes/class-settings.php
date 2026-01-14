<?php

if (!defined('ABSPATH')) exit;

class MS_Settings {

    public function get_api_url() {
        return get_option('ms_api_url', 'https://www.omdbapi.com/');
    }

    public function get_api_key() {
        return get_option('ms_api_key', '943a7208');
    }

    public function get_type() {
        return get_option('ms_type', 'movie');
    }

    public function save($post) {
        update_option('ms_api_url', sanitize_text_field($post['ms_api_url']));
        update_option('ms_api_key', sanitize_text_field($post['ms_api_key']));
        update_option('ms_type', sanitize_text_field($post['ms_type']));
    }
}
