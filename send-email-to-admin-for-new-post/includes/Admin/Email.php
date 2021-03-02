<?php

namespace Send\Admin;

use WP_Query;

class Email {

	/**
	 * Class Constructor
	 */
	public function __construct()
	{
		add_action('save_post', [ $this, 'send_email_to_admin' ], 10, 2);
		add_action('publish_post', [ $this, 'send_email_to_admin' ], 10, 2);
	}
	
	/**
	 * seta_send_email
	 *
	 * @return void
	 */
	public function send_email_to_admin( $post_id, $post ) {
		$status = '';
		$to = get_option( 'admin_email' );
		$admin_username = get_the_author_meta( 'nicename', $post->post_author );
		$subject = "Post Published: ".$post->post_title."";
 		if( get_post_status( $post_id ) === 'draft' ) {
			$status = 'saved';
		}
		if( get_post_status( $post_id ) === 'publish' ) {
			$status = 'published';
		}

		$message = "
		Hi ".$admin_username.",
		
		Your post, \"".$post->post_title."\" has just been $status.
		
		View post: ".get_permalink( $post_id )."
		
		Thanks";
   		wp_mail( $to, $subject, $message );
	}
}