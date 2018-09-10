<?php


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
		register_setting( 'ed_site_settings_option_group', 'ed_site_settings');
    }
}

// Load the Site Contact Settings
if ( file_exists( ED_SITE_SETTINGS_PATH . 'includes/contact-settings.php' ) )
	require_once ED_SITE_SETTINGS_PATH . 'includes/contact-settings.php';

// Load the Vendor Settings
if ( file_exists( ED_SITE_SETTINGS_PATH . 'includes/vendor-settings.php' ) )
	require_once ED_SITE_SETTINGS_PATH . 'includes/vendor-settings.php';



if( is_admin() )
	$custom_site_settings_page = new CustomSiteSettingsPage();
    $contact_settings = new ContactSettings();
    $vendor_settings = new VendorSettings();


