<?php

namespace Contact\Form\Admin;

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * Address list handler class
 */
class Contact_List extends \WP_List_Table {
    
    /**
     * Class constructor
     */
    public function __construct() {
        parent::__construct( array(
            'singular' => 'contact',
            'plural'   => 'contacts',
            'ajax'     => false,
        ) );
    }

    /**
     * Define renderable coumns
     * 
     * @return array
     */
    public function get_columns() {
        return array(
            'cb'         => '<input type="checkbox" />',
            'name'       => _( 'Name', 'contact-form' ),
            'email'      => _( 'Email', 'contact-form' ),
            'message'    => _( 'Message', 'contact-form' ),
            'created_at' => _( 'Date', 'contact-form' ),
        );
    }

    /**
     * Define sort able columns
     * 
     * @return array
     */
    public function get_sortable_columns() {
        $sortable_columns = array(
            'name'       => array( 'name', true ),
            'created_at' => array( 'created_at', true ),
        );

        return $sortable_columns;
    }

    public function get_bulk_actions() {
        $actions = array( 'delete' => 'Delete' );
        
        return $actions;
    }

    public function no_items() {
        _e( 'No address found.', 'address-book');
    }

    /**
     * Prepare items for render
     * 
     * @return void
     */
    public function prepare_items() {
        $column   = $this->get_columns();
        $hidden   = [];
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array( $column, $hidden, $sortable );

        $per_page     = 20;
        $current_page = $this->get_pagenum();
        $offset       = ($current_page - 1) * $per_page;

        $args = [
            'per_page' => $per_page,
            'offset'   => $offset
        ];

        if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
            $args['orderby'] = $_REQUEST['orderby'];
            $args['order']   = $_REQUEST['order'];
        }
        
        $this->items = wpcf_get_messages( $args );

        $this->set_pagination_args([
            'total_items' => wpcf_message_count(),
            'per_page'    => $per_page
        ]);
    }

    /**
     * check column has value if doesn't return empty
     * 
     * @param  string $item
     * @param  string $column_name
     * 
     * @return string
     */
    public function column_default( $item, $column_name ) {
        return isset( $item->$column_name ) ? $item->$column_name : '';
    }

    /**
     * Manke name column click able and add
     * edit and delete option
     * 
     * @param object $item
     * 
     * @return string
     */
    public function column_name( $item ) {
        return sprintf(
            '<a href="%1$s"><strong>%2$s</strong></a>', admin_url( 'admin.php?page=contact-messages&action=view&id='. $item->id ), $item->name 
        );
    }

    /**
     * Define checkbox for each row
     * 
     * @param  object $item
     * 
     * @return string
     */
    public function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="message_id" value="%d"/>',
            $item->id
        );
    }

}