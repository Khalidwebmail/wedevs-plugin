<?php

namespace Display\Post\View\Frontend;

class Counter {
    
    public function __construct() {
        add_filter( 'the_content', [ $this, 'dpvc_get_post_view' ] );
        add_filter( 'the_post', [ $this, 'dpvc_set_post_view' ] );
    }

	public function dpvc_get_post_view($content) {
	    $count = get_post_meta( get_the_ID(), 'post_views_count', true );
	    if( $count > 0) {
			$tag = apply_filters( 'pb_tag', 'em' );
			return $content .= sprintf( __( '<h2>Total View : <%s>%s</%s></h2>' ), $tag, $count, $tag );
		}
		else{
			return $content .= sprintf( __( '<h2>Total View : 0' ) );
		}
	}

	public function dpvc_set_post_view() {

	    $key = 'post_views_count';
	    if( is_single() ) {
	    	$post_id = get_the_ID();
	    	$count = (int) get_post_meta( $post_id, $key, true );
			$count++;
		    update_post_meta( $post_id, $key, $count );
	    }
	}
}

