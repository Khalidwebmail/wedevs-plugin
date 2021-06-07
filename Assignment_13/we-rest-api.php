<?php
/**
 * Plugin Name:       We Rest API
 * Plugin URI:        https://example.com/
 * Description:       Display contact form with shortcode
 * Version:           1.0.0
 * Author:            Khalid Ahmed.
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       we-rest-api
 * Domain Path:       /languages/
 */

// Prevent Direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

if ( ! class_exists( 'We_Rest_Api' ) ) {
    /**
     * Plugin main class
     */
    final class We_Rest_Api {
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
        private function __construct() {
            $this->define_constants();

            register_activation_hook( __FILE__, [ $this, 'activate' ] );

            add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
        }

        /**
         * Initialize the plugin
         * 
         * @return void
         */
        public function init_plugin() {
            new WdRestApi\Assets();

            if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
                new WdRestApi\Ajax();
            }
            
            new WdRestApi\Shortcode();
            //new WeRestApi\Adminmenu();
            new WdRestApi\API();
        }

        /**
         * Define all necessary constants
         * 
         * @return void
         */
        public function define_constants() {
            define( 'WE_REST_PLUGIN_VERSION', self::version );
            define( 'WE_REST_PLUGIN_PATH', __DIR__ );
            define( 'WE_REST_PLUGIN_FILE', __FILE__ );
            define( 'WE_REST_PLUGIN_URL', plugins_url( '', WE_REST_PLUGIN_FILE ) );
            define( 'WE_REST_PLUGIN_ASSETS', WE_REST_PLUGIN_URL . '/assets' );
        }

        /**
         * Do all stuff while plugin activation
         * 
         * @return void
         */
        public function activate() {
            $installer = new WdRestApi\Installer();
            $installer->run();
        }

        /**
         * Initialize a singleton instance
         * 
         * @return \We_Rest_Api
         */
        public static function init() {
            $instance = false;

            if ( ! $instance ) {
                $instance = new self();
            }

            return $instance;
        }
    }
}

/**
 * Initialize the main plugin
 * 
 * @return \We_Rest_Api
 */
function wcf_we_rest_api_boot() {
    return We_Rest_Api::init();
}

// Start the plugin
wcf_we_rest_api_boot();