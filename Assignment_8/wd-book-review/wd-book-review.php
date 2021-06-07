<?php

/**
 * Plugin Name: Wd Book Reviews
 * Description: A plugin for creating book reviews
 * Plugin URI: https://example.com
 * Author: Shahadat
 * Author URI: https://khalid.com
 * Version: 1.0.0
 * License: GPL2
 * Text Domain: wd-book-reviews
 * Domain Path: /languages/
 */

// Don't call the file directory
if ( ! defined('ABSPATH') ) {
	exit;
}

if( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}
/**
 * Book_Reviews class
 *
 * @class Wd_Book_Reviews the class that holds the whole plugin
 */
final class Wd_Book_Reviews {

	/**
	 * Plugin Version
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * Constructor Wd_Book_Reviews class
	 *
	 * Setup the all specific hooks and actions
	 */
	private function __construct() {
		$this->wd_define_constants();
		register_activation_hook( __FILE__, array( $this, 'wd_activate' ) );
		add_action( 'plugins_loaded', [ $this, 'wd_init_plugin' ] );
	}

	/**
	 * Define required plugin constants
	 *
	 * @return void
	 */
	public function wd_define_constants() {
		define( 'WDBR_PLUGIN_VERSION', $this->version );
		define( 'WDBR_PLUGIN_FILE', __FILE__ );
		define( 'WDBR_PLUGIN_PATH', __DIR__ );
		define( 'WDBR_PLUGIN_URL', plugins_url( '', WDBR_PLUGIN_FILE ) );
		define( 'WDBR_PLUGIN_ASSETS', WDBR_PLUGIN_URL . '/assets' );
	}

	/**
	 * Create Ratings table when activate
	 *
	 * @return void
	 */
	public function wd_activate() {
		$installer = new Book\Reviews\Wd_Installer();
		$installer->wd_run();
	}

	/**
	 * Initialize the plugin
	 * @return
	 */
	public function wd_init_plugin() {
		new Book\Reviews\Wd_Asset();
		new Book\Reviews\Frontend\Book_Frontend();

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			new Book\Reviews\Wd_Ajax();
		}
		new Book\Reviews\Admin\Book_Admin();
	}

	/**
	 * Initialize the Book_Reviews class
	 *
	 * Checks for an existing Book_Reviews instace
	 * and if it doesn't find one, create it.
	 */
	public static function wd_init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}
}

/**
 * Kickoff Wd_Book_Reviews plugin when all plugins loaded
 *
 * @return Wd_Book_Reviews
 */
function wd_book_reviews() {
	return Wd_Book_Reviews::wd_init();
}

// Lets Go...
wd_book_reviews();