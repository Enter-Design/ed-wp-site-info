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
            'Custom Theme Settings',
            'Custom Theme Settings',
            'manage_options',
            'custom-theme-settings-admin',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page() {
        // Set class property
        $this->social_options = get_option( 'custom_theme_social_media' );
        $this->contact_options = get_option( 'custom_theme_contact_info' );

        //print_r($this->options);
        ?>
        <div class="wrap">
            <h1>Custom Theme Settings</h1>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields( 'custom_theme_settings_option_group' );
                do_settings_sections( 'custom-theme-settings-admin' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'custom_theme_settings_option_group',
            'custom_theme_social_media', // Option Name
            array( $this, 'text_field_validation' )
        );


        // @TODO make these fields enabled if YOAST is not enabled.
//
//        add_settings_section(
//            'custom_theme_social_media_settings_section', // ID
//            'Social Media Links', // Title
//            array( $this, 'print_sm_section_info' ), // Callback
//            'custom-theme-settings-admin' // Page
//        );
//
//        $sm_links = array(
//            'facebook',
//            'twitter',
//            'google_plus',
//            'linkedin',
//        );
//
//        foreach ( $sm_links as $link ) {
//            add_settings_field(
//                $link,
//                str_replace( '_', ' ', $link ),
//                array( $this, 'sm_link_callback' ),
//                'custom-theme-settings-admin',
//                'custom_theme_social_media_settings_section',
//                $link
//            );
//        }

        register_setting(
            'custom_theme_settings_option_group',
            'custom_theme_contact_info', // Option Name
            array( $this, 'text_field_validation' )
        );

        add_settings_section(
            'custom_theme_contact_settings_section', // ID
            'Contact Info', // Title
            array( $this, 'print_contact_section_info' ), // Callback
            'custom-theme-settings-admin' // Page
        );

        add_settings_field(
            'primary-phone',
            'Primary Phone',
            array( $this, 'text_field_callback' ),
            'custom-theme-settings-admin',
            'custom_theme_contact_settings_section',
            'primary_phone'
        );

        add_settings_field(
            'primary-email',
            'Primary Email',
            array( $this, 'text_field_callback' ),
            'custom-theme-settings-admin',
            'custom_theme_contact_settings_section',
            'primary_email'
        );

        add_settings_field(
            'fax',
            'Fax Number',
            array( $this, 'text_field_callback' ),
            'custom-theme-settings-admin',
            'custom_theme_contact_settings_section',
            'fax_number'
        );

        add_settings_field(
            'business-address',
            'Business Address',
            array( $this, 'textarea_field_callback' ),
            'custom-theme-settings-admin',
            'custom_theme_contact_settings_section',
            'business_address'
        );

        add_settings_section(
            'custom_theme_vendor_settings_section', // ID
            'Vendor Settings', // Title
            array( $this, 'print_vendor_section_info' ), // Callback
            'custom-theme-settings-admin' // Page
        );

        add_settings_field(
            'google-analytics-ua',
            'Google Analytics UA',
            array( $this, 'text_field_callback' ),
            'custom-theme-settings-admin',
            'custom_theme_vendor_settings_section',
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
    public function print_sm_section_info() {
        print 'Enter URLs for all your social media accounts below:';
    }

    public function print_contact_section_info() {
        print 'Add your contact information here.';
    }

    public function print_vendor_section_info() {
        print 'Custom Vendor and API keys go here.';
    }


    public function text_field_callback( $link ) {
        $value = isset( $this->contact_options[$link] ) ? esc_attr( $this->contact_options[$link] ) : '';
        printf(
            '<input type="text" id="%1$s" name="custom_theme_contact_info[%1$s]" value="%2$s" class="regular-text" />',
            $link,
            $value
        );
    }

    public function textarea_field_callback( $link ) {
        $value = isset( $this->contact_options[$link] ) ? esc_attr( $this->contact_options[$link] ) : '';
        echo "<textarea id='plugin_textarea_string' name='custom_theme_contact_info[{$link}]' rows='7' cols='50' type='textarea'>{$value}</textarea>";
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function sm_link_callback( $link ) {
        $value = isset( $this->social_options[$link] ) ? esc_attr( $this->social_options[$link] ) : '';
        printf(
            '<input type="text" id="%1$s" name="custom_theme_social_media[%1$s]" value="%2$s" class="regular-text" />',
            $link,
            $value
        );
    }

}

if( is_admin() )
    $custom_site_settings_page = new CustomSiteSettingsPage();
