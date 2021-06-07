<?php

namespace Author\Bio;

/**
 * Class Wd_Author
 * @package Author\Bio
 */
class Wd_Author {
	/**
	 * Class constructor
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'wdab_register_style' ] );

		add_filter( 'user_contactmethods', [ $this, 'wdab_add_social_profile' ] );

		add_filter( 'the_content', [ $this, 'wdab_add_author_box' ], 21 );
	}

	/**
	 * Add user social profile
	 *
	 * @param string[] $methods
	 *
	 * @return void
	 */
	public function wdab_add_social_profile( $methods ) {
		$methods['twitter']  = __( 'Twitter', 'we-author-box' );
		$methods['github']   = __( 'Github', 'we-author-box' );
		$methods['linkedin'] = __( 'LinkedIn', 'we-author-box' );

		return $methods;
	}

	/**
	 * Display Author box under post
	 *
	 * @param string $content The post content
	 *
	 * @return string
	 */
	public function wdab_add_author_box( $content ) {
		global $post;

		wp_enqueue_style( 'profile-style' );


		$author        = get_user_by( 'id', $post->post_author );

		$display_name  = $author->data->display_name;
		$author_avatar = esc_url( get_avatar_url( $author->ID ) );

		$twitter       = get_the_author_meta( 'twitter', $author->ID );
		$twitter       = ( ! empty ( $twitter ) ) ? esc_url( $twitter ) : '#';

		$github        = get_the_author_meta( 'github', $author->ID );
		$github        = ( ! empty ( $github ) ) ? esc_url( $github ) : '#';

		$linkedin      = get_the_author_meta( 'linkedin', $author->ID );
		$linkedin      = ( ! empty ( $linkedin ) ) ? esc_url( $linkedin ) : '#';

		ob_start();

		if ( is_single() ) {
			include WDAB_PATH.'/assets/templates/author-template.php';
		}

		$html = ob_get_clean();

		return $content . $html;
	}

	/**
	 * Register style
	 *
	 * @return void
	 */
	public function wdab_register_style() {
		wp_register_style( 'profile-style', plugins_url( 'assets/css/profile-style.css', __FILE__ ), [ 'fontawesome-profile-style' ] );
		wp_register_style( 'fontawesome-profile-style', plugins_url( 'assets/css/font-awesome.min.css', __FILE__ ) );
	}
}