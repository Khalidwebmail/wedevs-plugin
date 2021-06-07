<?php

namespace Post\Admin;

class WdCallback {
    /**
     * Display No of post field
     * 
     * @return void
     */
    public function wd_no_of_post_cb() {
        $val = get_option( 'wd_no_of_posts' );

        printf(
            "<input type='text' class='regular-text' name='%s', id='%s' placeholder='%s' value='%s' />",
            'wd_no_of_posts',
            'wd_no_of_posts',
            __( 'Number: 10', 'wd-featured-post' ),
            $val
        );
    }

    /**
     * Display order field
     * 
     * @return void
     */
    public function wd_post_order_cb() {
        $value = get_option( 'wd_post_order' );
        $options = [
            'asc'  => 'ASC', 
            'desc' => 'DESC', 
            'rand' => 'Random',
        ];
        ?>
            <select name="wd_post_order" id="wd_post_order">
                <option value="select_one" selected="selected"><?php _e( 'Select one', 'wd-featured-post' ) ?></option>
                <?php
                    foreach( $options as  $key => $name ) {
                        printf( "<option value='%s' %s>%s</option>",  $key, selected( ( $key === $value ) ? 1 : 0 ),
                        $name );
                    }
                ?>
            </select>
        <?php
    }

    /**
     * Display categories filed
     * 
     * @return void
     */
    public function wd_post_categories_cb() {
        $value = get_option( 'wd_post_categories' );

        $categories = get_categories( [
            'orderby' => 'name',
            'order'   => 'ASC',
        ] );
        
        foreach( $categories as $category ) {
//            echo "<pre>";
//            print_r($category->slug);exit;
            printf(
                "<label for='%s'><input name='%s' type='checkbox' id='%s' value='%s' %s> %s </label><br/>",
                $category->slug,
                "wd_post_categories[ $category->slug ]",
                $category->slug,
                $category->slug,
                checked( in_array($category->slug, $value), 1, 0 ),
                $category->name
            );
        }
    }

    /**
     * Display section
     * 
     * @return void
     */
    public function wd_section_cb() {
        printf( "<p class='description'>%s<p>", __( 'All settings for We Featured Posts shortcode plugin', 'wd-featured-post' ) );
    }
}