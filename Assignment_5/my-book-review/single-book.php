<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

/* Start the Loop */
while ( have_posts() ) :
	the_post();
	$id = get_the_ID();
	$writer_name = get_post_meta( $id, 'book_writer_name', true );
	$edition_number = get_post_meta( $id, 'book_edition_number', true );
	$publishers = get_post_meta( $id, 'book_publishers', true );
	$isbn_number = get_post_meta( $id, 'book_isbn_number', true );
	$price = get_post_meta( $id, 'price', true );

	?>
	<div>
		<p><?php esc_html_e( $writer_name )?></p>
		<p><?php esc_html_e( $edition_number )?></p>
		<p><?php esc_html_e( $publishers )?></p>
		<p><?php esc_html_e( $isbn_number )?></p>
		<p><?php esc_html_e( $price )?></p>
	</div>
<?php
endwhile; // End of the loop.

get_footer();