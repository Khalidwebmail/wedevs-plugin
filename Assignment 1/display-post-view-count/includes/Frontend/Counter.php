<?php

namespace Display\Viewers\Frontend;

class Counter {

    public function __construct() {
        add_filter( 'the_content', [ $this, 'wd_dpvc_show_post_view' ] );
        add_filter( 'the_post', [ $this, 'wd_dpvc_set_post_view' ] );
    }
    
    /**
     * wd_dpvc_show_post_view
     * Get current viewers and return
     * @param  mixed $content
     * @return $content
     */
    public function wd_dpvc_show_post_view( $content ) {
        $count = get_post_meta( get_the_ID(), 'post_views_count', true );
        if( $count ) {
            $tag = apply_filters( 'wd_dpvc_tag', 'em' );
            return $content .= wp_sprintf( __( '<h3>Total viewers: <%s>%s<%s></h3>' ), $tag, $count, $tag );
        }
        else {
            return $content .= wp_sprintf( __( '<h2>Total view : 0' ) );
        }
    }
    
    /**
     * wd_dpvc_set_post_view
     * Increment number of single post visit
     * @return void
     */
    public function wd_dpvc_set_post_view() {
        $key = 'post_views_count';
        if( is_single() ) {
            $post_id = get_the_ID();
            $count = (int) get_post_meta( $post_id, $key, true );
            $count++;
            update_post_meta( $post_id, $key, $count );
        }
    }
}