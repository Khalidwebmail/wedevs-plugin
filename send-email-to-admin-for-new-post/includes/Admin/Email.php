<?php

namespace Send\Admin;

class Email {

	/**
	 * Class Constructor
	 */
	public function __construct()
	{
		add_action('publish_post', [ $this, 'send_email_to_admin' ]);
		add_action('save_post', [ $this, 'send_email_to_admin' ]);
	}
	
	/**
	 * seta_send_email
	 *
	 * @return void
	 */
	public function send_email_to_admin( $post_id ) {
		$post = get_post($post_id);
		$admin = get_option( 'admin_email' );
		error_log($admin);
		$subject = "Post Published: ".$post->post_title."";
		error_log($post->post_title)."\n";
		$message = "
		Hi ".$admin->display_name.",
		
		Your post, \"".$post->post_title."\" has just been published.
		
		View post: ".get_permalink( $post_id )."
		
		Thanks";
		error_log($message);
   		wp_mail( get_option( 'admin_email' ), $subject, $message );
	}
}