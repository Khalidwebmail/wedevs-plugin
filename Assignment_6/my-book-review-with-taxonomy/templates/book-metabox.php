<?php
global $post;

$post_id        = $post->ID;
$author         = '';
$publisher      = '';
$edition        = '';
$language       = '';
$price          = '';
$summery        = '';
$rating         = '';
$book_data_keys = [
	'author',
	'publisher',
	'edition',
	'language',
	'price',
	'summery',
	'rating',
];

foreach ( $book_data_keys as $key ) {
	$$key = get_post_meta( $post_id, 'my_book_'.$key, true );
}
?>

<style>
    .review-input-table,
    .review-input-table input,
    textarea {
        width: 100%;
    }
</style>
<table class="review-input-table">
	<tr align="right">
		<td>
			<label for="author"><?php _e( 'Author Name', 'my-book-review' ); ?>:</label>
		</td>
		<td>
			<input type="text" name="author" id="author" value="<?php esc_html_e( $author ); ?>">
		</td>
		<td>
			<label for="publisher"><?php _e( 'Publisher', 'my-book-review' ); ?>:</label>
		</td>
		<td>
			<input type="text" name="publisher" id="publisher" value="<?php esc_html_e( $publisher ); ?>">
		</td>
		<td>
			<label for="publisher"><?php _e( 'Rating', 'my-book-review' ); ?>:</label>
		</td>
		<td>
			<input type="number" min="0" max="5" name="rating" id="rating" placeholder="between 0 to 5" value="<?php esc_html_e( $rating ); ?>">
		</td>
	</tr>
	<tr align="right">
		<td>
			<label for="edition"><?php _e( 'Edition', 'sh-book-review' ); ?>:</label>
		</td>
		<td>
			<input type="text" name="edition" id="edition" value="<?php esc_html_e( $edition ); ?>">
		</td>
		<td>
			<label for="language"><?php _e( 'Language', 'sh-book-review' ); ?>:</label>
		</td>
		<td>
			<input type="text" name="language" id="language" value="<?php esc_html_e( $language ); ?>">
		</td>
		<td>
			<label for="price"><?php _e( 'Price', 'sh-book-review' ); ?>:</label>
		</td>
		<td>
			<input type="number" name="price" id="price" value="<?php esc_html_e( $price ); ?>">
		</td>
	</tr>
	<tr align="right">
		<td>
			<label for="summery"><?php _e('Book Summery', 'sh-book-review'); ?>:</label>
		</td>
		<td colspan="5">
			<textarea name="summery" id="summery" cols="30" rows="10"><?php esc_html_e( $summery ); ?></textarea>
		</td>
	</tr>
</table>