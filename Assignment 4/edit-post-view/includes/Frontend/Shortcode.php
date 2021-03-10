<?php

namespace Post\View\Frontend;

class Shortcode {
    /**
     * class initialization
     */
    public function __construct()
    {
        add_shortcode( 'latest-post-view-number', [ $this, 'render_count_shortcode' ] );
    }

    /**
     * shortcode header class
     *
     * @param  array $atts
     * @return mixed
     */
    public function render_count_shortcode( $atts )
    {
        $atts = shortcode_atts( 
            array (
            'posts_per_page' => 10,
            'category_name'  => null,
            'post_id'        => '',
            'post_type'      => 'post',
            'order'          => 'DESC',
            'post_status'    => 'publish',
        ), $atts );

        $ids = $atts[ 'post_id' ];

        if( $ids != '' ) {
            $atts[ 'post__in' ] = explode( ',', $ids );
            $the_query = new \WP_Query( $atts );
            if( $the_query->have_posts() ) {
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    echo '<a style="color: darkorange" href="'.get_permalink().'"><h2 class="entry-title">'. get_the_title().' ('.$the_query->post->post_views_count.')</h2></a>';
                }
                wp_reset_postdata();
            }
        }

        if( $ids == '' ) {
            $the_query = new \WP_Query( $atts );

            error_log( $atts[ 'posts_per_page' ] );
            if( $the_query->have_posts() ) {
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    echo '<a style="color: darkorange" href="'.get_permalink().'"><h2 class="entry-title">'. get_the_title().' ('.$the_query->post->post_views_count.')</h2></a>';
                }
                wp_reset_postdata();
            }
        }
    }
}