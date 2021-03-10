<?php

/**
 * Plugin Name:       Edit post view
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Show how many time views post.
 * Version:           1.0.0
 * Author:            Khalid Ahmed
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       edit-post-view
 */

use Post\View\Frontend\Shortcode;

if( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

final class Edit_Post_View {
    /**
     * Plugin version
     */
    const version = "1.0";

    private function __construct()
    {
        $this->define_constants();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        add_action( 'init', [ $this, 'init_plugin' ] );
    }
    
    /**
     * initialize singleton instance
     *
     * @return \Edit_Post_View
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
        define( 'WD_EPV_VERSION', self::version );
        define( 'WD_EPV_FILE', __FILE__ );
        define( 'WD_EPV_PATH', __DIR__ );
        define( 'WD_EPV_URL', plugins_url( '', WD_EPV_FILE ) );
    }
        
    /**
     * initialize the plugin
     *
     * @return void
     */

    public function init_plugin()
    {
        new Shortcode();
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() 
    {
        $installed = get_option( 'wd_epv_installed' );
        if( ! $installed ) {
            update_option( 'wd_epv_installed', time() );
        }
        update_option( 'wd_epv_installed', WD_EPV_VERSION );
    }
}

/**
 * iniitalize the main plugin
 *
 * @return \Edit_Post_View
 */
function start_edit_post_view()
{
    return Edit_Post_View::init();
}

/**
 * Kick of plugin
 */
start_edit_post_view();