<?php

namespace WdRestApi;

/**
 * Assets class
 */
class Assets {
    /**
     * Class constructor
     * 
     * @return void
     */
    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'register_scripts' ] );
    }

    /**
     * Register all styles and script
     * 
     * @return void
     */
    public function register_scripts() {
        $styles  = $this->get_styles();
        $scripts = $this->get_scripts();

        foreach( $styles as $handle => $style ) {
            wp_register_style( $handle, $style['src'], $style['deps'], $style['version'] );
        }

        foreach( $scripts as $handle => $script ) {
            wp_register_script( $handle, $script['src'], $script['deps'], $script['version'], true );
        }

        wp_localize_script( 'wcfn-shortcodeform-script', 'wcfnobj', [
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'wcfn_handle_request' ),
        ] );
    }

    /**
     * Get styles
     * 
     * @return array
     */
    public function get_styles() {
        return [
            'wcfn-shortcodeform-style' => [
                'src'     => WE_REST_PLUGIN_ASSETS . '/css/wcfn-shortcodeform-style.css',
                'version' => filemtime( WE_REST_PLUGIN_PATH . '/assets/css/wcfn-shortcodeform-style.css' ),
                'deps'    => []
            ]
        ];
    }

    /**
     * Get scripts
     * 
     * @return array
     */
    public function get_scripts() {
        return [
            'wcfn-shortcodeform-script' => [
                'src'     => WE_REST_PLUGIN_ASSETS . '/js/wcfn-shortcodeform.js',
                'version' => filemtime( WE_REST_PLUGIN_PATH . '/assets/js/wcfn-shortcodeform.js' ),
                'deps'    => [ 'jquery' ],
            ]
        ];
    }
}