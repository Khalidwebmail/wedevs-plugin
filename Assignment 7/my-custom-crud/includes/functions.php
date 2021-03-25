<?php

/**
 * wd_ac_insert_address
 * Use to insert data to table
 * @param  array  $args
 * @return int|WP_Error
 */
function wd_ac_insert_address( $args = [] ) {
    global $wpdb;

    if( empty( $args[ 'name' ] ) ) {
        return new \WP_Error( 'no-name', __( 'The name field is required' ), 'wedevs-cruds' );
    }

    if( empty( $args[ 'email' ] ) ) {
        return new \WP_Error( 'no-email', __( 'The email field is required' ), 'wedevs-cruds' );
    }

    if( empty( $args[ 'phone' ] ) ) {
        return new \WP_Error( 'no-phone', __( 'The phone field is required' ), 'wedevs-cruds' );
    }

    if( empty( $args[ 'address' ] ) ) {
        return new \WP_Error( 'no-address', __( 'The address field is required' ), 'wedevs-cruds' );
    }

    $default = [
        'name'         => '',
        'email'        => '',
        'phone'        => '',
        'address'      => '',
        'created_by'   => get_current_user_id(),
        'created_at'   => current_time( 'mysql' ),
    ];

    $data = wp_parse_args( $args, $default );

    if( isset( $data[ 'id' ] ) ) {
        $id = $data[ 'id' ];
        unset( $data[ 'id' ] );
        $updated = $wpdb->update(
            $wpdb->prefix.'ac_addresses',
            $data,
            [ 'id' => $id ],
            [
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s'
            ],
            [ '%d' ]
        );
        return $updated;
    }

    $inserted = $wpdb->insert( 
        "{$wpdb->prefix}ac_addresses",
        $data,
        [
            '%s',
            '%s',
            '%s',
            '%s',
            '%d',
            '%s'
        ]
    );

    if( ! $inserted) {
        return new \WP_Error( 'failed-to-insert', __( 'Failed to insert' ), 'wedevs-cruds' );
    }
    return $wpdb->insert_id;
}

/**
 * wd_ac_get_address
 * Get number of address from database
 * @param  mixed $args
 * @return $items
 */
function wd_ac_get_address( $args = [] ) {
    global $wpdb;

    $defaults = [
        'number'       => 20,
        'offset'       => 0,
        'orderby'      => 'id',
        'order'        => 'ASC'
    ];

    $args = wp_parse_args( $args, $defaults );
    $items = $wpdb->get_results( 
        $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}ac_addresses
            ORDER BY {$args['orderby']} {$args['order']}
            LIMIT %d, %d",
            $args[ 'offset' ],
            $args[ 'number' ],
        ) );
    return $items;
}

/**
 * wd_ac_count_address
 * Count number of rows
 * @return int
 */
function wd_ac_count_address() {
    global $wpdb;
    return (int) $wpdb->get_var( "SELECT count( id ) FROM {$wpdb->prefix}ac_addresses" );
}

/**
 * wd_ac_get_single_address
 * Fetch single address by id
 * @param  int $id
 * @return object
 */
function wd_ac_get_single_address( $id ) {
    global $wpdb;
    return $wpdb->get_row(
        $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}ac_addresses WHERE id = %d", $id )
    );
}

/**
 * wd_ac_delete_address
 *
 * @param  mixed $id
 * @return int|bool
 */
function wd_ac_delete_address( $id ) {
    global $wpdb;

    return $wpdb->delete(
        $wpdb->prefix.'ac_addresses',
        [ 'id' => $id ],
        [ '%d' ]
    );
}