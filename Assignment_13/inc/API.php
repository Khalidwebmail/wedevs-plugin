<?php

namespace WdRestApi;

use WdRestApi\API\Contactform;

/**
 * API class
 */
class API {
    /**
     * Class constructor
     */
    public function __construct() {
        add_action( 'rest_api_init', [ $this, 'register_contact_api' ] );
    }

    /**
     * Register all apis
     * 
     * @return void
     */
    public function register_contact_api() {
        $contactform = new Contactform();
        $contactform->register_routes();
    }
}