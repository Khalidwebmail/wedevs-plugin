<?php

/**
 * Plugin Name:       Contact Us
 * Plugin URI:        https://example.com/
 * Description:       Store user address to database
 * Version:           1.0.0
 * Author:            Khalid Ahmed
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * Text Domain:       contact-us
 */

if( ! defined( 'ABSPATH' )) {
	exit;
}

require_once __DIR__ . '/vendor/autoload.php';

final class Contact_Us {
	/**
	 * Plugin version
	 */
	const version = "1.0";

	private function __construct()
	{
		$this->define_constants();

		register_activation_hook( __FILE__, [ $this, 'activate' ] );
		add_action( 'init', [ $this, 'init_plugin' ] );
	}

	/**
	 * initialize singleton instance
	 *
	 * @return \Contact_Us
	 */
	public static function init()
	{
		static $instance  = false;

		if(! $instance) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * define required plugins constants
	 *
	 * @return void
	 */
	public function define_constants()
	{
		define( 'WD_CONTACT_US_VERSION', self::version);
		define( 'WD_CONTACT_US_FILE', __FILE__);
		define( 'WD_CONTACT_US_PATH', __DIR__);
		define( 'WD_CONTACT_US_URL', plugins_url('', WD_CONTACT_US_FILE));
	}

	/**
	 * initialize the plugin
	 *
	 * @return void
	 */

	public function init_plugin()
	{
		new Contact\Us\Shortcode();
	}

	/**
	 * Do stuff upon plugin activation
	 *
	 * @return void
	 */
	public function activate()
	{
		$installed = get_option( 'wd_contact_us_installed' );
		if( ! $installed ) {
			update_option( 'wd_contact_us_installed', time() );
		}
		update_option( 'wd_contact_us_installed', WD_CONTACT_US_VERSION );
	}
}

/**
 * iniitalize the main plugin
 *
 * @return \Contact_Us
 */
function my_contact_us_form()
{
	return Contact_Us::init();
}

/**
 * Kick of plugin
 */
my_contact_us_form();