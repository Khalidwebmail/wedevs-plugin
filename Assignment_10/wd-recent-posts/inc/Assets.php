<?php

namespace Recent\Posts;

/**
 * Assets class
 * 
 */
class Assets {
    /**
     * Class constructor
     */
    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'register_script' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'register_script' ] );
    }

    /**
     * Register scripts
     * 
     * @return void
     */
    public function register_script() {
        $scripts = $this->get_scripts();

        foreach( $scripts as $handle => $script ) {
            wp_register_script( $handle, $script['src'], $script['deps'], $script['version'], true );
        }

        wp_localize_script( 'wrp-main', 'wrpobj', [
            'ajax_url' => \admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'handle_dashboard_form' ),
        ] );
    }

    /**
     * Get scripts
     * 
     * @return array
     */
    public function get_scripts() {
        return [
            'wrp-main' => [
                'src'     => WRP_ASSETS . '/js/wrp-main.js',
                'version' => filemtime( WRP_PATH . '/assets/js/wrp-main.js' ),
                'deps'    => [ 'jquery' ]
            ]
        ];
    }
}