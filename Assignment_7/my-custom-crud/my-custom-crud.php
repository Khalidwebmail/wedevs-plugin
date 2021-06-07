<?php

/*
 * Plugin Name:       WeDevs CRUD
 * Plugin URI:        https://khalid.co
 * Description:       A tutorial plugin for weDevs CRUD.
 * Version:           1.0
 * Author:            Khalid Ahmed
 * Author URI:        https://khalid.co
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wedevs-crud
 * Domain Path:       /languages
*/

use My\Crud\Installer;

if( ! defined("ABSPATH")){
	exit;
}

require_once __DIR__ . '/vendor/autoload.php';
/**
 * Plugin Class name
 */

final class Custom_Crud {

	/**
	 * Plugin version
	 */
	const version = "1.0";

	private function __construct()
	{
		$this->define_constants();

		register_activation_hook( __FILE__, [ $this, 'activate' ] );
		add_action('plugins_loaded', [ $this, 'init_plugin' ] );
	}

	/**
	 * initialize singleton instance
	 *
	 * @return \Custom_Crud
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
		define('WD_CRUD_VERSION', self::version);
		define("WD_CRUD_FILE", __FILE__);
		define("WD_CRUD_PATH", __DIR__);
		define("WD_CRUD_URL", plugins_url('', WD_CRUD_FILE));
		define("WD_CRUD_ASSETS", WD_CRUD_URL . '/assets');
	}

	/**
	 * initialize the plugin
	 *
	 * @return void
	 */

	public function init_plugin()
	{
		if( is_admin() ) {
			new \My\Crud\Admin();
		}
	}

	/**
	 * Do stuff upon plugin activation
	 *
	 * @return void
	 */
	public function activate()
	{
		$installer = new Installer();
		$installer->run();
	}
}

/**
 * iniitalize the main plugin
 *
 * @return \Custom_Crud
 */
function my_custom_crud()
{
	return Custom_Crud::init();
}

/**
 * Kick of plugin
 */
my_custom_crud();