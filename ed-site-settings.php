<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*
Plugin Name:  ED - Site Settings
Plugin URI:   https://developer.wordpress.org/plugins/the-basics/
Description:  A simple plugin that creates settings that are commonly used in wordpress site installs.
Version:      08.21.2018
Author:       rossmerriam.com
Author URI:   https://rossmerriam.com/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined( 'ED_SITE_SETTINGS_FILE' ) ) {
	define( 'ED_SITE_SETTINGS_FILE', __FILE__ );
}

if ( ! defined( 'ED_SITE_SETTINGS_PATH' ) ) {
	define( 'ED_SITE_SETTINGS_PATH', plugin_dir_path( ED_SITE_SETTINGS_FILE ) );
}

if (! defined ( 'ED_SITE_SETTINGS_ASSETS_PATH' ) ) {
    define( 'ED_SITE_SETTINGS_ASSETS_PATH', ED_SITE_SETTINGS_PATH . 'includes/assets' );
}

// Load the ED Site Settings plugin.
if ( file_exists( ED_SITE_SETTINGS_PATH . 'includes/site-settings.php' ) ) {
	require_once ED_SITE_SETTINGS_PATH . 'includes/site-settings.php';
}


