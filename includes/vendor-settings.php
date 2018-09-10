<?php

class VendorSettings {
	private $options;


	public function __construct() {
		$this->options = get_option('ed_site_settings');
		add_action( 'admin_init', array( $this, 'page_init' ) );
	}

	public function print_vendor_section_info() {
		print 'Add your vendor information here.';
	}

	function page_init() {
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

	function text_field_callback( $link ) {
		$value = isset( $this->options[$link] ) ? esc_attr( $this->options[$link] ) : '';
		printf(
			'<input type="text" id="%1$s" name="ed_site_settings[%1$s]" value="%2$s" class="regular-text" />',
			$link,
			$value
		);
	}
}

