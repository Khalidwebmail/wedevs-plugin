<?php
/**
 * Plugin Name:       Wd Author Bio
 * Plugin URI:        https://example.com/
 * Description:       Display author bio below each post
 * Version:           1.0.0
 * Author:            Khalid Ahmed.
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       we-author-bio
 * Domain Path:       /languages
 */

if( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ){
	require_once __DIR__ . '/vendor/autoload.php';
}

final class Wd_Author_Bio {
	/**
	 * Plugin version
	 *
	 * @var string version
	 */
	const version = '1.0.0';

	/**
	 * Class constructor
	 */
	private function __construct() {
		$this->wdab_define_constants();

		add_action( 'init', [ $this, 'wdab_init_plugin' ] );
	}

	/**
	 * Run plugin functionalities
	 *
	 * @return void
	 */
	public function wdab_init_plugin() {
		new \Author\Bio\Wd_Author();
	}

	/**
	 * Define all necessary constants
	 *
	 * @return void
	 */
	public function wdab_define_constants() {
		define( 'WDAB_VERSION', self::version );
		define( 'WDAB_PATH', __DIR__ );
		define( 'WDAB_FILE', __FILE__ );
		define( 'WDAB_URL', plugins_url( '', WDAB_FILE ) );
		define( 'WDAB_ASSETS', WDAB_URL . '/assets' );
	}

	/**
	 * Initialize singleton instance
	 *
	 * @return \Wd_Author_Bio
	 */
	public static function wdab_init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}
}

/**
 * Initialize the plugin
 *
 * @return \Wd_Author_Bio
 */
function wdab_we_author_box_boot() {
	return Wd_Author_Bio::wdab_init();
}

//Start the plugin
wdab_we_author_box_boot();