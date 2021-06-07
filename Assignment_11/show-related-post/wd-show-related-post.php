<?php
/**
 * Plugin Name:       Show Related Post
 * Plugin URI:        https://example.com/
 * Description:       Display related post with widget
 * Version:           1.0.0
 * Author:            Khalid Ahmed.
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       show-related-post
 * Domain Path:       /languages/
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Class Show_Related_Post
 */
final class Show_Related_Post {
	/**
	 * Plugin version
	 *
	 * @var string version
	 */
	const version = '1.0.0';

	/**
	 * Class constructon
	 *
	 * @return void
	 */
	private function __construct() {
		$this->define_constants();

		register_activation_hook( __FILE__, [ $this, 'activate' ] );

		add_action( 'init', [ $this, 'init_plugin' ] );
		add_action( 'widgets_init', [ $this, 'srp_related_post_widget' ] );
	}

	/**
	 * Register widget
	 *
	 * @return void
	 */
	public function srp_related_post_widget() {
		register_widget( '\Related\Post\Related_Post_Widget' );
	}

	/**
	 * Run plugin functionalities
	 *
	 * @return void
	 */
	public function init_plugin() {
		new \Related\Post\Related_Post_Widget();
	}

	/**
	 * Define all necessary constants
	 *
	 * @return void
	 */
	public function define_constants() {
		define( 'SRP_VERSION', self::version );
		define( 'SRP_PATH', __DIR__ );
		define( 'SRP_FILE', __FILE__ );
		define( 'SRP_URL', plugins_url( '', SRP_FILE ) );
		define( 'SRP_ASSETS', SRP_URL . '/assets' );
	}

	/**
	 * Add plugin version and time to db
	 *
	 * @return void
	 */
	public function activate() {
		$installed = get_option( 'srp_installed' );

		if ( ! $installed ) {
			update_option( 'srp_installed', time() );
		}

		update_option( 'srp_version', SRP_VERSION );
	}

	/**
	 * Initialize a singleton instance
	 *
	 * @return \Show_Related_Post
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
 * @return \Show_Related_Post
 */
function srp_widget() {
	return Show_Related_Post::init();
}

//Start the plugin
srp_widget();