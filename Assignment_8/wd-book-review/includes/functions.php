<?php

/**
 * Insert or update address
 *
 * @param  array  $args
 *
 * @return int|WP_Error
 */
function wdbr_insert_review( $args = [] ) {
	global $wpdb;

	$defaults = [
		'post_id'    => 0,
		'user_id'    => get_current_user_id(),
		'ip'         => wd_get_the_user_ip(),
		'rating'     => 0,
		'created_at' => current_time( 'mysql' ),
	];

	$data = wp_parse_args( $args, $defaults );

	$inserted = $wpdb->insert(
		"{$wpdb->prefix}book_review_rating",
		$data,
		[
			'%d',
			'%d',
			'%s',
			'%d',
			'%s',
		],
    );

	if ( ! $inserted ) {
		return new \WP_Error( 'filed-to-insert', __( 'Failed to insert data' , 'wd-book-reviews' ) );
	}

	return $wpdb->insert_id;
}

/**
 * Calculate average rating for given post
 *
 * @param  int
 *
 * @return int
 */
function wd_get_avg_rating( $post_id ) {
	global $wpdb;

	$avg_rating = ( int ) $wpdb->get_var( "SELECT AVG(rating) FROM {$wpdb->prefix}book_review_rating  WHERE post_id=$post_id");

	return $avg_rating;
}

/**
 * Check user already submitted review
 *
 * @param  int
 * @param  int
 *
 * @return boolean
 */
function wd_is_review_exist( $post_id, $user_id ) {
	global $wpdb;

	$review = (bool) $wpdb->get_var( "SELECT count(id) FROM {$wpdb->prefix}book_review_rating  WHERE post_id=$post_id AND user_id=$user_id");

	return $review;
}

/**
 * Get user ip address
 *
 * @return string
 */
function wd_get_the_user_ip() {
	if ( ! empty( $_SERVER[ 'HTTP_CLIENT_IP' ] ) ) {
		$ip = $_SERVER[ 'HTTP_CLIENT_IP' ];
	} elseif ( ! empty( $_SERVER[ 'HTTP_X_FORWARDED_FOR' ] ) ) {
		$ip = $_SERVER[ 'HTTP_X_FORWARDED_FOR' ];
	} else {
		$ip = $_SERVER[ 'REMOTE_ADDR' ];
	}
	return $ip;
}


/**
 * Get class for rating star.
 *
 * @param int|float $rating
 * @param int $forStar
 * @return string
 */
function wd_rating_star_class( $rating, $forStar ) {
	$class = $rating >= $forStar ? 'fa fa-star selected' : 'fa fa-star';

	if ( fmod ( $rating, 1 ) === 0.0 ) {
		return $class;
	}

	if ( is_float( $rating ) && ceil( $rating ) === ( float ) $forStar ) {
		$class = 'fa fa-star-half-full';
	}

	return $class;
}
