<?php

/**
 * Display Post View Count
 *
 * @package           Display Post View Count
 * @author            Khalid Ahmed
 * @copyright         2021 Khalid Ahmed
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Display Post View Count
 * Plugin URI:        https://example.com/plugin-name
 * Description:       A plugin to simple post count display.
 * Version:           1.0.0
 * Author:            Khalid Ahmed
 * Author URI:        https://example.com
 * Text Domain:       display-post-view-count
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';
}

/**
 * Display_Post_View_Count
 * Main skaleton of this plugin
 */

final class Display_Post_View_Count {
    const version = '1.0.0';

    /**
     * __construct
     * Define construct
     * @return void
     */
    private function __construct() {
		$this->wd_dpvc_define_constant();
	    register_activation_hook( __FILE__, [ $this, 'wd_dpvc_activate' ] );
	    add_action( 'init', [ $this, 'wd_dpvc_init_plugin' ] );
    }

	/**
	 * init
	 * initialize single instance
	 * @return \Display_Post_View_Count
	 */
	public static function wd_dpvc_init() {
		static $instance = false;
		if( ! $instance ) {
			$instance = new self();
		}
		return $instance;
	}

	/**
	 * Define constant
	 *
	 * @return void
	 */
	public function wd_dpvc_define_constant() {
		define( 'WD_DPVC_RELEASE_NUMBER', self::version );
		define( 'WD_DPVC_FILE', __FILE__ );
		define( 'WD_DPVC_PATH', __DIR__ );
	}

	/**
	 * init_plugin
	 * initialize plugin
	 * @return void
	 */
	public static function wd_dpvc_init_plugin() {
		new \Display\Viewers\Frontend\Counter();
	}

	/**
	 * activate
	 * Active plugin after install
	 * @return void
	 */
	public function wd_dpvc_activate() {
		$install_date = get_option( 'wd_dpvc_installed', time() );

		if( ! $install_date ) {
			update_option( 'wd_dpvc_version', WD_DPVC_RELEASE_NUMBER );
		}
	}
}

/**
 * wd_dpvc_show_post_viewer
 * initialize the main plugin
 * @return \Display_Post_View_Count
 */
function wd_dpvc_show_post_viewer() {
	return Display_Post_View_Count::wd_dpvc_init_plugin();
}

/**
 * kick of the pluging by calling the function
 */
wd_dpvc_show_post_viewer();