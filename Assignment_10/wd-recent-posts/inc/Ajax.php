<?php

namespace Recent\Posts;

/**
 * Ajax class
 */
class Ajax {
    /**
     * Class constructor
     * 
     * @return void
     */
    public function __construct() {
        add_action( 'wp_ajax_handle_dashboard_form', [ $this, 'handle_dashboard_request' ] );
    }

    /**
     * Handle ajax request
     * 
     * @return string
     */
    public function handle_dashboard_request() {
        if ( ! isset( $_REQUEST['nonce'] ) && ! wp_verify_nonce( $_REQUEST['nonce'], 'handle_dashboard_form' ) ) {
            wp_send_json_error( [
                'message' => __( 'Sorry invalid request', 'wd-recent-posts' )
            ] );
        }

        if ( ! current_user_can( 'edit_dashboard' ) ) {
            wp_send_json_error( [
                'message' => __( 'Sorry you do not have permission', 'wd-recent-posts' )
            ] );
        }

        $options = [];
        parse_str( $_REQUEST['data'], $options );

        if ( isset( $options['wrp_no_of_posts'] ) ) {
            update_option( 'wrp_no_of_posts', sanitize_text_field( $options['wrp_no_of_posts'] ) );
        }

        if ( isset( $options['wrp_order'] ) ) {
            update_option( 'wrp_order', sanitize_text_field( $options['wrp_order'] ) );
        }

        if ( isset( $options['wrp_category_items'] ) ) {
            update_option( 'wrp_category_items', $options['wrp_category_items'] );
        }

        wp_send_json_success();
    }
}