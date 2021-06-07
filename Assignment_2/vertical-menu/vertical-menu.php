<?php
/*
Plugin Name:     Vertical menu
Plugin URI:      https://example.com/
description:     A simple vertical menu show in right side
Version:         1.0.0
Author:          Khalid Ahmed
Author URI:      https://example.com/
License:         GPL2 or later
Text domain:     vertical-menu
*/

use Vertical\Admin\Menu;

if( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) )
	require_once __DIR__ . '/vendor/autoload.php';

/**
 * Class Vertical_Menu
 */
final class Vertical_Menu {

	/**
	 * Plugin version
	 */
	const version = "1.0";

	/**
	 * Vertical_Menu constructor.
	 */
	private function __construct()
	{
		$this->vm_define_constants();

		register_activation_hook( __FILE__, [ $this, 'vm_activate' ] );
		add_action( 'init', [ $this, 'vm_init_plugin' ] );
	}

	/**
	 * initialize singleton instance
	 *
	 * @return \Vertical_Menu
	 */
	public static function vm_init()
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
	public function vm_define_constants()
	{
		define('MENU_VERSION', self::version);
		define("MENU_FILE", __FILE__);
		define("MENU_PATH", __DIR__);
		define("MENU_URL", plugins_url('', MENU_FILE));
		define("MENU_ASSETS", MENU_URL . '/assets');
	}

	/**
	 * initialize the plugin
	 *
	 * @return void
	 */

	public function vm_init_plugin()
	{
		if( is_admin() ) {
			new Menu();
		}
		else {
			new \Vertical\Frontend\ShowButton();
		}
	}

	/**
	 * Do stuff upon plugin activation
	 *
	 * @return void
	 */
	public function vm_activate()
	{
		$installed = get_option("vertical_menu_installed");
		if( ! $installed ) {
			update_option('vertical_menu_installed', time());
		}
		update_option('vertical_menu_installed', MENU_VERSION);
	}
}

/**
 * iniitalize the main plugin
 *
 * @return \Vertical_Menu
 */
function vertical_menu()
{
	return Vertical_Menu::vm_init();
}

/**
 * Kick of plugin
 */
vertical_menu();