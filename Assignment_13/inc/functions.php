<?php

/**
 * Insert form data to database
 * 
 * @param array $args
 * 
 * @return int|object
 */
function we_rest_insert_form_data( $args = [] ) {
    global $wpdb;
    
    if ( empty( $args['name'] ) || empty( $args['email'] ) || empty( $args['message'] ) ) {
        return new \WP_Error( 'field-empty', __( 'You must fill all field.', 'we-contact-form' ) );
    }

    $defaults = [
        'name'       => '',
        'email'      => '',
        'message'    => '',
        'created_at' => current_time( 'mysql' ),
    ];

    $data = wp_parse_args( $args, $defaults );

    if ( ! isset( $data['id'] ) ) {
        $inserted = $wpdb->insert(
            $wpdb->prefix . "wcfn_contact",
            $data,
            [
                '%s',
                '%s',
                '%s',
                '%s'
            ]
        );
    
        if ( ! $inserted ) {
            return new \WP_Error( 'failed-to-insert', __( 'Failed to insert data', 'we-contact-form' ) );
        }
    
        return $wpdb->insert_id;
    } else {
        $id = $data['id'];
        unset( $data['id'] );

        $updated = $wpdb->update(
            $wpdb->prefix . "wcfn_contact",
            $data,
            [ 'id' => $id ],
            [
                '%s',
                '%s',
                '%s',
                '%s'
            ],
            [ '%d' ]
        );

        return $updated;
    }

}

/**
 * Get all contacts
 * 
 * @param array $args
 * 
 * @return object
 */
function we_rest_get_contacts_list( $args = [] ) {
    global $wpdb;

    $defaults = [
        'number'  => 20,
        'offset'  => 0,
        'orderby' => 'id',
        'order'   => 'ASC'
    ];

    $args = wp_parse_args( $args, $defaults );

    $sql = $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}wcfn_contact
            ORDER BY {$args['orderby']} {$args['order']}
            LIMIT %d, %d",
            $args['offset'], $args['number']
    );

    $items = $wpdb->get_results( $sql );

    return $items;
}

/**
 * Get contact by email
 * 
 * @param string $email
 * 
 * @return int|object
 */
function we_rest_get_contact_by_email( $email ) {
    global $wpdb;

    return $wpdb->get_row(
        $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wcfn_contact WHERE email = %s", $email )
    );
}

/**
 * Get the count of total contacts
 * 
 * @return int
 */
function we_rest_total_constacts_count() {
    global $wpdb;

    return (int) $wpdb->get_var( "SELECT count(id) FROM {$wpdb->prefix}wcfn_contact" );
}

/**
 * Fetch a single contact
 * 
 * @param int $id
 * 
 * @return object
 */
function we_rest_get_contact_by_id( $id ) {
    global $wpdb;

    return $wpdb->get_row(
        $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wcfn_contact WHERE id = %d", $id )
    );
}

/**
 * Delete a single contact
 *
 * @param  int $id
 *
 * @return int|boolean
 */
function we_rest_delete_contact( $id ) {
    global $wpdb;

    return $wpdb->delete(
        $wpdb->prefix . 'wcfn_contact',
        [ 'id' => $id ],
        [ '%d' ]
    );
}