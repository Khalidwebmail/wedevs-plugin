<?php

namespace Mailchimp\Subscription;

/**
 * Assets class enqueue all styles and scripts
 */
class Assets {
    /**
     * Class construct
     * 
     * @return void
     */
    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'register_scripts' ] );
    }

    /**
     * Register all scripts
     * 
     * @return void
     */
    public function register_scripts() {
        $scripts = $this->get_scripts();

        foreach( $scripts as $handle => $script ) {
            wp_register_script( $handle, $script['src'], $script['deps'], $script['version'], true );
        }

        wp_localize_script( 'wsf-main', 'wsfobj', [
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'handle_subscription_nonce' ),
        ] );
    }

    /**
     * Get scripts
     * 
     * @return array
     */
    public function get_scripts() {
        return [
            'wsf-main' => [
                'src'     => WSF_ASSETS . '/js/wsf-main.js',
                'version' => filemtime( WSF_PATH . '/assets/js/wsf-main.js' ),
                'deps'    => ['jquery'],
            ]
        ];
    }
}