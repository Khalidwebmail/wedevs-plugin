<?php
/**
 * Plugin Name:       Cat Facts
 * Plugin URI:        https://example.com/
 * Description:       Display related post with widget
 * Version:           1.0.0
 * Author:            Khalid Ahmed.
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       cat-facts
 * Domain Path:       /languages/
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Class Cat_Facts
 */
final class Cat_Facts {
	/**
	 * Plugin version
	 *
	 * @var string version
	 */
	const version = '1.0.0';

	/**
	 * Class constructor
	 *
	 * @return void
	 */
	public function __construct() {
		$this->define_constants();

		register_activation_hook( __FILE__, [ $this, 'activate' ] );

		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
	}

	/**
	 * Run all necessary functionalities
	 *
	 * @return void
	 */
	public function init_plugin() {

	}

	/**
	 * Define all necessay constants
	 *
	 * @return void
	 */
	public function define_constants() {
		define( 'CF_VERSION', self::version );
		define( 'CF_PATH', __DIR__ );
		define( 'CF_FILE', __FILE__ );
		define( 'CF_URL', plugins_url( '', CF_FILE ) );
		define( 'CF_ASSETS', CF_URL . '/assets' );
	}

	/**
	 * Add plugin version and time
	 *
	 * @return void
	 */
	public function activate() {
		$installed = get_option( 'cf_installed' );

		if ( ! $installed ) {
			update_option( 'cf_installed', time() );
		}

		update_option( 'cf_version', cf_VERSION );
	}

	/**
	 * Initialize singleton instance
	 *
	 * @return \Cat_Facts
	 */
	public static function init() {
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
 * @return \Cat_Facts
 */
function cat_facts_start() {
	return Cat_Facts::init();
}

// Start the plugin
cat_facts_start();