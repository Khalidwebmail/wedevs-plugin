<?php

/**
 * Show Related Product
 *
 * @package           Show Related Product
 * @author            Your Name
 * @copyright         2021 Khalid Ahmed
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Show Related Product
 * Plugin URI:        https://example.com/plugin-name
 * Description:       Description of the plugin.
 * Version:           1.0.0
 * Author:            Khalid Ahmed
 * Author URI:        https://example.com
 * Text Domain:       show-related-product
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if( ! defined( 'ABSPATH' ) ) {
    exit;
}

# Include autoload file
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Class Show_Related_Product
 */
final class Show_Related_Product {
    /**
     * Plugin version
     */
    const version = '1.0.0';

    /**
     * Show_Related_Product constructor.
     */
    private function __construct() {
        $this->define_constants();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        add_action( 'init', [ $this, 'init_plugin' ] );
    }

    /**
     * Initialize singleton instance
     *
     * @return Show_Related_Product
     */
    public static function init()
    {
        static $instance  = false;

        if(! $instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * define required plugins constants
     *
     * @return void
     */
    public function define_constants()
    {
        define( 'WOO_RELETED_VERSION', self::version );
        define( 'WOO_RELETED_FILE', __FILE__ );
        define( 'WOO_RELETED_PATH', __DIR__ );
        define( 'WOO_RELETED_URL', plugins_url('', WOO_RELETED_FILE ) );
        define( 'WOO_RELETED_ASSETS', WOO_RELETED_URL . '/assets' );
    }

    /**
     * initialize the plugin
     *
     * @return void
     */

    public function init_plugin() {
        new \Related\Product\Related_Product();
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate()
    {
        $installed = get_option( 'woo_related_installed' );
        if( ! $installed ) {
            update_option('woo_related_installed', time() );
        }
        update_option('woo_related_installed', WOO_RELETED_VERSION );
    }
}

/**
 * iniitalize the main plugin
 *
 * @return \Show_Related_Product
 */
function woo_start_related_product()
{
    return Show_Related_Product::init();
}

/**
 * Kick of plugin
 */
woo_start_related_product();