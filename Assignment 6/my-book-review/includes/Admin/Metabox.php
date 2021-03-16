<?php

namespace Book\Review\Admin;

class Metabox {   
    /**
     * Assign variables use to get single value of book meta
     */
    private $name;
    private $edition;
    private $publishers;
    private $isbn;
    private $price;

    /**
     * __construct
     * 
     * @return void
     */
    public function __construct() {
        add_action( 'add_meta_boxes', [ $this, 'wd_br_register_book_metabox' ] );
        add_action( 'save_post', [ $this, 'wp_br_save_book_meta_info' ] );
    }
    
    /**
     * wd_br_register_book_metabox
     * Create box heading
     * @return void
     */
    public function wd_br_register_book_metabox() {

        add_meta_box( 'book-id', 'Additional Information', [ $this, 'wd_br_book_details' ], 'book', 'side', 'high' );
    }
    
    /**
     * wd_br_book_details
     * Create html form to take input
     * @param  mixed $post
     * @return void
     */
    public function wd_br_book_details( $post ) {
        $this->name         = get_post_meta( $post->ID, 'book_writer_name', true );
        $this->edition      = get_post_meta( $post->ID, 'book_edition_number', true );
        $this->publishers   = get_post_meta( $post->ID, 'book_publishers', true );
        $this->isbn         = get_post_meta( $post->ID, 'book_isbn_number', true );
        $this->price        = get_post_meta( $post->ID, 'book_price', true );
    
        ?>
        <form method="post" action="">
            <div class="wrap">
                <p>
                    <input type="text" name="writer_name" placeholder="Writer name" autocomplete="off" value="<?php esc_html_e($this->name) ?>">
                </p>

                <p>
                    <input type="text" name="edition_number" placeholder="Edition number" autocomplete="off" value="<?php esc_html_e($this->edition) ?>">
                </p>

                <p>
                    <input type="text" name="publishers" placeholder="Publisher name" autocomplete="off" value="<?php esc_html_e($this->publishers) ?>">
                </p>

                <p>
                    <input type="text" name="isbn_num" placeholder="ISBN number" autocomplete="off" value="<?php esc_html_e($this->isbn) ?>">
                </p>

                <p>
                    <input type="text" name="price" placeholder="Price" autocomplete="off" value="<?php esc_html_e($this->price) ?>">
                </p>
            </div>
        </form>
    <?php
    }

    /**
     * wp_br_save_book_meta_info
     * Save meta info to database
     * @param  mixed $post_id
     * @return void
     */
    public function wp_br_save_book_meta_info( $post_id ) {
        $writer_name    = isset( $_POST[ 'writer_name' ] ) ? $_POST[ 'writer_name' ] : '';
        $edition_number = isset( $_POST[ 'edition_number' ] ) ? $_POST[ 'edition_number' ] : '';
        $publishers     = isset( $_POST[ 'publishers' ] ) ? $_POST[ 'publishers' ] : '';
        $isbn_num       = isset( $_POST[ 'isbn_num' ] ) ? $_POST[ 'isbn_num' ] : '';
        $price          = isset( $_POST[ 'price' ] ) ? $_POST[ 'price' ] : '';

        update_post_meta( $post_id, 'book_writer_name', sanitize_text_field( $writer_name ) );
        update_post_meta( $post_id, 'book_edition_number', sanitize_text_field( $edition_number ) );
        update_post_meta( $post_id, 'book_publishers', sanitize_text_field( $publishers ) );
        update_post_meta( $post_id, 'book_isbn_number', sanitize_text_field( $isbn_num ) );
        update_post_meta( $post_id, 'book_price', sanitize_text_field( $price ) );
    }
}