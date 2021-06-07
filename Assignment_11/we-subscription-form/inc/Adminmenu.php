<?php

namespace Mailchimp\Subscription;

/**
 * Admin menu class
 */
class Adminmenu {
    /**
     * Class constructor
     */
    public function __construct() {
        add_action( 'admin_init', [ $this, 'register_menu' ] );
    }

    /**
     * Register Admin menu
     * 
     * @return void
     */
    public function register_menu() {
        register_setting( 'general', 'wcf_api_settings', [ 'sanitize_callback' => 'esc_attr' ] );
        
        add_settings_section( 'wcf_settings_section', __( 'We Subscription Settings', 'we-subscription-form' ), [ $this, 'wcf_settings_section_cb' ], 'general' );

        add_settings_field( 
            'wcf_api_settings', 
            __( 'MailChimp API key', 'we-subscription-form' ), 
            [ $this, 'wcf_settings_add_field' ], 
            'general', 
            'wcf_settings_section', 
            [ 'wcf_settings' ] 
        );
    }

    public function wcf_settings_add_field() {
        $api_key = get_option( 'wcf_api_settings' );

        printf(
            "<input class='regular-text' type='text' name='wcf_api_settings' id='wcf_api_settings' value='%s'",
            esc_attr( $api_key )
        );
    }

    /**
     * Display settings section
     * 
     * @return void
     */
    public function wcf_settings_section_cb() {
        printf( "<p class='description'>%s</p>", __( 'Please prorvide your MailChimp api key in order to get access to MailChimp api', 'we-subscription-form' ) );
    }
}