<?php

namespace Contact\Form\Frontend;

/**
 * Contact form hander
 */
class Shortcode {

    /**
     * Class constructor
     */
    public function __construct() {
        add_shortcode( 'contact-form', array( $this, 'create_contact_form' ) );
    }

    /**
    * Creating custom contact form
    *
    * @return string
    */
    public function create_contact_form() {
        wp_enqueue_style( 'custom-style' );
        wp_enqueue_script( 'jquery-validation' );
        wp_enqueue_script( 'custom-script' );

        ob_start();
        include __DIR__ . '/views/contact.php';

        return ob_get_clean();
    }
}