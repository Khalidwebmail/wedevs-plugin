<?php

namespace Mailchimp\Subscription;

/**
 * Handle Ajax request class
 */
class Ajax {
    /**
     * Class constructor
     */
    public function __construct() {
        add_action( 'wp_ajax_submit_subscriber', [ $this, 'handle_subscriber_request' ] );
        add_action( 'wp_ajax_nopriv_submit_subscriber', [ $this, 'handle_subscriber_request' ] );
    }

    /**
     * Handle ajax request
     * 
     * @return void
     */
    public function handle_subscriber_request() {
        $api_key = get_option( 'wcf_api_settings' );

        if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'handle_subscription_nonce' ) ) {
            wp_send_json_error( [
                'message' => __( 'Sorry, You do not have right permission', 'we-subscription-form' ),
            ] );
        }

        if ( ! isset( $_REQUEST['audience_id'] ) && empty( $_REQUEST['audience_id'] ) && empty( $api_key ) ) {
            wp_send_json_error( [
                'message' => __( 'Sorry, invalid request', 'we-subscription-form' ),
            ] );
        }

        $url = "https://us1.api.mailchimp.com/3.0/lists/{$_REQUEST['audience_id']}/members";

        $data = [];
        parse_str( $_REQUEST['data'], $data );
        
        $email = sanitize_email( $data['wsf_subscribe'] );

        $body = [
            'email_address' => $email,
            'status'        => 'subscribed',
        ];

        $args = [
            'headers' => [
                'Content-Type' => 'application/json;charset=utf-8',
                'Authorization' => "apikey {$api_key}",
            ], 
            'body' => json_encode( $body ),
        ];

        $response = (int) wp_remote_retrieve_response_code( wp_remote_post( $url, $args ) );

        if ( 400 === $response ) {
            wp_send_json_error( [
                'message' => __( 'This email you provide may be used or invalid email', 'we-subscription-form' ),
            ] );
        }

        if ( 200 !== $response ) {
            wp_send_json_error( [
                'message' => __( 'Sorry, could not process your request right now. Please try again.', 'we-subscription-form' ),
            ] );
        }

        wp_send_json_success( [
            'message' => __( 'Thank you. Registration is successfull😀', 'we-subscription-form' ),
        ] );
    }
}