<?php

/**
 * Plugin Name:       My Book Review
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.0.0
 * Author:            Khalid Ahmed
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-book-review
 */

if( ! defined( 'ABSPATH' ) ) {
	exit;
}

# Include autoload file
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Plugin Class name
 */
final class My_Book_Review {
	/**
	 * Plugin version
	 */
	const version = "1.0";

	/**
	 * Define constructor
	 */
	private function __construct()
	{
		$this->define_constants();

		register_activation_hook( __FILE__, [ $this, 'activate' ] );
		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
	}

	/**
	 * initialize singleton instance
	 *
	 * @return \Book_Review
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
		define( 'WD_BR_VERSION', self::version );
		define( 'WD_BR_FILE', __FILE__ );
		define( 'WD_BR_PATH', __DIR__ );
		define( 'WD_BR_URL', plugins_url('', WD_BR_FILE ) );
		define( 'WD_BR_ASSETS', WD_BR_URL . '/assets' );
	}

	/**
	 * initialize the plugin
	 *
	 * @return void
	 */

	public function init_plugin()
	{
		new \Book\Review\Admin\Book_Information();
		new \Book\Review\Admin\Metabox();
	}

	/**
	 * Do stuff upon plugin activation
	 *
	 * @return void
	 */
	public function activate()
	{
		$installed = get_option("wd_br_installed");
		if( ! $installed ) {
			update_option('wd_br_installed', time());
		}
		update_option('wd_br_installed', WD_BR_VERSION);
	}
}

/**
 * iniitalize the main plugin
 *
 * @return \My_Book_Review
 */
function start_my_book_review()
{
	return My_Book_Review::init();
}

/**
 * Kick of plugin
 */
start_my_book_review();