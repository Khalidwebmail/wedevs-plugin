<?php

namespace Contact\Form\Admin;

/**
 * Menu handler class
 */
class Contact_Messages {

    /**
     * Class constructor
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    /**
     * Register admin menu
     * 
     * @return void
     */
    public function admin_menu() {
        add_menu_page( __( 'Contact Messages', 'contact-form' ), __( 'Contact Messages', 'contact-form' ), 'manage_options', 'contact-messages', array( $this, 'plugin_page' ), 'dashicons-admin-comments' );

    }

    /**
     * Contact lists page
     * 
     * @return void
     */
    public function plugin_page() {
       include __DIR__ . '/views/contact-list.php';
    }

}