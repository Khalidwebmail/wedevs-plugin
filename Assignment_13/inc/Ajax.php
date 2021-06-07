<?php

namespace WdRestApi;

/**
 * Handle ajax request class
 */
class Ajax {
    /**
     * Class construct
     * 
     * @return void
     */
    public function __construct() {
        add_action( 'wp_ajax_wcfn_handle_form_request', [ $this, 'handle_ajax_request' ] );
        add_action( 'wp_ajax_nopriv_wcfn_handle_form_request', [ $this, 'handle_ajax_request' ] );
    }

    public function handle_ajax_request() {
        if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'wcfn_handle_request' ) ) {
            wp_send_json_error( [
                'message' => __( 'Sorry invalid request', 'we-contact-form' )
            ] );
        }

        $data = [];
        parse_str( $_REQUEST['data'], $data );

        
        $wcfn_name    = sanitize_text_field( $data['wcfn_name'] );
        $wcfn_email   = sanitize_email( $data['wcfn_email'] );
        $wcfn_message = sanitize_textarea_field( $data['wcfn_message'] );
        
        $check_email_already_exists = wcfn_get_contact_by_email( $data['wcfn_email'] );

        if ( ! empty( $check_email_already_exists ) ) {
            wp_send_json_error( [
                'message' => __( 'Sorry this email already exists', 'we-contact-form' )
            ] );
        }

        $args = [
            'name'    => $wcfn_name,
            'email'   => $wcfn_email,
            'message' => $wcfn_message,
        ];

        $inserted_id = wcfn_insert_form_data( $args );

        if ( is_wp_error( $inserted_id ) ) {
            wp_die( $inserted_id->get_error_message() );
        }

        wp_send_json_success( [
            'message' => __( 'Thank you for connecting with us', 'we-contact-form' )
        ] );
    }
}