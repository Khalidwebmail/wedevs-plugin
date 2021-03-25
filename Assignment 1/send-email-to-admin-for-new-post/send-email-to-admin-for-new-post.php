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

        $this->wd_se_define_constant();

        register_activation_hook( __FILE__, [ $this, 'wd_se_activate' ] );

        add_action( 'init', [ $this, 'wd_se_init_plugin' ] );
    }

        
    /**
     * init
     * initialize single instance
     * @return \Display_Post_View_Count
     */
    public static function wd_se_init() {
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
    private function wd_se_define_constant() {
        define( 'WD_SE_RELEASE_NUMBER', self::version );
        define( 'WD_SE_FILE', __FILE__ );
        define( 'WD_SE_PATH', __DIR__ );
        define( 'WD_SE_URL', plugins_url( '', WD_SE_FILE ) );
    }
        
    /**
     * init_plugin
     * initialize plugin
     * @return void
     */
    public function wd_se_init_plugin() {
        if( is_admin() ) {
            new \Send\Email\Admin\Send_Email();
        }
    }

    /**
     * wd_se_activate
     * Store install to database
     * @return void
     */
    public function wd_se_activate() {
        $install_date = get_option( 'wd_se_install_date', time() );
        
        if( ! $install_date ) {
            update_option( 'version', WD_SE_RELEASE_NUMBER );
        }
    }
}

/**
 * wd_se_send_email
 * initialize the main plugin
 * @return \Send_Email_To_Admin
 */
function wd_se_send_email() {
    return Send_Email_To_Admin::wd_se_init();
}

/**
 * kick of the pluging by calling the function
 */
wd_se_send_email();