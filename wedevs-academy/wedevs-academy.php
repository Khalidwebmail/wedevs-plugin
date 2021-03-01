<?php

/*
 * Plugin Name:       WeDevs Academy
 * Plugin URI:        https://khalid.co
 * Description:       A tutorial plugin for weDevs Academy.
 * Version:           1.0
 * Author:            Khalid Ahmed
 * Author URI:        https://khalid.co
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
*/

if( ! defined("ABSPATH")){
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';
/**
 * Plugin Class name
 */

final class WeDevs_Academy {
    
    /**
     * Plugin version
     */
    const version = "1.0";

    private function __construct()
    {
        $this->define_constants();

        register_activation_hook( __FILE__, [$this, 'activate']);
        add_action('plugins_loaded', [$this, 'init_plugin']);
    }
    
    /**
     * initialize singleton instance
     *
     * @return \WeDevs_Academy
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
        define('WD_ACADEMY_VERSION', self::version);
        define("WD_ACADEMY_FILE", __FILE__);
        define("WD_ACADEMY_PATH", __DIR__);
        define("WD_ACADEMY_URL", plugins_url('', WD_ACADEMY_FILE));
        define("WD_ACADEMY_ASSETS", WD_ACADEMY_URL . '/assets');
    }
        
    /**
     * initialize the plugin
     *
     * @return void
     */

    public function init_plugin()
    {
        if(is_admin()) {
            new WeDevs\Academy\Admin();
        }
        else{
            new WeDevs\Academy\Frontend();
        }
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() 
    {
        $installed = get_option("wd_academy_installed");
        if( ! $installed ) {
            update_option('wd_academy_installed', time());
        }
        update_option('wd_academy_version', WD_ACADEMY_VERSION);
    }
}

/**
 * iniitalize the main plugin
 *
 * @return \WeDevs_Academy
 */
function wedevs_academy()
{
    return WeDevs_Academy::init();
}

/**
 * Kick of plugin
 */
wedevs_academy();