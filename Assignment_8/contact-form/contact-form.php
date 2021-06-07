<?php
/**
 * Plugin Name: Contact Form
 * Description: A plugin for creating contact form
 * Plugin URI: https://wordpress.org/contact-form
 * Version: 1.0.0
 * Author: Shahadat
 * Author URI: https://shahadat.com
 * Text Domain: contact-form
 * WC requires at least: 5.6.2
 * WC tested up to: 5.6.2
 * Domain Path: /languages/
 * Licence: GPL
 */

// Don't call the file directly
if ( ! defined("ABSPATH") ) {
    exit;
}

/**
 * Contact_Form class
 *
 * @class Contact_Form The class that holds the entire Contact_Form plugin
 */
final class Contact_Form {

    /**
    * Plugin version
    *
    * @var string
    */
    const VERSION = '1.0.0';

    /**
    * Constructor for the Contact_Form class
    *
    * Sets up all the specific hooks and actions
    * within our plugin.
    */
    public function __construct() {
        require_once __DIR__ . '/vendor/autoload.php';
        $this->define_constants();
        register_activation_hook( __FILE__, array( $this, 'activate' ) ); 
        add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );       
    }

    /**
    * Define all constants
    *
    * @return void
    */
    public function define_constants() {
        $this->define_constant( 'WPCF_PLUGIN_VERSION', self::VERSION );
        $this->define_constant( 'WPCF_PLUGIN_FILE', __FILE__ );
        $this->define_constant( 'WPCF_PLUGIN_PATH', __DIR__ );
        $this->define_constant( 'WPCF_PLUGIN_URL', plugins_url( '', WPCF_PLUGIN_FILE ) );
        $this->define_constant( 'WPCF_PLUGIN_ASSETS', WPCF_PLUGIN_URL . '/assets' );
    }

    /**
    * Define constant if not already defined
    *
    * @since 1.0.0
    *
    * @param string      $name
    * @param string|bool $value
    *
    * @return void
    */
    private function define_constant( $name, $value ) {
        if ( ! defined( $name ) ) {
            define( $name, $value );
        }
    }

    /**
    * Create table and add version
    *
    * @return void
    */
    public function activate() {
        $installer = new Contact\Form\Installer();
        $installer->run();
    }

    /**
     * Initialize the plugin
     * @return 
     */
    public function init_plugin() {
        new Contact\Form\Assets();
        new Contact\Form\Frontend\Shortcode();

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            new Contact\Form\Ajax();
        }

        new Contact\Form\Admin\Contact_Messages();
    }

    /**
    * Initializes the Contact_Form() class
    *
    * Checks for an existing Contact_Form() instance
    * and if it doesn't find one, creates it.
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
 * Load Contact_Form Plugin when all plugins loaded
 *
 * @return Contact_Form
 */
function contact_form() {
    return Contact_Form::init();
}

// Let's Go...
contact_form();
