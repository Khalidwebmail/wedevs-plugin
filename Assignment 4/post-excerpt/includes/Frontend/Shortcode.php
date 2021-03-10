<?php

namespace Post\Excerpt\Frontend;

class Shortcode {
    /**
     * class initialization
     */
    public function __construct()
    {
        add_shortcode( 'latest-excerpt', [ $this, 'render_shortcode' ] );
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
            array (
            'posts_per_page' => 10,
            'category_name'  => null,
            'post_id'        => array(),
            'post_type'      => 'post',
            'order'          => 'DESC',
            'post_status'    => 'publish',
            'meta_key'       => 'excerpt_info',
        ), $atts );

        $ids = $atts[ 'post_id' ];
        unset( $atts[ 'post_id' ] );

        if( ! empty( $ids ) ) {
            $atts[ 'post__in' ] = explode( ',', $ids );

            if( isset( $atts[ 'post_id' ] ) ) {
                $the_query = new \WP_Query( $atts );
                if( $the_query->have_posts() ) {
                    while ( $the_query->have_posts() ) {
                        $the_query->the_post();
                        echo '<h2 class="entry-title">'. get_the_title() .'</h2>';
                        echo '<div>'. $the_query->post->excerpt_info .'</div>';
                    }
                    wp_reset_postdata();
                }
            }
        }

        $the_query = new \WP_Query( $atts );

        if( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                echo '<h2 class="entry-title">'. get_the_title() .'</h2>';
                echo '<div>'. $the_query->post->excerpt_info .'</div>';
            }
        }
        wp_reset_postdata();
    }
}