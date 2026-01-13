<?php

/** 
 * Movie Search Plugin
 * 
 * @package MovieSearch
 * @wordpress-plugin 
 * 
 * Plugin Name: Movie Search
 * Description: A plugin to search for movies in your WordPress site.
 * 
 * Version: 1.0.0
 * Author: Jordi Verbeek
 * Author URI: https://jverbeek.com
 * Text-domain: ms-lang
 * 
 * 
 *  */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

define('MS_PLUGIN_FILE', __FILE__);
define('MS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define('MS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

define('MS_LANG_DOMAIN', 'ms-lang');

require_once MS_PLUGIN_DIR . 'core/core.php';



$MS_Core = new MS_Core();