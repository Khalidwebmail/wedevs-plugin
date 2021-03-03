<?php

/*
 * Plugin Name:       Meta Info
 * Plugin URI:        https://khalid.co
 * Description:       A plugin use for dynamic meta description
 * Version:           1.0
 * Author:            Khalid Ahmed
 * Author URI:        https://khalid.co
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text domain:       meta-info
*/

use Meta\Info\Admin\MetaDetails;

if( ! defined("ABSPATH")){
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';
/**
 * Plugin Class name
 */

final class Meta_Info {
    
    /**
     * Plugin version
     */
    const version = "1.0";

    private function __construct()
    {
        $this->define_constants();

        register_activation_hook( __FILE__, [$this, 'activate'] );
        add_action('init', [$this, 'init_plugin'] );
    }
    
    /**
     * initialize singleton instance
     *
     * @return \Meta_Info
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
        define('META_INFO_VERSION', self::version);
        define('META_INFO_FILE', __FILE__);
        define('META_INFO_PATH', __DIR__);
        define('META_INFO_URL', plugins_url('', META_INFO_FILE));
        define('META_INFO_ASSETS', META_INFO_URL . '/assets');
    }

    /**
     * initialize the plugin
     *
     * @return void
     */

    public function init_plugin()
    {
        new MetaDetails();
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() 
    {
        $installed = get_option("meta_info_installed");
        if( ! $installed ) {
            update_option('meta_info_installed', time());
        }
        update_option('meta_info_version', META_INFO_VERSION);
    }
}

/**
 * iniitalize the main plugin
 *
 * @return \Meta_Info
 */
function meta_info()
{
    return Meta_Info::init();
}

/**
 * Kick of plugin
 */
meta_info();