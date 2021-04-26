<?php

namespace Post\Admin;

class WdSettings {
    /**
     * Class constructor
     */
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'wd_add_admin_menu' ] );
    }

    /**
     * Add featured post menu
     */
    public function wd_add_admin_menu() {
            add_options_page( 
                __( 'Wd Featured Post', 'wd-featured-post' ),
                __( 'Wd Featured Post', 'wd-featured-post' ),
                'manage_options',
                'wd-featured-post',
                [ $this, 'wd_featured_post' ]
        );
    }

    /**
     * Display featured posts menu settings form
     * 
     * @return void
     */
    public function wd_featured_post() {
        ?>
            <div class="wrap"> 
                <form action="options.php" method="POST"> 

                    <?php settings_fields( 'wd-featured-post' ); ?>

                    <?php do_settings_sections( 'wd-featured-post' ); ?>

                    <?php submit_button(); ?>

                </form>
            </div>
        <?php
    }
}