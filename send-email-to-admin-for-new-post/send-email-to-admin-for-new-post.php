<?php
/*
   Plugin Name:     Send email to admin for new post
   Plugin URI:      https://example.com/
   description:     Send email to admin for every new post
   Version:         1.0.0
   Author:          Khalid Ahmed
   Author URI:      https://example.com/
   License:         GPL2 or later
   Text domain:     send-email-to-admin-for-new-post
   */

if( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

final class Send_Email_To_Admin {

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
     * @return void
     */
    private function define_constant() {
        define( 'SE_RELEASE_NUMBER', self::version );
        define( 'SE_FILE', __FILE__ );
        define( 'SE_PATH', __DIR__ );
        define( 'SE_URL', plugins_url( '', SE_FILE ) );
        // define( 'SETA_ASSETS', SETA_URL . '/asstes');
    }
        
    /**
     * init_plugin
     * initialize plugin
     * @return void
     */
    public function init_plugin() {
        new Send\Admin\Email();

    }

    /**
     * activate
     *  
     * @return void
     */
    public function activate() {
        $install_date = get_option( 'install_date', time() );
        
        if( ! $install_date ) {
            update_option( 'version', SE_RELEASE_NUMBER );
        }
    }
}

/**
 * send_email
 * initialize the main plugin
 * @return \Send_Email_To_Admin
 */
function send_email() {
    return Send_Email_To_Admin::init();
}

/**
 * kick of the pluging by calling the function
 */
send_email();