<?php

namespace Book\Reviews\Frontend;

/**
 * Class Book_Frontend
 * @package Book\Reviews\Frontend
 */
class Book_Frontend {
	/**
	 * Class constructor
	 */
	public function __construct() {
		add_filter( 'template_include', array( $this, 'wd_load_template' ) );
	}

	/**
	 * load custom template if post type is book
	 * otherwise default template
	 *
	 * @return string
	 */
	public function wd_load_template( $template ) {
		$post_id   = get_the_ID();
		$writter   = get_post_meta( $post_id, 'wdbr_writter', true );
		$isbn      = get_post_meta( $post_id, 'wdbr_isbn', true );
		$language  = get_post_meta( $post_id, 'wdbr_language', true );
		$publisher = get_post_meta( $post_id, 'wdbr_publisher', true );

		// For all other CPT
		if ( 'book' !== get_post_type( $post_id ) ) {
			return $template;
		}

		// Else use custom template
		if ( is_single() && locate_template('single-book.php' ) ) {
			return $template;
		}
		else {
			include __DIR__ . '/views/single-book.php';
		}
	}
}