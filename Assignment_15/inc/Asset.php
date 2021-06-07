<?php

namespace WdStudentInfo;

/**
 * Asset class
 */
class Asset {
    /**
     * Class construct
     */
    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'register_scripts' ] );
    }

    /**
     * Register all scripts
     * 
     * @return void
     */
    public function register_scripts() {
        $styles = $this->get_styles();
        $scripts = $this->get_scripts();

        foreach( $styles as $handle => $style ) {
            wp_register_style( $handle, $style['src'], $style['deps'], $style['version'] );
        }

        foreach( $scripts as $handle => $script ) {
            wp_register_script( $handle, $script['src'], $script['deps'], $script['version'], true );
        }
    }

    /**
     * Get styles
     * 
     * @return array
     */
    public function get_styles() {
        return [
            'student-reg-style' => [
                'src'     => WSI_ASSETS . '/css/regform-style.css',
                'version' => filemtime( WSI_PATH . '/assets/css/regform-style.css' ),
                'deps'    => [],
            ],
            'student-list-style' => [
                'src'     => WSI_ASSETS . '/css/student-list.css',
                'version' => filemtime( WSI_PATH . '/assets/css/student-list.css' ),
                'deps'    => [],
            ]
        ];
    }

    /**
     * Get scripts
     * 
     * @return array
     */
    public function get_scripts() {
        return [
            'student-reg-script' => [
                'src'     => WSI_ASSETS . '/js/student-reg.js',
                'version' => filemtime( WSI_PATH . '/assets/js/student-reg.js' ),
                'deps'    => [ 'jquery' ],
            ],
        ];
    }
}