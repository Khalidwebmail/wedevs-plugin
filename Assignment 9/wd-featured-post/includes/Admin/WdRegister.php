<?php

namespace Post\Admin;

class WdRegister {
    /**
     * callback object
     * 
     * @var object $callback
     */
    public $callback;

    public function __construct( $callback ) {
        $this->callback = $callback;
        add_action( 'admin_init', [ $this, 'wd_register_settings' ] );
    }

    /**
     * Register all settings options
     * 
     * @return void
     */
    public function wd_register_settings() {
        $register_settings = $this->wd_get_settings();
        $sections          = $this->wd_get_sections();
        $fields            = $this->wd_get_settings_fields();

        foreach( $register_settings as $setting ) {
            register_setting( $setting[ 'option_group' ], $setting[ 'option_name' ], $setting[ 'sanitize_callback' ] );
        }

        foreach( $sections as $section ) {
            add_settings_section( $section[ 'id' ], $section[ 'title' ], $section[ 'callback' ], $section[ 'page' ] );
        }

        foreach( $fields as $field ) {
            add_settings_field( $field[ 'id' ], $field[ 'title' ], $field[ 'callback' ], $field[ 'page' ], $field[ 'section' ], $field[ 'args' ] );
        }
    }

    /**
     * Get register settings
     * 
     * @return array
     */
    public function wd_get_settings() {
        return [
            [
                'option_group'      => 'wd-featured-post',
                'option_name'       => 'wd_no_of_posts',
                'sanitize_callback' => [ 'sanitize_callback' => 'esc_attr' ],
            ],
            [
                'option_group'      => 'wd-featured-post',
                'option_name'       => 'wd_post_order',
                'sanitize_callback' => [ 'sanitize_callback' => 'esc_attr' ],
            ],
            [
                'option_group'      => 'wd-featured-post',
                'option_name'       => 'wd_post_categories',
                'sanitize_callback' => [ 'type' => 'array' ],
            ],
        ];
    }

    /**
     * Get settings fields
     * 
     * @return array
     */
    public function wd_get_settings_fields() {
        return [
            [
                'id'       => 'wd_no_of_posts',
                'title'    => __( 'No of posts', 'wd-featured-post' ),
                'callback' => [ $this->callback, 'wd_no_of_post_cb' ],
                'page'     => 'wd-featured-post',
                'section'  => 'wd_section',
                'args'     => [],
            ],
            [
                'id'       => 'wd_post_order',
                'title'    => __( 'Order', 'wd-featured-post' ),
                'callback' => [ $this->callback, 'wd_post_order_cb' ],
                'page'     => 'wd-featured-post',
                'section'  => 'wd_section',
                'args'     => [],
            ],
            [
                'id'       => 'wd_post_categories',
                'title'    => __( 'Categories', 'we-featured-posts' ),
                'callback' => [ $this->callback, 'wd_post_categories_cb' ],
                'page'     => 'wd-featured-post',
                'section'  => 'wd_section',
                'args'     => [],
            ],
        ];
    }

    /**
     * Get settings section
     * 
     * @return array
     */
    public function wd_get_sections() {
        return [
            [
                'id'       => 'wd_section',
                'title'    => __( 'We Featured Posts Settings', 'wd-featured-post' ),
                'callback' => [ $this->callback, 'wd_section_cb' ],
                'page'     => 'wd-featured-post',
            ]
        ];
    }
}