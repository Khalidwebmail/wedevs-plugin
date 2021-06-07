<?php

namespace Related\Post;

/**
 * Class Related_Post_Wiget
 * @package Related\Post
 */
class Related_Post_Widget extends \WP_Widget {
	/**
	 * Class constructor
	 */
	public function __construct() {
		parent::__construct(
			'show-related-post',
			__( 'Show Related Post Widget', 'show-related-post' ),
			[ 'description' => __( 'Display related posts only on single post', 'show-related-post' ) ]
		);
	}

	/**
	 * Render frontend for widget
	 *
	 * @param array $args
	 * @param array $instance
	 *
	 * @return void
	 */
	public function widget( $args, $instance ) {
		global $post;

		if ( is_single() ):
			echo $args[ 'before_widget' ];

			if ( ! empty( $instance[ 'srp_title' ] ) ) {
				echo $args[ 'before_title' ] . apply_filters( 'widget_title', __( $instance[ 'srp_title' ], 'show-related-post' ) ) . $args[ 'after_title' ];
			}

			echo '<div class="textwidget">';

			$no_of_posts = ( ! empty( $instance['srp_no_of_posts'] ) ) ? sanitize_text_field( $instance[ 'srp_no_of_posts' ] ) : 5;
			$post_order  = ( ! empty( $instance['srp_order'] ) ) ? sanitize_text_field( $instance[ 'srp_order' ] ) : 'DESC';

			$categories    = get_the_category( $post->ID );
			$category_name = [];

			foreach( $categories as $category ) {
				$category_name[] = $category->slug;
			}

			$category_name = implode( ',', $category_name );

			$query_args = [
				'post_type'      => 'post',
				'post_status'    => 'publish',
				'posts_per_page' => $no_of_posts,
				'post__not_in'   => [ $post->ID ],
				'category_name'  => $category_name,
				'orderby'        => 'ID',
				'order'          => $post_order,
			];

			$the_query = new \WP_Query( $query_args );

			if ( $the_query->have_posts() ) {
				while( $the_query->have_posts() ) {
					$the_query->the_post();

					printf(
						"<p><a href='%s'>%s</a></p>",
						get_the_permalink(),
						get_the_title()
					);
				}
			}

			echo '</div>';

			echo $args[ 'after_widget' ];

		endif;
	}

	/**
	 * Render settings form
	 *
	 * @param array $instance
	 *
	 * @return void
	 */
	public function form( $instance ) {
		$title       = ( ! empty( $instance['srp_title'] ) ) ? esc_attr( $instance['srp_title'] ) : '';
		$no_of_posts = ( ! empty( $instance['srp_no_of_posts'] ) ) ? esc_attr( $instance['srp_no_of_posts'] ) : '';
		$order       = ( ! empty( $instance['srp_order'] ) ) ? esc_attr( $instance['srp_order'] ) : '';

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'srp_title' ) ); ?>"><?php echo esc_html_e( 'Title:', 'show-related-post' ); ?></label>
			<input name='<?php echo esc_attr( $this->get_field_name( 'srp_title' ) ); ?>' id="<?php echo esc_attr( $this->get_field_id( 'srp_title' ) ); ?>" type="text" class="widefat title" value='<?php echo esc_attr( $title ); ?>'>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'srp_no_of_posts' ) ); ?>"><?php echo esc_html_e( 'No of posts', 'show-related-post' ); ?></label>
			<input name='<?php echo esc_attr( $this->get_field_name( 'srp_no_of_posts' ) ); ?>' id="<?php echo esc_attr( $this->get_field_id( 'srp_no_of_posts' ) ); ?>" type="text" class="widefat title" value='<?php echo esc_attr( $no_of_posts ); ?>'>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'srp_order' ) ); ?>"><?php echo esc_html_e( 'Order', 'show-related-post' ); ?></label>
			<select class='widefat' name="<?php echo esc_attr( $this->get_field_name( 'srp_order' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'srp_order' ) ); ?>">
				<option selected="selected" value="">Select order</option>
				<option value="ASC" <?php selected( 'ASC' === $order, 1 ); ?>>ASC</option>
				<option value="DESC" <?php selected( 'DESC' === $order, 1 ); ?>>DESC</option>
			</select>
		</p>
		<?php
	}

	/**
	 * Update form data
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = [];

		$instance['srp_title']       = ( isset( $new_instance['srp_title'] ) ) ? sanitize_text_field( $new_instance['srp_title'] ) : '';
		$instance['srp_no_of_posts'] = ( isset( $new_instance['srp_no_of_posts'] ) ) ? sanitize_text_field( $new_instance['srp_no_of_posts'] ) : '';
		$instance['srp_order']       = ( isset( $new_instance['srp_order'] ) ) ? sanitize_text_field( $new_instance['srp_order'] ) : '';

		return $instance;
	}
}