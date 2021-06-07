<?php

namespace Contact\Form;

/**
 * Assets handler class
 */
class Assets {

    /**
     * Class constructor
     */
    public function __construct() {
        add_action( 'init', array( $this, 'register_assets' ) );
    }

    /**
     * Define scripts
     * 
     * @return array
     */
    public function get_scripts() {
        return array(
            'custom-script' => array(
                'src'     => WPCF_PLUGIN_ASSETS . '/js/main.js',
                'version' => filemtime(WPCF_PLUGIN_PATH . '/assets/js/main.js'),
                'deps'    => array( 'jquery', 'jquery-validation' ),
            ),
            'jquery-validation' => array(
                'src'     => '//cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js',
                'version' => '1.19.3',
                'deps'    => array( 'jquery' ),
            )
        );
    }

    /**
     * Define Styles
     * 
     * @return array
     */
    public function get_styles() {
        return array(
            'custom-style' => array(
                'src'     => WPCF_PLUGIN_ASSETS . '/css/style.css',
                'version' => filemtime(WPCF_PLUGIN_PATH . '/assets/css/style.css'),
            )
        );
    }

    /**
     * Register admin scripts
     * 
     * @return void
     */
    public function register_assets() {
        $styles = $this->get_styles();
        $scripts = $this->get_scripts();

        foreach ($styles as $handle => $style) {
            $deps = isset( $style['deps'] ) ? $style['deps'] : false;
            wp_register_style( $handle, $style['src'], $deps, $style['version'] );
        }

        foreach ($scripts as $handle => $script) {
            $deps = isset( $script['deps'] ) ? $script['deps'] : false;
            wp_register_script( $handle, $script['src'], $deps, $script['version'], true );
        }

        wp_localize_script( 'custom-script', 'contactForm', array(
            'url'   => admin_url( 'admin-ajax.php' ),
            'error' => __('Ops! Something went wrong'),
        ) );
    }
}