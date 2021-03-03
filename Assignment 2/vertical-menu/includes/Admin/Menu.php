<?php

namespace Vertical\Admin;

class Menu {

    public function __construct() 
    {
        add_action('admin_menu', [$this, 'menu_manager']);
    }    
    /**
     * menu_manager
     * Add menu in admin section
     * @return void
     */
    public function menu_manager()
    {
        add_menu_page( __("Vertical Menu", 'vertical-menu'), __('Vertical Menu', 'vertical-menu'),'manage_options', 'vertical-menu', [$this, 'customize_menu_text'], 'dashicons-edit');
    }
    
    /**
     * customize_menu_text
     * Change menu text
     * @return void
     */
    public function customize_menu_text() 
    {
        require_once __DIR__.'/views/edit-menu-text.php';
    }
}