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

class CustomSiteSettingsPage {
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page() {
        // This page will be under "Settings"
        add_options_page(
            'Site Settings',
            'Site Settings',
            'manage_options',
            'ed-site-settings-admin',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page() {
        // Set class property
	    $this->options = get_option( 'ed_site_settings' );
        ?>
        <div class="wrap">
            <h1>Site Settings</h1>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields( 'ed_site_settings_option_group' );
                do_settings_sections( 'ed-site-settings-admin' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init() {

        register_setting(
            'ed_site_settings_option_group',
            'ed_site_settings',
            array( $this, 'text_field_validation' )
        );

        add_settings_section(
            'contact_settings_section',
            'Contact Info', // Title
            array( $this, 'print_contact_section_info' ), // Callback
            'ed-site-settings-admin' // Page
        );

        add_settings_field(
            'phone',
            'Phone',
            array( $this, 'text_field_callback' ),
            'ed-site-settings-admin',
            'contact_settings_section',
            'phone'
        );

        add_settings_field(
            'email',
            'Email',
            array( $this, 'text_field_callback' ),
            'ed-site-settings-admin',
            'contact_settings_section',
            'email'
        );

        add_settings_field(
            'fax',
            'Fax',
            array( $this, 'text_field_callback' ),
            'ed-site-settings-admin',
            'contact_settings_section',
            'fax'
        );

        add_settings_field(
            'business-address',
            'Address',
            array( $this, 'textarea_field_callback' ),
            'ed-site-settings-admin',
            'contact_settings_section',
            'address'
        );

        add_settings_section(
            'vendor_settings_section', // ID
            'Vendor Settings', // Title
            array( $this, 'print_vendor_section_info' ), // Callback
            'ed-site-settings-admin' // Page
        );

        add_settings_field(
            'google-analytics-ua',
            'Google Analytics UA',
            array( $this, 'text_field_callback' ),
            'ed-site-settings-admin',
            'vendor_settings_section',
            'google_analytics_ua'
        );
    }


    /**
     *
     * Sanitize each setting text field as needed
     * @input input field for validation
     *
     */
    public function text_field_validation( $input ) {
        if ( is_array( $input ) )
            // @TODO some sort of validation should be done here.
            // return array_map( "sanitize_text_field", $input );
            return $input;
    }

    /**
     * Print the Section text
     */

    public function print_contact_section_info() {
        print 'Add your contact information here.';
    }

    public function print_vendor_section_info() {
        print 'Custom Vendor and API keys go here.';
    }


    public function text_field_callback( $link ) {
        $value = isset( $this->options[$link] ) ? esc_attr( $this->options[$link] ) : '';
        printf(
            '<input type="text" id="%1$s" name="ed_site_settings[%1$s]" value="%2$s" class="regular-text" />',
            $link,
            $value
        );
    }

    public function textarea_field_callback( $link ) {
        $value = isset( $this->options[$link] ) ? esc_attr( $this->options[$link] ) : '';
        echo "<textarea id='plugin_textarea_string' name='ed_site_settings[{$link}]' rows='7' cols='50' type='textarea'>{$value}</textarea>";
    }

}

if( is_admin() )
    $custom_site_settings_page = new CustomSiteSettingsPage();
