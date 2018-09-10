<?php

class ContactSettings {
	private $options;

	public function __construct() {
		$this->options = get_option('ed_site_settings');
		add_action( 'admin_init', array( $this, 'page_init' ) );
	}

	public function print_contact_section_info() {
		print 'Add your contact information here.';
	}

	public function page_init() {

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
	}

	function text_field_callback( $link ) {
		$value = isset( $this->options[$link] ) ? esc_attr( $this->options[$link] ) : '';
		printf(
			'<input type="text" id="%1$s" name="ed_site_settings[%1$s]" value="%2$s" class="regular-text" />',
			$link,
			$value
		);
	}

	function textarea_field_callback( $link ) {
		$value = isset( $this->options[$link] ) ? esc_attr( $this->options[$link] ) : '';
		echo "<textarea id='plugin_textarea_string' name='ed_site_settings[{$link}]' rows='7' cols='50' type='textarea'>{$value}</textarea>";
	}

	function text_field_validation() {
		return;
	}
}

