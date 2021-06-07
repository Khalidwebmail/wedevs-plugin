<?php


namespace User\Role\Frontend;

/**
 * Class User_Registration
 * @package User\Role\Frontend
 */
class User_Registration {
	/**
	 * Initialize the class
	 *
	 */
	function __construct() {
		add_shortcode( 'urc-registration-form', [ $this, 'urc_render_user_registration_form' ] );
	}

	/**
	 * Shortcode render function
	 *
	 * @since 1.0.0
	 *
	 * @param [type] $atts
	 * @param string $content
	 *
	 * @return void
	 */
	public function urc_render_user_registration_form( $atts , $content ='' ) {
		if (  isset( $_POST[ 'send_shortcode' ] ) ) {

			if ( ! wp_verify_nonce( $_POST[ '_wpnonce' ], 'urc_nonce_from' ) ) {
				wp_die(  __( 'Aru you Cheating nonce', 'user-role-capability' ) );
			}

			$uname      = isset( $_REQUEST['uname'] ) ?  sanitize_text_field( $_REQUEST['uname'] )    : '';
			$email      = isset( $_REQUEST['email'] ) ?  sanitize_email( $_REQUEST['email'] )               : '';
			$password   = isset( $_REQUEST['password'] ) ? trim( $_REQUEST['password'] )                    : '';
			$capability = isset( $_REQUEST['capability'] ) ? $_REQUEST['capability']                        : '';

			$userdata   =  [
				'user_login'    => $uname,
				'user_email'    => $email,
				'user_pass'     => $password,
				'first_name'    => $uname,
				'role'          => 'customer_role',
			];

			$user_id = wp_insert_user( $userdata );
			
			if ( is_wp_error( $user_id ) ) {
				echo __( 'Sorry, Something went wrong !', 'user-role-capability' );
			} else {
				$user = get_user_by( 'ID', $user_id );

				switch ( $capability ) {
					case 'wholesale':
						$data = [
							'edit_posts'        => true,
							'edit_users'        => true,
							'upload_plugins'    => true,
							'edit_others_posts' => true,
							'publish_posts'     => true,
							'read'              => true,
						];

						foreach ( $data as $key => $value ) {
							$user->add_cap( $key, $value );
						}
						break;

					case 'retail':
						$data = [
							'edit_posts'        => true,
							'edit_others_posts' => true,
							'publish_posts'     => true,
							'read'              => true,
						];

						foreach ( $data as $key => $value ) {
							$user->add_cap( $key, $value );
						}
						break;

					default:
						$data = [
							'publish_posts' => true,
							'read'          => true,
						];

						foreach ( $data as $key => $value ) {
							$user->add_cap( $key, $value );
						}
						break;
				}
				echo __( 'Data inserted successfull', 'user-roles-and-capabilities' );
			}
		}

		// Template loaded
		$template = __DIR__ . '/views/user_signup.php';

		if ( file_exists( $template ) ) {
			include $template;
		}
	}
}