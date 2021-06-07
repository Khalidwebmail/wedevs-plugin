<?php

namespace WdRestApi;

/**
 * Admin menu class
 */
class Adminmenu {
    /**
     * Class contructor
     * 
     * @return void
     */
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'register_admin_menu' ] );
    }

    /**
     * Register admin menu
     * 
     * @return void
     */
    public function register_admin_menu() {
        add_menu_page( 
            __( 'We Rest Contacts', 'we-rest-api' ), 
            __( 'We Rest Contacts', 'we-rest-api' ), 
            'manage_options', 
            'werest_menu', 
            [ $this, 'render_menu_page' ], 
            'dashicons-editor-ol'
        );

        add_submenu_page( 
            'werest_menu', 
            __( 'Contacts', 'we-rest-api' ), 
            __( 'Contacts', 'we-rest-api' ), 
            'manage_options', 
            'werest_menu', 
            [ $this, 'render_menu_page' ]
        );
    }

    /**
     * Render menu
     * 
     * @return void
     */
    public function render_menu_page() {
        echo "<div class='wrap'>";

        printf( "<h1>%s</h1>", __( 'We Contacts', 'we-rest-api' ) );

        $template = WE_REST_PLUGIN_PATH . '/assets/templates/contact-template.php';

        if ( file_exists( $template ) ) {
            include $template;
        }
        
        echo "</div>";
    }
}