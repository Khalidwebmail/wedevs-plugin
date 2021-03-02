<?php
   /*
   Plugin Name:     Display Simple Post View Count
   Plugin URI:      https://example.com/
   description:     A plugin to simple post count display
   Version:         1.0.0
   Author:          Khalid Ahmed
   Author URI:      https://example.com/
   License:         GPL2 or later
   Text domain:     display-simple-post-view-count
   */

use Display\Post\View\Frontend\Counter;

if( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

final class Display_Post_View_Count {

    const version = '1.0.0';

    private function __construct() {

        $this->define_constant();

        register_activation_hook( __FILE__, [$this, 'activate'] );

        add_action( 'init', [$this, 'init_plugin'] );
    }

        
    /**
     * init
     * initialize single instance
     * @return \Display_Post_View_Count
     */
    public static function init() {
        static $instance = false;

        if( ! $instance ) {
            $instance =new self();
        }

        return $instance;
    }
    
    /**
     * define_constant
     * DPVC - Display Post View Count
     * @return void
     */
    private function define_constant() {
        define( 'DPVC_RELEASE_NUMBER', self::version );
        define( 'DPVC_FILE', __FILE__ );
        define( 'DPVC_PATH', __DIR__ );
        define( 'DPVC_URL', plugins_url( '', DPVC_FILE ) );
        define( 'DPVC_ASSETS', DPVC_URL . '/asstes');
    }
        
    /**
     * init_plugin
     * initialize plugin
     * @return void
     */
    public function init_plugin() {
        new Counter();
    }

    /**
     * activate
     *  
     * @return void
     */
    public function activate() {
        $install_date = get_option( 'dpvc_installed', time() );
        
        if( ! $install_date ) {
            update_option( 'dpvc_version', DPVC_RELEASE_NUMBER );
        }
    }
} 


/**
 * show_views_number
 * initialize the main plugin
 * @return \Display_Post_View_Count
 */
function show_views_number() {
    return Display_Post_View_Count::init();
}

/**
 * kick of the pluging by calling the function
 */
show_views_number();