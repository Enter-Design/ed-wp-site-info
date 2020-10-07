<?php

class ContactSettings {
	private $options;

	public function __construct() {
		$this->options = get_option('ed_site_info');
		add_action( 'admin_init', array( $this, 'page_init' ) );
		add_shortcode( 'contact_settings', array( $this, 'contact_shortcode') );
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
			'<input type="text" id="%1$s" name="ed_site_info[%1$s]" value="%2$s" class="regular-text" />',
			$link,
			$value
		);
	}

	function textarea_field_callback( $link ) {
		$value = isset( $this->options[$link] ) ? esc_attr( $this->options[$link] ) : '';
		echo "<textarea id='plugin_textarea_string' name='ed_site_info[{$link}]' rows='7' cols='50' type='textarea'>{$value}</textarea>";
	}

	function text_field_validation() {
		return;
	}

	function contact_shortcode( $atts ) {
	    $settings = get_option('ed_site_info');
	    $svg_path =  ED_SITE_INFO_ASSETS_PATH . '/svgs/';
	    $contact_item_html = '';

        foreach ( $atts as $att ) {
            $contact_item = $settings[$att];
            $contact_item_link = '#';
            if ( $att === 'phone' ) {
               $contact_item_link = 'tel:' . $settings[$att];
            } elseif ( $att === 'email' ) {
               $contact_item_link = 'mailto:' . $settings[$att];
            }
            $svg_file = file_get_contents($svg_path . $att . '.svg');

            $contact_item_html .= <<<EOD
        <div class="contact-item contact-item-$att">
            <a href="$contact_item_link">$svg_file $contact_item</a>
        </div>
EOD;
        }
	    return $contact_item_html;
    }
}

