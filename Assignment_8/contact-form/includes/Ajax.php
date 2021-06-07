<?php

namespace Contact\Form;

/**
 * Ajax Request handler class
 */
class Ajax {

    /**
     * Hold the errors
     * 
     * @var array
     */
    public $errors = array();

    /**
     * Class constructore
     */
    public function __construct() {
        add_action( 'wp_ajax_contact_form', array( $this, 'handle_contact_form' ) );
    }

    /**
     * Handle contact form
     * 
     * @return JSON
     */
    public function handle_contact_form() {
        if (! wp_verify_nonce( $_POST['_wpnonce'], 'contact-form' )){
            wp_send_json_error( [ 'message' => __("Nonce is invalid", 'contact-form') ] );
        }

        $name = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
        $email = isset( $_POST['email'] ) ? sanitize_text_field( wp_unslash( $_POST['email'] ) ) : '';
        $message = isset( $_POST['message'] ) ? sanitize_text_field( wp_unslash( $_POST['message'] ) ) : '';

        if ( empty( $name ) ) {
            $this->errors['name'] = __('Please enter your name', 'contact-form' );
        }

        if ( empty( $email ) ) {
            $this->errors['email'] = __('Please enter your email', 'contact-form' );
        }

        if ( empty( $message ) ) {
            $this->errors['message'] = __('Please enter your message', 'contact-form' );
        }

        if ( ! empty( $this->errors ) ) {
            wp_send_json_error( array( 'errors'  => $this->errors ) );
        }

        $data = array(
            'name'    => $name,
            'email'   => $email,
            'message' => $message,
        );

        $insert_id = wpcf_insert_message( $data );

        if ( is_wp_error( $insert_id ) ) {
            wp_send_json_error( array( 'message' => $insert_id->get_error_message(), ) );
        }

        wp_send_json_success( array( 
            'message' => __( "Thanks for your message", 'contact-form' ),
            'contact' => $data,
        ) );
    }

}