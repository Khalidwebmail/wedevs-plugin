<?php

/**
 * Convert post tile to uppercase
 *
 * @package           Convert post tile to uppercase
 * @author            Khalid Ahmed
 * @copyright         2021 Khalid Ahmed
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Convert post tile to uppercase
 * Plugin URI:        https://example.com/plugin-name
 * Description:       A plugin to simple post count display.
 * Version:           1.0.0
 * Author:            Khalid Ahmed
 * Author URI:        https://example.com
 * Text Domain:       convert-post-tile-to-uppercase
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

final class Post_Title_Uppercase_Convert {
	const version = '1.0.0';

	/**
	 * Post_Title_Uppercase_Convert constructor.
	 */
	private function __construct() {
		$this->wd_tuc_define_constant();
		register_activation_hook( __FILE__, [ $this, 'wd_tuc_activate' ] );
		add_action( 'init', [ $this, 'wd_tuc_init_plugin' ] );
	}

	/**
	 * init
	 * initialize single instance
	 * @return \Post_Title_Uppercase_Convert
	 */
	public static function wd_tuc_init() {
		static $instance = false;

		if( ! $instance ) {
			$instance =new self();
		}
		return $instance;
	}

	/**
	 * wd_tuc_define_constant
	 * @return void
	 */
	private function wd_tuc_define_constant() {
		define( 'WD_TUC_RELEASE_NUMBER', self::version );
		define( 'WD_TUC_FILE', __FILE__ );
		define( 'WD_TUC_PATH', __DIR__ );
	}

	/**
	 * wd_tuc_init_plugin
	 * initialize plugin
	 * @return void
	 */
	public function wd_tuc_init_plugin() {
		if( is_admin() ) {
			new \Post\Title\Admin\Title_Uppercase();
		}
	}

	/**
	 * wd_tuc_activate
	 *
	 * @return void
	 */
	public function wd_tuc_activate() {
		$install_date = get_option( 'wd_tuc_install_date', time() );

		if( ! $install_date ) {
			update_option( 'version', WD_TUC_RELEASE_NUMBER );
		}
	}
}

/**
 * wd_tuc_title_uppercase
 * initialize the main plugin
 * @return \Post_Title_Uppercase_Convert
 */
function wd_tuc_title_uppercase() {
	return Post_Title_Uppercase_Convert::wd_tuc_init();
}

/**
 * kick of the pluging by calling the function
 */
wd_tuc_title_uppercase();