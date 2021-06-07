<?php

namespace WdRestApi;

/**
 * Contact List class
 */
class We_Contact_List extends \WP_List_Table {
    /**
     * Class constructor
     * 
     * @return void
     */
    public function __construct() {
        parent::__construct( [
            'singular' => 'contact',
            'plural'   => 'contacts',
            'ajax'     => false,
        ] );
    }

    /**
     * Message to show if no item found
     * 
     * @return void
     */
    public function no_items() {
        echo __( 'No contacts found', 'we-contact-form' );
    }

    /**
     * Get the column names
     * 
     * @return array
     */
    public function get_columns() {
        return [
            'cb'         => '<input type = "checkbox" />',
            'name'       => __( 'Name', 'we-contact-form' ),
            'email'      => __( 'Email', 'we-contact-form' ),
            'message'    => __( 'Message', 'we-contact-form' ),
            'created_at' => __( 'Date', 'we-contact-form' ),
        ];
    }

    /**
     * Get sortable columns
     * 
     * @return array
     */
    public function get_sortable_columns() {
        $sortable_columns = [
            'name'       => [ 'name', true ],
            'created_at' => [ 'created_at', true ],
        ];

        return $sortable_columns;
    }

    /**
     * Set the bulk actions
     *
     * @return array
     */
    function get_bulk_actions() {
        $actions = array(
            'trash'  => __( 'Move to Trash', 'we-contact-form' ),
        );

        return $actions;
    }    

    /**
     * Default coloums value
     * 
     * @param object $item
     * @param string $column_name
     * 
     * @return string
     */
    protected function column_default( $item, $column_name ) {
        switch( $column_name ) {
            case 'created_at':
                return wp_date( get_option( 'date_format' ), strtotime( $item->created_at ) );

            default:
                return isset( $item->$column_name ) ? $item->$column_name : '';
        }
    }

    /**
     * Render the cb column
     * 
     * @param object $item
     * 
     * @return string
     */
    protected function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="contact_id[]" value="%d" />', $item->id
        );
    }

    /**
     * Prepare the contact items
     * 
     * @return void
     */
    public function prepare_items() {
        $column   = $this->get_columns();
        $hidden   = [];
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = [ $column, $hidden, $sortable ];
        
        $per_page     = 20;
        $current_page = $this->get_pagenum();
        $offset       = ( $current_page - 1 ) * $per_page;

        $args = [
            'number' => $per_page,
            'offset' => $offset,
        ];
        
        if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
            $args['orderby'] = $_REQUEST['orderby'];
            $args['order']   = $_REQUEST['order'] ;
        }

        $this->items = wcfn_get_contacts_list( $args );

        $this->set_pagination_args( [
            'total_items' => wcfn_total_constacts_count(),
            'per_page'    => $per_page
        ] );        
    }
}