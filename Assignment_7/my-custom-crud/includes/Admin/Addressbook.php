<?php

namespace My\Crud\Admin;

use My\Crud\Traits\Form_Error;

/**
 * Addressbook
 */
class Addressbook {

	use Form_Error;
	/**
	 * plugin_page
	 * Load view page respect of request
	 * @return void
	 */
	public function plugin_page() {
		$action = isset( $_REQUEST[ 'action' ] ) ? $_REQUEST[ 'action' ] : 'list';
		$id = isset( $_REQUEST[ 'id' ] ) ? intval( $_GET[ 'id' ] ) : 0;

		switch( $action ) {
			case 'new':
				$template = __DIR__ . '/views/address-new.php';
				break;

			case 'edit':
				$address = wd_ac_get_single_address( $id );
				$template = __DIR__ . '/views/address-edit.php';
				break;

			case 'view':
				$template = __DIR__ . '/views/address-view.php';
				break;

			default:
				$template = __DIR__ . '/views/address-list.php';
				break;
		}

		if( file_exists( $template ) ) {
			include_once $template;
		}
	}

	/**
	 * form_handler
	 * Handle form when submited
	 * @return void
	 */
	public function form_handler() {
		if( ! isset( $_REQUEST[ 'submit_address' ] ) ) {
			return;
		}

		if( ! wp_verify_nonce( $_REQUEST [ '_wpnonce' ], 'new-address' ) ) {

			die( 'You are not eligible to submit the form');

		}

		if( ! current_user_can( 'manage_options' )) {
			die( 'You are not eligible to submit the form');
		}

		$id = isset( $_REQUEST[ 'id' ] ) ? intval( $_REQUEST [ 'id' ] ) : 0;

		$name    = isset( $_REQUEST[ 'name' ] ) ? sanitize_text_field( $_REQUEST[ 'name' ] ) : '';
		$email   = isset( $_REQUEST[ 'email' ] ) ? sanitize_text_field( $_REQUEST[ 'email' ] ) : '';
		$phone   = isset( $_REQUEST[ 'phone' ] ) ? sanitize_text_field( $_REQUEST[ 'phone' ] ) : '';
		$address = isset( $_REQUEST[ 'address' ] ) ? sanitize_textarea_field( $_REQUEST[ 'address' ] ) : '';

		if( empty( $name ) ) {
			$this->errors[ 'name' ] = __( 'The name field is required', 'wedevs-crud' );
		}

		if( empty( $email ) ) {
			$this->errors[ 'email' ] = __( 'The email field is required', 'wedevs-crud' );
		}

		if( empty( $phone ) ) {
			$this->errors[ 'phone' ] = __( 'The phone field is required', 'wedevs-crud' );
		}

		if( empty( $address ) ) {
			$this->errors[ 'address' ] = __( 'The address field is required', 'wedevs-crud' );
		}

		if( ! empty( $this->errors ) ) {
			return;
		}
		$args = [
			'name'      => $name,
			'email'     => $email,
			'phone'     => $phone,
			'address'   => $address
		];

		if( $id ) {
			$args[ 'id' ] = $id;
		}

		$insert_id = wd_ac_insert_address( $args );

		if( is_wp_error( $insert_id ) ) {
			wp_die( $insert_id->get_error_message() );
		}

		if( $id ) {
			$redirect_to = admin_url( 'admin.php?page=wedevs-crud&action=edit&address-updated=true&id=' . $id );
		}
		$redirect_to = admin_url( 'admin.php?page=wedevs-crud&inserted=true' );
		wp_redirect( $redirect_to );
	}

	/**
	 *
	 */
	public function delete_address() {
		if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'wd-ac-delete-address' ) ) {
			die( 'Are you cheating?' );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			die( 'Are you cheating?' );
		}

		$id = isset( $_REQUEST[ 'id' ] ) ? intval( $_REQUEST[ 'id' ] ) : 0;

		if ( wd_ac_delete_address( $id ) ) {
			$redirect_to = admin_url( 'admin.php?page=wedevs-crud&address-deleted=true' );
		} else {
			$redirect_to = admin_url( 'admin.php?page=wedevs-crud&address-deleted=false' );
		}

		wp_redirect( $redirect_to );
		exit;
	}
}