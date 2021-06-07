<?php

namespace WdRestApi;

/**
 * Shortcode class
 */
class Shortcode {
    /**
     * Class constructor
     * 
     * @return void
     */
    public function __construct() {
        add_shortcode( 'wcfn-shortcode-form', [ $this, 'wcf_display_contact_form' ] );
        add_shortcode( 'wcfn-field', [ $this, 'wcf_shortcode_field' ] );
        add_shortcode( 'wcfn-field-textarea', [ $this, 'wcf_shortcode_field_textarea' ] );
    }

    /**
     * Render Contact form
     * 
     * @return string
     */
    public function wcf_display_contact_form( $atts = [], $content ) {

        wp_enqueue_style( 'wcfn-shortcodeform-style' );

        include WE_REST_PLUGIN_PATH . '/assets/templates/template-form.php';

        wp_enqueue_script( 'wcfn-shortcodeform-script' );

    }

    /**
     * Display Shortcode field
     * 
     * @return void
     */
    public function wcf_shortcode_field( $atts ) {
        $atts = shortcode_atts( [
            'name'        => 'name' . time(),
            'type'        => 'text',
            'class'       => '',
            'placeholder' => '',
            'id'          => 'name' . time(),
            'value'       => '',
        ], $atts );

        printf( 
            "<p><input name='%s' type='%s' class='%s' placeholder='%s' id='%s' value='%s'/></p><br/>",
             esc_attr( $atts['name'] ),
             esc_attr( $atts['type'] ),
             esc_attr( $atts['class'] ),
             esc_attr( $atts['placeholder'] ),
             esc_attr( $atts['id'] ),
             esc_attr( $atts['value'] )
        );
    }

    /**
     * Textarea filed
     * 
     * @return void
     */
    public function wcf_shortcode_field_textarea( $atts ) {
        $atts = shortcode_atts( [
            'name'        => 'name' . time(),
            'class'       => '',
            'placeholder' => '',
            'id'          => 'name' . time(),
            'value'       => '',
        ], $atts );

        printf( 
            "<p><textarea name='%s' class='%s' placeholder='%s' id='%s'>%s</textarea></p><br/>",
             esc_attr( $atts['name'] ),
             esc_attr( $atts['class'] ),
             esc_attr( $atts['placeholder'] ),
             esc_attr( $atts['id'] ),
             esc_textarea( $atts['value'] )
        );
    }
}