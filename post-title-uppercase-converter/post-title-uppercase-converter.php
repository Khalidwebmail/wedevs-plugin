<?php

/*
   Plugin Name:     Convert post tile to uppercase
   Plugin URI:      https://example.com/
   description:     Convert title to uppercase when post will save
   Version:         1.0.0
   Author:          Khalid Ahmed
   Author URI:      https://example.com/
   License:         GPL2 or later
   Text domain:     convert-post-tile-to-uppercase
   */

use Post\Title\Admin\Uppercase;

if( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

final class Post_Title_Uppercase_Convert {
    const version = '1.0.0';

    private function __construct() {

        $this->define_constant();

        register_activation_hook( __FILE__, [$this, 'activate'] );

        add_action( 'init', [$this, 'init_plugin'] );
    }

        
    /**
     * init
     * initialize single instance
     * @return \Post_Title_Uppercase_Convert
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
        define( 'UC_RELEASE_NUMBER', self::version );
        define( 'UC_FILE', __FILE__ );
        define( 'UC_PATH', __DIR__ );
        define( 'UC_URL', plugins_url( '', UC_FILE ) );
        // define( 'SETA_ASSETS', SETA_URL . '/asstes');
    }
        
    /**
     * init_plugin
     * initialize plugin
     * @return void
     */
    public function init_plugin() {
        new Uppercase();

    }

    /**
     * activate
     *  
     * @return void
     */
    public function activate() {
        $install_date = get_option( 'install_date', time() );
        
        if( ! $install_date ) {
            update_option( 'version', UC_RELEASE_NUMBER );
        }
    }
}

/**
 * title_uppercase
 * initialize the main plugin
 * @return \Post_Title_Uppercase_Convert
 */
function title_uppercase() {
    return Post_Title_Uppercase_Convert::init();
}

/**
 * kick of the pluging by calling the function
 */
title_uppercase();