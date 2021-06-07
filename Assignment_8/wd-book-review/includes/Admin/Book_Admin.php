<?php

namespace Book\Reviews\Admin;

/**
 * Class Book_Admin
 * @package Book\Reviews\Admin
 */
class Book_Admin {
	/**
	 * Class constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'wd_create_book_cpt' ) );
		add_action( 'init', array( $this, 'wd_create_book_taxonomy' ) );
		add_action( 'add_meta_boxes', array( $this, 'wd_add_book_meta_box' ) );
		add_action( 'save_post', array( $this, 'wd_save_book_meta_info') );
	}

	/**
	 * Registers a new post type book
	 *
	 * @return void
	 */
	public function wd_create_book_cpt() {
		$labels = [
			'name'               => __( 'Books', 'wd-book-reviews' ),
			'singular_name'      => __( 'Book', 'wd-book-reviews' ),
			'all_items'          => __( 'All Books' ),
			'add_new'            => _x( 'Add New Book', 'wd-book-reviews', 'wd-book-reviews' ),
			'add_new_item'       => __( 'Add New Book', 'wd-book-reviews' ),
			'edit_item'          => __( 'Edit Book', 'wd-book-reviews' ),
			'new_item'           => __( 'New Book', 'wd-book-reviews' ),
			'view_item'          => __( 'View Book', 'wd-book-reviews' ),
			'search_items'       => __( 'Search Book', 'wd-book-reviews' ),
			'not_found'          => __( 'No Book found', 'wd-book-reviews' ),
			'not_found_in_trash' => __( 'No Book found in Trash', 'wd-book-reviews' ),
			'parent_item_colon'  => __( 'Parent Book:', 'wd-book-reviews' ),
			'menu_name'          => __( 'Books', 'wd-book-reviews' ),
		];

		$args = [
			'label'               => __('Books', 'book-review'),
			'labels'              => $labels,
			'description'         => "",
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'has_archive'         => "books",
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'delete_with_user'    => false,
			'exclude_from_search' => false,
			'capability_type'     => "post",
			'map_meta_cap'        => true,
			'hierarchical'        => false,
			'rewrite'             => true,
			'query_var'           => true,
			'menu_icon'           => 'dashicons-book',
			'supports'            => [ 'title', 'editor', 'thumbnail' ],
			'taxonomies'          => array('category'),
		];

		register_post_type( 'book', $args );
	}

	/**
	 * Create subject taxonomy for the post type "book"
	 *
	 * @return void
	 */
	public function wd_create_book_taxonomy() {
		$labels = [
			'name'                  => _x( 'Subjects', 'Subjects', 'wd-book-reviews' ),
			'singular_name'         => _x( 'Subject', 'Subject', 'wd-book-reviews' ),
			'search_items'          => __( 'Search Subjects', 'wd-book-reviews' ),
			'popular_items'         => __( 'Popular Subjects', 'wd-book-reviews' ),
			'all_items'             => __( 'All Subjects', 'wd-book-reviews' ),
			'parent_item'           => __( 'Parent Subject', 'wd-book-reviews' ),
			'parent_item_colon'     => __( 'Parent Subject', 'wd-book-reviews' ),
			'edit_item'             => __( 'Edit Subject', 'wd-book-reviews' ),
			'update_item'           => __( 'Update Subject', 'wd-book-reviews' ),
			'add_new_item'          => __( 'Add New Subject', 'wd-book-reviews' ),
			'new_item_name'         => __( 'New Subject Name', 'wd-book-reviews' ),
			'add_or_remove_items'   => __( 'Add or remove Subjects', 'wd-book-reviews' ),
			'choose_from_most_used' => __( 'Choose from most used Subjects', 'wd-book-reviews' ),
			'menu_name'             => __( 'Subjects', 'wd-book-reviews' ),
		];

		$args = [
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_admin_column' => false,
			'hierarchical'      => true,
			'show_tagcloud'     => true,
			'show_ui'           => true,
			'query_var'         => true,
			'rewrite'           => true,
			'query_var'         => true,
			'capabilities'      => array(),
		];

		register_taxonomy( 'subject', [ 'book' ], $args );
	}

	/**
	 * Add custom meta fields inside
	 * custom post type book
	 *
	 * @return void
	 */
	public function wd_add_book_meta_box() {
		add_meta_box(
			'book_meta',
			__( 'Others Information', 'post-excerpt' ),
			[ $this, 'wd_render_book_meta_box' ],
			'book'
		);
	}

	/**
	 * Displying book meta box inseide book
	 *
	 * @return void
	 */
	public function wd_render_book_meta_box( $post_id ){
		$writter   = get_post_meta( $post_id->ID, 'wdbr_writter', true );
		$isbn      = get_post_meta( $post_id->ID, 'wdbr_isbn', true );
		$language  = get_post_meta( $post_id->ID, 'wdbr_language', true );
		$publisher = get_post_meta( $post_id->ID, 'wdbr_publisher', true );

		wp_nonce_field( 'book_nonce', 'book_nonce_field' );

		include __DIR__ . '/views/book-meta-info.php';
	}

	/**
	 * Seving post excerpt if doesnot exists,
	 * otherwise update existing
	 *
	 * @param  int $post_id
	 *
	 * @return void
	 */
	public function wd_save_book_meta_info( $post_id ) {
		if ( ! $this->wd_is_secured( 'book_nonce_field', 'book_nonce', $post_id ) ) {
			return false;
		}

		$writter   = isset( $_POST['writter'] ) ? sanitize_textarea_field( wp_unslash( $_POST['writter'] ) ) : "";
		$isbn      = isset( $_POST['isbn'] ) ? sanitize_textarea_field( wp_unslash( $_POST['isbn'] ) ) : "";
		$language  = isset( $_POST['language'] ) ? sanitize_textarea_field( wp_unslash( $_POST['language'] ) ) : "";
		$publisher = isset( $_POST['publisher'] ) ? sanitize_textarea_field( wp_unslash( $_POST['publisher'] ) ) : "";

		if ( "" !== $writter ) {
			update_post_meta( $post_id, 'wdbr_writter', $writter );
		}

		if ( "" !== $isbn ) {
			update_post_meta( $post_id, 'wdbr_isbn', $isbn );
		}

		if ( "" !== $language ) {
			update_post_meta( $post_id, 'wdbr_language', $language );
		}

		if ( "" !== $publisher ) {
			update_post_meta( $post_id, 'wdbr_publisher', $publisher );
		}
	}

	/**
	 * Check nonce and capabilty
	 *
	 * @param  string  $nonce_field
	 * @param  string  $action
	 * @param  int  $post_id
	 *
	 * @return boolean
	 */
	private function wd_is_secured( $nonce_field, $action, $post_id ) {
		$nonce = isset( $_POST[ $nonce_field ] ) ? $_POST[ $nonce_field ] : "";

		// checking nonce is valid
		if ( ! wp_verify_nonce( $nonce, $action )) {
			return false;
		}

		// checking current user has permission to edit post
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return false;
		}

		return true;
	}
}