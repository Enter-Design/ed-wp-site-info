<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*
Plugin Name:  ED - Site Info
Plugin URI:   https://developer.wordpress.org/plugins/the-basics/
Description:  A simple plugin that commonly used site and vendor information for wordpress installations.
Version:      01.25.2022
Author:       Ross Merriam
Author URI:   https://rossmerriam.com/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined( 'ED_SITE_INFO_FILE' ) ) {
	define( 'ED_SITE_INFO_FILE', __FILE__ );
}

if ( ! defined( 'ED_SITE_INFO_PATH' ) ) {
	define( 'ED_SITE_INFO_PATH', plugin_dir_path( ED_SITE_INFO_FILE ) );
}

if (! defined ( 'ED_SITE_INFO_ASSETS_PATH' ) ) {
    define( 'ED_SITE_INFO_ASSETS_PATH', ED_SITE_INFO_PATH . 'includes/assets' );
}

// Load the ED Site Settings plugin.
if ( file_exists( ED_SITE_INFO_PATH . 'includes/site-info.php' ) ) {
	require_once ED_SITE_INFO_PATH . 'includes/site-info.php';
}


