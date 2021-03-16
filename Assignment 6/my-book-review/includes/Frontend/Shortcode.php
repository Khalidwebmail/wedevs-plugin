<?php

namespace Book\Review\Frontend;

/**
 * Shortcode class decleration
 */
class Shortcode {    
    /**
     * __construct
     * Define constructor
     * @return void
     */
    public function __construct() {
        add_shortcode( 'my-search-form', [ $this, 'render_shortcode' ] );
    }

    /**
     * render_shortcode
     * Main shortcode which will show form
     * @param  mixed $atts
     * @return void
     */
    public function render_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'title' => 'Search here',
        ), $atts );
        $s = '';
        $result = '';
            
            if( isset( $_GET[ 'search' ] )) {
                $s = $_GET[ 'search' ];
                $args = array(
                    'post_type' => 'book',
                    'meta_query' => array(
                        'relation' => 'OR',
                        array(
                            'key' => 'book_publishers',
                            'value'    => $s,
                            'compare'    => 'LIKE',
                        ),
                        array(
                            'key' => 'book_writer_name',
                            'value'    => $s,
                            'compare'    => 'LIKE',
                        ),
                        array(
                            'key' => 'book_isbn_number',
                            'value'    => $s,
                            'compare'    => 'LIKE',
                        ),
                    ),
                );
                $result = new \WP_Query($args);
            }
        ?>
        <h2><?php echo $atts[ 'title' ]?></h2>
        <form role="search" method="get" class="search-form">
            <label>
                <span class="screen-reader-text">Search for:</span>
                <input type="text" class="search-field" placeholder="Search …" name="search">
            </label>
		</form>
        <?php

        if( $result->have_posts() ) {
            echo '<ol>';
            while ( $result->have_posts() ) {
                $result->the_post();
                $html = '<li>'.get_the_title().'</li>';
                echo $html;
            }
            echo '</ol>';
            wp_reset_query();
        }
    }
}