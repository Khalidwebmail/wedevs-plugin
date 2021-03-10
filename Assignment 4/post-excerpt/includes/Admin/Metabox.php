<?php

namespace Post\Excerpt\Admin;

class Metabox {
    public function __construct() {
        add_action( 'add_meta_boxes', [ $this, 'register_custom_meta_box' ] );
        add_action( 'save_post', [ $this, 'save_custom_meta_info'] );
    }
    
    /**
     * register_custom_meta_box
     * Add custom metabox form post
     * @return void
     */
    public function register_custom_meta_box() {
        add_meta_box(
            'excerpt_location',
            'Post Excerpt',
            [ $this, 'add_excerpt' ],
            'post',
            'normal',
            'high'
        );
    }
    
    /**
     * add_excerpt
     * Show excerpt value from database
     * @param  mixed $post
     * @return void
     */
    public function add_excerpt( $post ) {
        wp_nonce_field( 'excerpt_token', 'excerpt_token_field' );

        $get_excerpt = get_post_meta( $post->ID, 'excerpt_info', true );
        $excerpt     = ! empty( $get_excerpt ) ?  $get_excerpt : '';

        $html  = '<div class="form-group">';
        $html .= '<textarea name="excerpt_info" id="excerpt_info" class="widefat" rows=10>'.$excerpt.'</textarea>';
        $html .= '</div>';
        echo $html;
    }
    
    /**
     * save_custom_meta_info
     * Save excerpt info to database
     * @param  mixed $post_id
     * @return void
     */
    public function save_custom_meta_info( $post_id ) {
        $nonce = isset( $_POST[ 'excerpt_token_field' ] ) ? $_POST[ 'excerpt_token_field' ] : '';
        $excerpt = isset( $_POST['excerpt_info'] ) ? sanitize_text_field( $_POST['excerpt_info'] ) : '';
        if ( ! wp_verify_nonce( $nonce, 'excerpt_token' ) ) {
            return;
        }
        update_post_meta( $post_id, 'excerpt_info', $excerpt );
    }
}