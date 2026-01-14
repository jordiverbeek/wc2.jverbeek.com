<?php
/**
 * Plugin Name: Movie Search
 * Description: Zoek films via een externe API
 * Version: 1.0.0
 * Author: Jordi Verbeek
 */

if (!defined('ABSPATH')) exit;

// Constants
define('MS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('MS_PLUGIN_URL', plugin_dir_url(__FILE__));

// Includes
require_once MS_PLUGIN_DIR . 'includes/class-settings.php';
require_once MS_PLUGIN_DIR . 'includes/class-shortcode.php';
require_once MS_PLUGIN_DIR . 'admin/class-admin.php';

// Init
new MS_Admin();
new MS_Shortcode();
