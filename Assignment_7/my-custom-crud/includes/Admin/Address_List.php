<?php

namespace My\Crud\Admin;

if( ! class_exists( 'WP_List_Table' )) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Address_List extends \WP_List_Table {
	/**
	 * __construct
	 * Pass some paramemeter using parent constructor
	 * @return void
	 */
	public function __construct() {
		parent::__construct( [
			'singular'  => 'contact',
			'plural'    => 'contacts',
			'ajax'      => false,
		] );
	}

	/**
	 * get_columns
	 * Get column name from database
	 * @return array
	 */
	public function get_columns() {
		return [
			'cb'          => '<input type="checkbox">',
			'name'        => __( 'User Name', 'wedevs-crud' ),
			'email'       => __( 'Email', 'wedevs-crud' ),
			'phone'       => __( 'Cell', 'wedevs-crud' ),
			'address'     => __( 'Address', 'wedevs-crud' ),
			'created_by'  => __( 'Created By', 'wedevs-crud' ),
			'created_at'  => __( 'Created Time', 'wedevs-crud' ),
		];
	}

	/**
	 * column_default
	 * Show data to table
	 * @param  mixed $item
	 * @param  mixed $column_name
	 * @return void
	 */
	protected function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'email':
				return esc_html( $item->email );

			case 'phone':
				return esc_html( $item->phone );

			case 'address':
				return esc_html( $item->address );

			case 'created_by':
				return "Username";

			case 'created_at':
				return wp_date( get_option( 'date_format' ), strtotime( $item->created_at ) );

			default:
				return isset( $item->column_name ) ? $item->column_name : '';
		}
	}

	/**
	 * column_name
	 *
	 * @param  mixed $item
	 * @return void
	 */
	public function column_name( $item ) {
		$actions = [];

		$actions['edit']   = sprintf( '<a href="%s" title="%s">%s</a>', admin_url( 'admin.php?page=wedevs-crud&action=edit&id=' . $item->id ), $item->id, __( 'Edit', 'wedevs-crud' ), __( 'Edit', 'wedevs-crud' ) );
		$actions['delete'] = sprintf( '<a href="%s" class="submitdelete" onclick="return confirm(\'Are you sure?\');" title="%s">%s</a>', wp_nonce_url( admin_url( 'admin-post.php?action=wd-ac-delete-address&id=' . $item->id ), 'wd-ac-delete-address' ), $item->id, __( 'Delete', 'wedevs-crud' ), __( 'Delete', 'wedevs-crud' ) );
		error_log(print_r($actions, 1));
		return wp_sprintf( '<a href="%1$s"><strong>%2$s</strong></a>%3$s', admin_url( 'admin.php?page=wedevs-crud&action=view&id' . $item->id ), $item->name, $this->row_actions( $actions )
		);
	}

	/**
	 * get_sortable_columns
	 * Select which columns we will for doing sorting
	 * @return void
	 */
	public function get_sortable_columns() {
		$sortable_columns = [
			'name'       => [ 'name', true ],
			'created_at' => [ 'created_at', true ],
		];

		return $sortable_columns;
	}
	/**
	 * prepare_items
	 *
	 * @return void
	 */
	public function prepare_items() {
		$column   = $this->get_columns();
		$hidden   = [];
		$sortable = $this->get_sortable_columns();
		$this->_column_headers =  [ $column, $hidden, $sortable ];
		$per_page = 20;
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
		$this->items = wd_ac_get_address( $args );
		$this->set_pagination_args( [
			'total_items' => wd_ac_count_address(),
			'per_page'    => $per_page
		] );
	}

	/**
	 * Message to show if no designation found
	 *
	 * @return void
	 */
	public function no_items() {
		_e( 'No address found', 'wedevs-crud' );
	}
}