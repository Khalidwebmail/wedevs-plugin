<?php

namespace Book\Review\Frontend;

/**
 * Shortcode class decleration
 */
class Shortcode {
	/**
	 * __construct
	 * Define constructor
	 * @return void
	 */
	public function __construct() {
		add_shortcode( 'my-search-form', [ $this, 'render_shortcode' ] );
	}

	/**
	 * render_shortcode
	 * Main shortcode which will show form
	 * @param  mixed $atts
	 * @return void
	 */
	public function render_shortcode( $atts ) {
		$atts = shortcode_atts( array(
			'title' => 'Search here',
		), $atts );
		$s = '';
		$result = '';

		if( isset( $_GET[ 'search' ] )) {
			$s = $_GET[ 'search' ];
			$args = array(
				'post_type' => 'book',
				'meta_query' => array(
					'relation' => 'OR',
					array(
						'key' => 'book_publishers',
						'value'    => $s,
						'compare'    => 'LIKE',
					),
					
					array(
						'key' => 'book_writer_name',
						'value'    => $s,
						'compare'    => 'LIKE',
					),
					array(
						'key' => 'book_isbn_number',
						'value'    => $s,
						'compare'    => 'LIKE',
					),
				),
			);
			$result = new \WP_Query($args);
		}
		?>
		<h2><?php echo $atts[ 'title' ]?></h2>
		<form role="search" method="get" class="search-form">
			<label>
				<span class="screen-reader-text">Search for:</span>
				<input type="text" class="search-field" placeholder="Search …" name="search">
			</label>
			<input type="submit" class="search-submit" value="Search">
		</form>
		<?php

		if( empty($result) ) {
			return;
		}

		echo '<ol>';
		while ( $result->have_posts() ) {
			$result->the_post();
			printf( '<p><img src="%s" height="150" width="150" /><a href="%s">%s</a></p>', get_the_post_thumbnail_url( get_the_ID(), 'full' ), get_the_permalink(), get_the_title() );
		}
		echo '</ol>';
		wp_reset_query();
	}
}