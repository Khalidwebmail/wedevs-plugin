<?php
/**
 * Plugin Name:       Email Notification After Publish Post
 * Plugin URI:        https://example.com/
 * Description:       Send an email after publishing new post.
 * Version:           1.0.0
 * Author:            Khalid Ahmed.
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       email-notification-after-publish-post
 * Domain Path:       /languages/
 */

if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin Base class
 */
final class Posts_Email_Notification {
	/**
	 * Plugin version
	 *
	 * @var string VERSION
	 */
	const VERSION = '1.0.0';

	/**
	 * class construct
	 *
	 * @return void
	 */
	private function __construct() {
		$this->define_constants();

		register_activation_hook( __FILE__, [ $this, 'activate' ] );
		register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );

		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );

		add_action( 'transition_post_status', array ( $this, 'pen_send_email' ), 10, 3 );
	}

	/**
	 * Run plugin functionality
	 *
	 * @return void
	 */
	public function init_plugin() {
		add_action( 'wepen_cron_hook', [ $this, 'wepen_cron_exec' ] );
	}

	/**
	 * Send email to admin with daily publish post report
	 *
	 * @return void
	 */
	public function wepen_cron_exec() {
		$today = getdate();

		$args = [
			'post_type'     => 'post',
			'post_status'   => 'publish',
			'date_query'    => [
				[
					'year'  => $today['year'],
					'month' => $today['mon'],
					'day'   => $today['mday'],
				]
			]
		];

		$query = new \WP_Query( $args );

		$total_posts = $query->posts;
		$posts_count = $query->post_count;

		$post_titles = [];

		if ( ! empty( $total_posts ) ) {
			foreach( $total_posts as $post ) {
				$post_titles[] = $post->post_title;
			}
		}

		$to        = get_option( 'admin_email' );
		$subject   = "Published post notice for today";
		$message   = "Hello Admin, <br><br>";
		$message  .= "Congratulations, Here are the title of the posts have been added today. <br><br>";
		$headers   = [ 'Content-Type: text/html; charset = UTF-8' ];

		if( ! empty( $post_titles ) ) {
			$count = 1;
			foreach( $post_titles as $title ) {
				$message .= "{$count}) {$title} <br>";
				$count++;
			}
		}
		$message .= "<br> The total number of new posts published today is {$posts_count}. <br>";
		$message .= "Thank you";

		wp_mail( $to, $subject, $message, $headers );
	}

	/**
	 * Send email to admin
	 *
	 * @param string $new_status
	 * @param string $old_status
	 * @param object $post
	 *
	 * @return void
	 */
	public function pen_send_email( $new_status, $old_status, $post ) {
		if ( 'publish' === $new_status && 'publish' !== $old_status && 'post' === $post->post_type ) {
			//get admin email
			$email_lists = array( get_option( 'admin_email' ) );

			// get username of the author
			$username    = get_the_author_meta( 'nicename', $post->post_author );

			$to          = apply_filters( 'pen_modify_user_email', $email_lists );

			$subject     = $post->post_title;

			$message     = "Hello {$username}, <br> A new post is published. Please review your post. <br> Thanks";

			wp_mail( $to, $subject, $message );
		}
	}

	/**
	 * Send email to admin daily with all posts publish details
	 */

	/**
	 * Define necessary constants
	 *
	 * @return void
	 */
	public function define_constants() {
		define( 'WEPEN_VERSION', self::VERSION );
		define( 'WEPEN_PATH', __DIR__ );
		define( 'WEPEN_FILE', __FILE__ );
		define( 'WEPEN_URL', plugins_url( '', WEPEN_FILE ) );
		define( 'WEPEN_ASSETS', WEPEN_URL . '/assets' );
	}

	/**
	 * Do stuff during plugin activation
	 *
	 * @return void
	 */
	public function activate() {
		$installed = get_option( 'wepen_installed' );

		if ( ! $installed ) {
			update_option( 'wepen_installed', time() );
		}

		update_option( 'wepen_version', WEPEN_VERSION );

		if ( ! wp_next_scheduled( 'wepen_cron_hook' ) ) {
			wp_schedule_event( time(), 'daily', 'wepen_cron_hook' );
		}
	}

	/**
	 * Remove the plugin schedules
	 *
	 * @return void
	 */
	public function deactivate() {
		$timestamp = wp_next_scheduled( 'wepen_cron_hook' );
		wp_unschedule_event( $timestamp, 'wepen_cron_hook' );
	}

	/**
	 * Singleton instance
	 *
	 * @return \Posts_Email_Notification
	 */
	public static function init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}
}

/**
 * Plugin bootstrap function
 *
 * @return \Posts_Email_Notification
 */
function posts_email_notification_boot() {

	return Posts_Email_Notification::init();
}

// start the plugin
posts_email_notification_boot();