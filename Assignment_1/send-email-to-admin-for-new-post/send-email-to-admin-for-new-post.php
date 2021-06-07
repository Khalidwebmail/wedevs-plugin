<?php

/**
 * Send email to admin for new post
 *
 * @package           Send email to admin for new post
 * @author            Khalid Ahmed
 * @copyright         2021 Khalid Ahmed
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Send email to admin for new post
 * Plugin URI:        https://example.com/plugin-name
 * Description:       A plugin to simple post count display.
 * Version:           1.0.0
 * Author:            Khalid Ahmed
 * Author URI:        https://example.com
 * Text Domain:        send-email-to-admin-for-new-post
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( file_exists( require_once __DIR__ . '/vendor/autoload.php' ) )
	require_once __DIR__ . '/vendor/autoload.php';

/**
 * Class Send_Email_To_Admin
 * Structure of plugin
 */
final class Send_Email_To_Admin {
	const version = '1.0.0';

	/**
	 * Send_Email_To_Admin constructor.
	 */
	private function __construct() {

	}

	/**
	 * init
	 * initialize single instance
	 * @return \Send_Email_To_Admin
	 */
	public static function wd_se_init() {
		static $instance = false;

		if( ! $instance ) {
			$instance =new self();
		}
		return $instance;
	}

	/**
	 * define_constant
	 * @return void
	 */
	private function wd_se_define_constant() {
		define( 'WD_SE_RELEASE_NUMBER', self::version );
		define( 'WD_SE_FILE', __FILE__ );
		define( 'WD_SE_PATH', __DIR__ );
	}

	/**
	 * init_plugin
	 * initialize plugin
	 * @return void
	 */
	public function wd_se_init_plugin() {
		if( is_admin() ) {
			new \Send\Email\Admin\Send_Email();
		}
	}

	/**
	 * wd_se_activate
	 * Store install to database
	 * @return void
	 */
	public function wd_se_activate() {
		$install_date = get_option( 'wd_se_install_date', time() );

		if( ! $install_date ) {
			update_option( 'version', WD_SE_RELEASE_NUMBER );
		}
	}
}