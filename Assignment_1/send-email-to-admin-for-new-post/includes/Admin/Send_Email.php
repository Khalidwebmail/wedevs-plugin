<?php

namespace Send\Email\Admin;

/**
 * Class Send_Email
 * @package Send\Email\Admin
 */

class Send_Email {

	/**
	 * Send_Email constructor.
	 */
	public function __construct() {
		add_action( 'publish_post', [ $this, 'wd_se_send_email_to_admin' ], 10, 2 );
	}

	/**
	 * send_email_to_admin
	 * Send email when new post will save or publish
	 * @param  mixed $post_id
	 * @param  mixed $post
	 * @return void
	 */
	public function wd_se_send_email_to_admin( $post_id, $post ) {
		$args = [ 'role'  => 'administrator' ];
		$users = get_users( $args );
		foreach( $users as $user) {
			$to[] = $user->user_email;
		}

		$status = '';
		$admin_username = get_the_author_meta( 'nicename', $post->post_author );
		$subject = "Post Published: ". $post->post_title ."";
		if( 'publish' === get_post_status( $post_id ) ) {
			$status = 'published';
		}

		$message = "
		Hi ". $admin_username .",
		
		Your post, \"". $post->post_title ."\" has just been $status.
		
		View post: ". get_permalink( $post_id ) ."
		
		Thanks";
		wp_mail( $to, $subject, $message );
	}
}