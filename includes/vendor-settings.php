<?php

class VendorSettings {
	private $options;

	public function __construct() {
		$this->options = get_option('ed_site_info');
		add_action( 'admin_init', array( $this, 'page_init' ) );
		add_action('wp_head', array( $this, 'insert_google_analytics_code'), 1 );
		add_action('wp_head', array( $this, 'insert_google_tag_manager_head_code'), 1 );
		add_action('wp_head', array( $this, 'insert_google_fonts_code'), 10 );
		add_action('wp_body_open', array( $this, 'insert_google_tag_manager_body_code'), 1);
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

		add_settings_field(
			'google-tag-manager',
			'Google Tag Manager',
			array( $this, 'text_field_callback' ),
			'ed-site-settings-admin',
			'vendor_settings_section',
			'google_tag_manager'
		);

		add_settings_field(
			'google-fonts',
			'Google Fonts',
			array( $this, 'text_field_callback' ),
			'ed-site-settings-admin',
			'vendor_settings_section',
			'google_fonts'
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

	function insert_google_analytics_code() {
		$ua_code = $this->options['google_analytics_ua'];
		if ( $ua_code ): ?>
			<!-- Global site tag (gtag.js) - Google Analytics -->
			<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $ua_code ?>"></script>
			<script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());

                gtag('config', '<?php echo $ua_code ?>');
			</script>
		<?php endif;
	}

	function insert_google_tag_manager_head_code() {
		$tag_code = $this->options['google_tag_manager'];
		if ( $tag_code ): ?>
			<!-- Google Tag Manager -->
			<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','<?php echo $tag_code; ?>');</script>
			<!-- End Google Tag Manager -->
		<?php endif;
	}

	function insert_google_tag_manager_body_code() {
		$tag_code = $this->options['google_tag_manager'];
		if ( $tag_code ): ?>
			<!-- Google Tag Manager (noscript) -->
			<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $tag_code; ?>"
			                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
			<!-- End Google Tag Manager (noscript) -->
		<?php endif;
	}


	function insert_google_fonts_code() {
		$font_code = $this->options['google_fonts'];
		if ( $font_code ): ?>
			<!-- Google Fonts -->
			<link href="https://fonts.googleapis.com/css2?family=<?php echo $font_code; ?>display=swap" rel="stylesheet">
			<!-- End Google Fonts-->
		<?php endif;
	}
}


