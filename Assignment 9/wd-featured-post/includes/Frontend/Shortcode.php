<?php

namespace Post\Frontend;

class Shortcode {
    public function __construct() {
        add_shortcode( 'wd-feature-post', [ $this, 'wd_render_shortcode' ] );
    }

    /**
     * Render shortcode
     * 
     * @return string
     */
    public function wd_render_shortcode() {
        $no_of_posts     = get_option( 'wd_no_of_posts' );
        $post_order      = get_option( 'wd_post_order' );
        $post_cetegories = get_option( 'wd_post_categories' );

        $posts_per_page = ( ! empty( $no_of_posts ) ) ? $no_of_posts : 5;
        $order          = ( ! empty( $post_order && 'rand' !== $post_order ) ) ? strtoupper( $post_order ) : 'ASC';
        $order_by       = ( ! empty( $post_order ) && 'rand' === $post_order ) ? $post_order : 'ID';
        $categories     = ( ! empty( $post_cetegories ) ) ? implode( ',', array_values( $post_cetegories ) ) : '';

        $args = [
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => $posts_per_page,
            'category_name'  => $categories,
            'orderby'        => $order_by,
            'order'          => $order,
        ];

        $last_changed = wp_cache_get_last_changed( 'wd_featured_query' );
        $key          = md5( json_encode( $args ) );
        $cache_key    = "all:$key:$last_changed";
        $the_query    = wp_cache_get( $cache_key, 'wd_featured_query' );
        

        if ( false === $the_query ) {
            $the_query = new \WP_Query( $args );
            
            wp_cache_set( $cache_key, $the_query, 'we_featured_query' );
        }
        
        if ( $the_query->have_posts() ) {
            while( $the_query->have_posts() ) {
                $the_query->the_post();

                printf( 
                    "<div><p><a href='%s'>%s<a/></p></div>", 
                    get_the_permalink(), 
                    get_the_title() 
                );
            }
        }

        wp_reset_postdata();

        return ob_get_clean();
    }
}