<?php

namespace Recent\Posts;

/**
 * Dashboard class
 */
class Dashboard {
    /**
     * Class constructor
     * 
     * @return void
     */
    public function __construct() {
        add_action( 'wp_dashboard_setup', [ $this, 'register_dashboard' ] );
    }

    /**
     * Register dashboard widget
     * 
     * @return void
     */
    public function register_dashboard() {
        wp_add_dashboard_widget( 
            'we_recent_posts', 
            __( 'We Recent Posts', 'wd-recent-posts' ),
            [ $this, 'display_dashboard' ]
        );
    }

    /**
     * Display Dashboard
     * 
     * @return void
     */
    public function display_dashboard() {
        wp_enqueue_script( 'wrp-main' );

        $categories      = get_categories();

        $wrp_no_of_posts = get_option( 'wrp_no_of_posts' );
        $wrp_order       = get_option( 'wrp_order' );
        $wrp_category    = get_option( 'wrp_category_items' );

        $category_items  = $wrp_category;

        error_log( print_r( $category_items, 1 ) );

        $no_of_posts   = ( ! empty( $wrp_no_of_posts ) ) ? $wrp_no_of_posts : 5;
        $order         = ( ! empty( $wrp_order ) ) ? $wrp_order : '';
        $category_name = ( ! empty( $wrp_category ) ) ? implode( ',', $wrp_category ) : '';

        $args = [
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => $no_of_posts,
            'orderby'        => 'ID',
            'order'          => $order,
            'category_name'  => $category_name,
        ];

        $the_query = new \WP_Query( $args );

        include WRP_PATH . '/assets/templates/dashboard-template.php';
    }
}