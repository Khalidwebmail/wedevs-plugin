<?php
/**
 * Plugin Name:       User Roles and Capabilities
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Use to save additional meta info of post.
 * Version:           1.0.0
 * Author:            Khalid Ahmed
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       user-roles-and-capabilities
 */

if( ! defined( 'ABSPATH') ) {
	exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Class User_Role_Capabilities
 */
final class User_Role_Capabilities {
	/**
	 * Plugin Version
	 *
	 * @return string
	 */
	const VERSION = '1.0.0';
	/**
	 * class contructor
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function __construct() {
		$this->define_constants();

		register_activation_hook( __FILE__,  [ $this, 'activate' ] );

		add_action( 'init', [ $this, 'init_plugin' ] );
	}

	/**
	 * initialize a singleton instance
	 *
	 * @since 1.0.0
	 *
	 * @return \User_Role_Capabilities
	 */
	public static function init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Define the Required Plugin Constants
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function define_constants() {
		define( 'URC_CAPABILITY_VERSION', self::VERSION );
		define( 'URC_CAPABILITY_FILE', __FILE__ );
		define( 'URC_CAPABILITY_PATH', __DIR__ );
		define( 'URC_CAPABILITY_URL', plugins_url( '', URC_CAPABILITY_FILE ) );
		define( 'URC_CAPABILITY_ASSETS',  URC_CAPABILITY_URL . '/assets' );
	}

	/**
	 * Initialize the plugin
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init_plugin() {
		new \User\Role\Frontend();
	}

	/**
	 * Do Staff Upon Plugin Activation
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function activate() {
		$installed = get_option( 'role_capability_time' );

		if ( ! $installed ) {
			update_option( 'role_capability_time', time() );
		}

		update_option( 'role_capability_version', ROLE_CAPABILITY_VERSION );

		add_role( 'customer_role', __( 'Customer Role', 'user-roles-and-capabilities' ) );
	}
}

/**
 * initialize the main plugin
 *
 * @since 1.0.0
 *
 * @return \User_Role_Capabilities
 */
function urc_user_role_capabilities() {
	return User_Role_Capabilities::init();
}

/**
 * Kick of The Plugin
 *
 * @since 1.0.0
 */
urc_user_role_capabilities();