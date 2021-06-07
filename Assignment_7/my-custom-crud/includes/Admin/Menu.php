<?php

namespace My\Crud\Admin;

class Menu {

	/**
	 * __construct
	 * Define construct
	 * @param  object $address_book
	 * @return void
	 */
	public function __construct( $address_book ) {
		$this->address_book = $address_book;
		add_action( 'admin_menu', [ $this, 'my_admin_menu' ] );
	}

	/**
	 * my_admin_menu
	 * Add custom admin menu
	 * @return void
	 */
	public function my_admin_menu() {
		add_menu_page( __( 'weDevs CRUD', 'wedevs-crud' ), __( 'Addressbook', 'wedevs-crud' ),'manage_options', 'wedevs-crud', [ $this, 'address_book_page' ], 'dashicons-welcome-learn-more' );
	}

	/**
	 * address_book_page
	 * Load view respect of request
	 * @return void
	 */
	public function address_book_page() {
		$this->address_book->plugin_page();
	}
}