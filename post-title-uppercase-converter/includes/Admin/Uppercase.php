<?php

namespace Post\Title\Admin;

class Uppercase {

    public function __construct() {
        add_filter( 'wp_insert_post_data', [ $this, 'title_uppercase' ] );
    }

    public function title_uppercase( $post ) {
        if( 'post' != $post[ 'post_type' ]) {
            return $post;
        }
        else{ 
            $post[ 'post_title' ] = ucwords( $post[ 'post_title']);
            return apply_filters( 'modify_post_title', $post );
        }
    }
}