<?php

namespace Book\Reviews;

/**
 * Class Wd_Ajax
 */
class Wd_Ajax {
	/**
	 * Class constructore
	 */
	public function __construct() {
		add_action( 'wp_ajax_book_review', [ $this, 'wd_store_book_review' ] );
	}

	/**
	 * Store book review
	 *
	 * @return void
	 */
	public function wd_store_book_review() {
		global $wpdb;

		if ( ! wp_verify_nonce( $_POST['nonce'], 'wd-book-review' )){
			wp_send_json_error( array( 'message' => __("Nonce is invalid", 'wd-book-reviews') ) );
		}

		$data = [
			'post_id' => $_POST['id'],
			'rating'  => $_POST['rating'],
		];

		$insert_id = wdbr_insert_review( $data );

		if ( is_wp_error( $insert_id ) ) {
			wp_send_json_error( array( 'message' => __( $insert_id->get_error_message() , 'wd-book-reviews' ) ) );
		}

		wp_send_json_success( array( 'message' => __( 'Thanks for your review' , 'wd-book-reviews' ) ) );
	}
}