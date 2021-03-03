<?php
   /*
   Plugin Name:     Vertical menu
   Plugin URI:      https://example.com/
   description:     A simple vertical menu show in right side
   Version:         1.0.0
   Author:          Khalid Ahmed
   Author URI:      https://example.com/
   License:         GPL2 or later
   Text domain:     vertical-menu
   */

use Vertical\Admin\Menu;
use Vertical\Frontend\ShowButton;

if( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

final class Vertical_Menu {

    /**
     * Plugin version
     */
    const version = "1.0";

    private function __construct()
    {
        $this->define_constants();

        register_activation_hook( __FILE__, [$this, 'activate']);
        add_action('init', [$this, 'init_plugin']);
    }
    
    /**
     * initialize singleton instance
     *
     * @return \Vertical_Menu
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
        define('MENU_VERSION', self::version);
        define("MENU_FILE", __FILE__);
        define("MENU_PATH", __DIR__);
        define("MENU_URL", plugins_url('', MENU_FILE));
        define("MENU_ASSETS", MENU_URL . '/assets');
    }
        
    /**
     * initialize the plugin
     *
     * @return void
     */

    public function init_plugin()
    {
        if(is_admin()) {
            new Menu();
        }
        else{
            new ShowButton();
        }
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() 
    {
        $installed = get_option("vertical_menu_installed");
        if( ! $installed ) {
            update_option('vertical_menu_installed', time());
        }
        update_option('vertical_menu_installed', MENU_VERSION);
    }
}

/**
 * iniitalize the main plugin
 *
 * @return \Vertical_Menu 
 */
function vertical_menu()
{
    return Vertical_Menu::init();
}

/**
 * Kick of plugin
 */
vertical_menu();