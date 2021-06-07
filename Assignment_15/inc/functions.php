<?php

/**
 * Insert a student into db
 * 
 * @param array $args
 * 
 * @return int|WP_Error
 */
function wsi_insert_student( $args = [] ) {
    global $wpdb;

    if ( empty( $args['first_name'] ) || empty( $args['last_name'] ) || empty( $args['s_class'] ) || empty( $args['roll'] ) || empty( $args['reg_no'] ) ) {
        return new \WP_Error( 'field-required', __( 'You must provide a value into required fields.', 'we-student-info' ) );
    }

    $defaults = [
        'first_name' => '',
        'last_name'  => '',
        's_class'    => '',
        'roll'       => '',
        'reg_no'     => '',
        'created_at' => current_time( 'mysql' ),
    ];

    $data = wp_parse_args( $args, $defaults );

    if ( ! isset( $data['id'] ) ) {
        $inserted = $wpdb->insert(
            $wpdb->prefix . 'students',
            $data,
            [
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
            ]
        );

        if ( ! $inserted ) {
            return new \WP_Error( 'faild-to-insert-student', __( 'Failed to insert student data', 'we-student-info' ) );
        }

        return $wpdb->insert_id;
    } else {
        $id = $data['id'];
        unset( $data['id'] );

        $updated = $wpdb->update(
            $wpdb->prefix . 'students',
            $data,
            [ 'id' => $id ],
            [
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
            ],
            [ '%d' ]
        );

        return $updated;
    }
}

/**
 * Fetch all students
 *
 * @param  array  $args
 *
 * @return array
 */
function wsi_get_all_students( $args = [] ) {
    global $wpdb;

    $defaults = [
        'number'  => 20,
        'offset'  => 0,
        'orderby' => 'id',
        'order'   => 'DESC'
    ];

    $args = wp_parse_args( $args, $defaults );

    $last_changed = wp_cache_get_last_changed( 'students' );
    $key          = md5( serialize( array_diff_assoc( $args, $defaults ) ) );
    $cache_key    = "all:$key:$last_changed";

    $sql = $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}students
            ORDER BY {$args['orderby']} {$args['order']}
            LIMIT %d, %d",
            $args['offset'], $args['number']
    );

    $items = wp_cache_get( $cache_key, 'students' );

    if ( false === $items ) {
        $items = $wpdb->get_results( $sql );

        wp_cache_set( $cache_key, $items, 'students' );
    }

    return $items;
}

/**
 * Get the count of total students
 *
 * @return int
 */
function wsi_students_count() {
    global $wpdb;

    $count = wp_cache_get( 'student_count', 'students' );

    if ( false === $count ) {
        $count = (int) $wpdb->get_var( "SELECT count(id) FROM {$wpdb->prefix}students" );

        wp_cache_set( 'student_count', $count, 'students' );
    }

    return $count;
}