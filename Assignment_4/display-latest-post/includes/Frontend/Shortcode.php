<?php


namespace Post\View\Frontend;

/**
 * Class Shortcode
 * @package Post\View\Frontend
 */
class Shortcode {
	/**
	 * class initialization
	 */
	public function __construct()
	{
		add_shortcode( 'latest-post-view-number', [ $this, 'render_shortcode' ] );
	}

	/**
	 * shortcode header class
	 *
	 * @param  array $atts
	 * @return mixed
	 */
	public function render_shortcode( $atts )
	{
		$atts = shortcode_atts(
			[
				'posts_per_page' => 10,
				'category_name'  => '',
				'post_id'        => '',
				'post_type'      => 'post',
				'order'          => 'DESC',
				'post_status'    => 'publish',
			], $atts );

		$ids = $atts[ 'post_id' ];
		$cat = $atts[ 'category_name' ];

		if( '' !== $ids ) {

			$atts[ 'post__in' ] = explode( ',', $ids );
			$the_query = new \WP_Query( $atts );

			if( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					echo '<a style="color: darkorange" href=" '. get_permalink() .' "><h5 class="entry-title">'. get_the_title().' ( '.$the_query->post->post_views_count.' )</h5></a>';
				}
				wp_reset_postdata();
			}
		}

		if( '' == $ids ) {
			$the_query = new \WP_Query( $atts );
			if( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					echo '<a style="color: darkorange" href=" '. get_permalink() .' "><h5 class="entry-title">'. get_the_title().' ( '.$the_query->post->post_views_count.' )</h5></a>';
				}
				wp_reset_postdata();
			}
		}

		if( '' !== $cat ) {
			$atts[ 'post__in' ] = explode( ',', $cat );
			$the_query = new \WP_Query( $atts );
			if( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					echo '<a style="color: darkorange" href=" '. get_permalink() .' "><h2 class="entry-title">'. get_the_title().' ( '.$the_query->post->post_views_count.' )</h2></a>';
				}
				wp_reset_postdata();
			}
		}
	}
}