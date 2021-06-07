<?php
/**
 * Plugin Name:       Wd Subscription Form
 * Plugin URI:        https://example.com/
 * Description:       Disply MailChimp Subscription Form via widget
 * Version:           1.0.0
 * Requires at least: 5.6
 * Requires PHP:      5.6
 * Author:            Khalid Ahmed.
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       we-subscription-form
 * Domain Path:       /languages/
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

if ( ! defined( 'We_Subscription_Form' ) ) {
    /**
     * Plugin main class
     */
    final class We_Subscription_Form {
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
         * Run all plugin functionalities
         * 
         * @return void
         */
        public function init_plugin() {
            new \Mailchimp\Subscription\Assets();
            
            if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
                new \Mailchimp\Subscription\Ajax();
            }

            new \Mailchimp\Subscription\Adminmenu();

            new \Mailchimp\Subscription\Subscription_Widget();
        }

        /**
         * Define all necessary constants
         * 
         * @return void
         */
        public function define_constants() {
            define( 'WSF_VERSION', self::version );
            define( 'WSF_PATH', __DIR__ );
            define( 'WSF_FILE', __FILE__ );
            define( 'WSF_URL', plugins_url( '', WSF_FILE ) );
            define( 'WSF_ASSETS', WSF_URL . '/assets' );
        }

        /**
         * Add Plugin version and time to db
         * 
         * @return void
         */
        public function activate() {
            $installed = get_option( 'wsf_installed' );

            if ( ! $installed ) {
                update_option( 'wsf_installed', time() );
            }

            update_option( 'wsf_version', WSF_VERSION );
        }

        /**
         * Initialize a singleton instance
         * 
         * @return \We_Subscription_Form
         */
        public static function init() {
            static $instance = false;

            if ( ! $instance ) {
                $instance = new self();
            }

            return $instance;
        }
    }
}

/**
 * Initialize the plugin
 * 
 * @return \We_Subscription_Form
 */
function we_subscription_form_boot() {
    return We_Subscription_Form::init();
}

//Start the plugin
we_subscription_form_boot();