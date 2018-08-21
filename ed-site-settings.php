<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*
Plugin Name:  Site Settings
Plugin URI:   https://developer.wordpress.org/plugins/the-basics/
Description:  A simple plugin that creates settings that are commonly used in wordpress site installs.
Version:      08.21.2018
Author:       rossmerriam.com
Author URI:   https://rossmerriam.com/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/


// Function that creates the site options page.
function ed_site_options_page_html()
{
// check user capabilities
if (!current_user_can('manage_options')) {
    return;
}
?>
<div class="wrap">
    <h1><?= esc_html(get_admin_page_title()); ?></h1>
    <form action="options.php" method="post">
        <?php
        // output security fields for the registered setting "wporg_options"
        settings_fields('edsite_options');
        // output setting sections and their fields
        // (sections are registered for "wporg", each field is registered to a specific section)
        do_settings_sections('edsiteoptions');
        // output save settings button
        submit_button('Save Settings');
        ?>
    </form>
</div>
    <?php
}

function ed_site_options_page()
{
    add_submenu_page(
            'options-general.php',
            'Site Settings',
            'Site Settings',
            'manage_options',
            'edsiteoptions',
            'ed_site_options_page_html'
    );
}
add_action('admin_menu', 'ed_site_options_page');