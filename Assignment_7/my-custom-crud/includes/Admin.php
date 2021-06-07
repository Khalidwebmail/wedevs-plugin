<?php

namespace My\Crud;

use My\Crud\Admin\Addressbook;

/**
 * The Admin class
 */

class Admin {

	/**
	 * Hold instentiate of this class
	 */
	private $address_book;

	/**
	 * __construct
	 * Define construct
	 * @return void
	 */
	public function __construct()
	{
		$this->address_book = new Addressbook();
		$this->dispatch_action();
		new Admin\Menu( $this->address_book );
	}

	/**
	 * dispatch_action
	 * Use to submit form and delete address
	 * @return void
	 */
	public function dispatch_action() {
		add_action( 'admin_init', [ $this->address_book, 'form_handler' ], 10, 1 );
		add_action( 'admin_post_wd-ac-delete-address', [ $this->address_book, 'delete_address' ], 10, 1 );
	}
}