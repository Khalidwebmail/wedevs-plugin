<?php

namespace Post\Title\Admin;

class Title_Uppercase {
	public function __construct() {
		add_action( 'wp_insert_post_data', [ $this, 'wd_tuc_uppercase_title' ] );
	}

	/**
	 * wd_tuc_uppercase_title
	 * Convert title
	 * @param  object $post
	 * @return $post
	 */
	public function wd_tuc_uppercase_title( $post ) {
		if( 'post' !== $post[ 'post_type' ] ) {
			return $post;
		}
		else{
			$post[ 'post_title' ] = ucwords( $post[ 'post_title' ] );
			return $post;
		}
	}
}