<?php

namespace Book\Review\Admin;

/**
 * Class decleration
 */
class Book_Information {

	/**
	 * Define constructor
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'wd_br_book' ] );
		add_filter( 'manage_book_posts_columns', [ $this, 'wp_br_add_column_to_table' ] );
		add_action( 'manage_book_posts_custom_column', [ $this, 'wp_br_book_column_data' ], 10, 2 );
		add_filter( 'manage_edit-book_sortable_columns', [ $this, 'wp_br_sort_custom_column' ] ) ;
	}

	/**
	 * wd_br_book
	 * Create a button on admin side bar
	 * $labels array
	 * $args array
	 * @return void
	 */
	public function wd_br_book() {
		$labels = [
			'name'               => __('Books', 'my-book-review'),
			'singular_name'      => __('Book', 'my-book-review'),
			'menu_name'          => __('Books', 'my-book-review'),
			'name_admin_bar'     => __('Book', 'my-book-review'),
			'add_new'            => __('Add New', 'my-book-review'),
			'add_new_item'       => __('Add New Book', 'my-book-review'),
			'new_item'           => __('New Book', 'my-book-review'),
			'edit_item'          => __('Edit Book', 'my-book-review'),
			'view_item'          => __('View Book', 'my-book-review'),
			'all_items'          => __('All Books', 'my-book-review'),
			'search_items'       => __('Search Books', 'my-book-review'),
			'not_found'          => __('No Books found.', 'my-book-review'),
			'not_found_in_trash' => __('No Books found in Trash.', 'my-book-review')
		];

		$args = [
			'public'                => true,
			'hierarchical'          => true,
			'publicly_queryable'    => true,
			'query_var'             => true,
			'labels'                => $labels,
			'menu_icon'             => 'dashicons-book-alt',
			'rewrite'               => [ 'slug' => 'book' ],
			'capability_type'       => 'post',
			'supports'              => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ]
		];
		register_post_type( 'book', $args );
		register_taxonomy_for_object_type( 'category', 'book' );
	}

	/**
	 * wp_br_add_column_to_table
	 * Add custom column in table
	 * @param  array $columns
	 * @return array $columns
	 */
	public function wp_br_add_column_to_table( $columns ) {
		$columns = [
			'cb'                => '<input type="checkbox">',
			'title'             => __( 'Book Name', 'my-book-review' ),
			'categories'        => __( 'Categories', 'my-book-review' ),
			'writer_name'       => __( 'Writer Name', 'my-book-review' ),
			'edition_number'    => __( 'Edition', 'my-book-review' ),
			'publishers'        => __( 'Publishers Name', 'my-book-review' ),
			'isbn_num'          => __( 'ISBN Number', 'my-book-review' ),
			'price'             => __( 'Price', 'my-book-review' ),
			'date'              => __( 'Date', 'my-book-review' )
		];
		return $columns;
	}

	/**
	 * wp_br_book_column_data
	 * Show data from database to table
	 * @param  mixed $columns
	 * @param  mixed $post_id
	 * @return void
	 */
	public function wp_br_book_column_data( $columns, $post_id ) {
		switch ( $columns ) {
			case 'writer_name':
				$writer_name = get_post_meta( $post_id, 'book_writer_name', true );
				echo $writer_name;
				break;

			case 'edition_number':
				$edition_number = get_post_meta( $post_id, 'book_edition_number', true );
				echo $edition_number;
				break;

			case 'publishers':
				$publishers = get_post_meta( $post_id, 'book_publishers', true );
				echo $publishers;
				break;

			case 'isbn_num':
				$isbn_num = get_post_meta( $post_id, 'book_isbn_number', true );
				echo $isbn_num;
				break;

			case 'price':
				$price = get_post_meta( $post_id, 'book_price', true );
				echo $price;
				break;
		}
	}

	/**
	 * wp_br_sort_custom_column
	 * Add sorting system on our custom column
	 * @param  mixed $columns
	 * @return $columns
	 */
	public function wp_br_sort_custom_column( $columns ) {
		$columns['writer_name'] = "writer-name";
		$columns["publishers"]  = "publishers-name";
		$columns["categories"]  = "categories";

		return $columns;
	}
}