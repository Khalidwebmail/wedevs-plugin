<?php

/**
 * Insert or update address
 * 
 * @param  array  $args
 * 
 * @return int|WP_Error
 */
function wpcf_insert_message( $args = [] ) {
    global $wpdb;

    $defaults = array(
        'name'       => '',
        'email'      => '',
        'message'    => '',
        'ip'         => get_the_user_ip(),
        'created_at' => current_time( 'mysql' ),
    );

    $data = wp_parse_args( $args, $defaults );

    $inserted = $wpdb->insert(
        "{$wpdb->prefix}contact_messages",
        $data,
        [
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
        ],
    );

    if ( ! $inserted ) {
        return new \WP_Error( 'filed-to-insert', __( 'Failed to insert data' , 'book-reviews' ) );
    }

    set_transient( 'last_changed', microtime(), DAY_IN_SECONDS );
    return $wpdb->insert_id;
}

/**
 * Get address
 * 
 * @return Object
 */
function wpcf_get_messages( $args = [] ) {
    global $wpdb;

    $defaults = [
        'per_page'  => 20,
        'offset'  => 0,
        'orderby' => 'id',
        'order'   => 'DESC'
    ];

    $key = md5( serialize( array_diff_assoc( $args, $defaults ) ) );
    $last_changed = get_transient( 'last_changed' );
    $cache_key = "contact_messages:$key:$last_changed";
    $items = get_transient( $cache_key );

    if ( false === $items ) {
        $args = wp_parse_args( $args, $defaults );

        $sql = $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}contact_messages
            ORDER BY {$args['orderby']} {$args['order']}
            LIMIT %d, %d",
            $args['offset'], $args['per_page']
        );

        $items = $wpdb->get_results( $sql );
        set_transient( $cache_key, $items,  HOUR_IN_SECONDS );
    }

    return $items;
}

/**
 * Fetch the count of total addresses
 * @return int
 */
function wpcf_message_count() {
    global $wpdb;

    $count = get_transient( 'wpcf_message_count' );

    if ( false === $count ) {
        $count = (int) $wpdb->get_var( "SELECT count(id) FROM {$wpdb->prefix}contact_messages");
        set_transient( 'wpcf_message_count', $count,  HOUR_IN_SECONDS );

    }

    return $count;
}


/**
 * Get user ip address
 * 
 * @return string
 */
function get_the_user_ip() {
    if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
        //check ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
        //to check ip is pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}