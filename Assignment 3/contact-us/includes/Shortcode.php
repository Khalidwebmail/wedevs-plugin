<?php

namespace Contact\Us;

class Shortcode {
    public function __construct() {
        add_shortcode( 'my-contact-form', [ $this, 'render_shortcode' ] );
        add_shortcode( 'my-contact-form-custom-field', [ $this, 'render_input_field' ] );
    }
    
    /**
     * render_shortcode
     * Main shortcode which will show form
     * @param  mixed $atts
     * @param  mixed $content
     * @return void
     */
    public function render_shortcode( $atts, $content ) {
        $atts = shortcode_atts( array(
            'title' => 'My contact form',
        ), $atts );

        ?>
        <h2><?php echo $atts[ 'title' ]?></h2>
        <form action="" method="post">
            <div>
                <?php echo do_shortcode( $content ) ?>
            </div>
        </form>
        <?php
    }
    
        
    /**
     * render_input_field
     * Render input field and show frontend
     * @param  mixed $atts
     * @return void
     */
    public function render_input_field( $atts ) {
        $atts = shortcode_atts( 
            array (
            'name' => 'name-' . time(),
            'type' => 'text',
            'placeholder' => 'Write here',
        ), $atts );
        $type = $atts['type'];

        $input_type = apply_filters( 'input_data', 
                        array( 
                            'text',
                            'password',
                            'number',
                            'tel',
                            'file',
                            'email',
                            'url',
                            'date'
                        ) );
        if ( in_array( $atts['type'], $input_type ) ){
            $type = 'common_input';
        }
        switch ( $type ) {
            case 'common_input':
                return "<input type='{$atts['type']}' name='{$atts['name']}' placeholder='{$atts['placeholder']}'><br/>";
            case 'radio':
                return "<input type='{$atts['type']}' name='{$atts['name']}' placeholder='{$atts['placeholder']}'><label for='radio'> Male </label><br/>
                <input type='{$atts['type']}' name='{$atts['name']}' placeholder='{$atts['placeholder']}'><label for='radio'> Female </label><br/>
                ";
            case 'textarea':
                return "<textarea name='{$atts['name']}' rows='4' cols='50'> </textarea><br/>";
            case 'checkbox':
                return "<input type='checkbox' name='{$atts['name']}' value='MyBike'> Do you agree our agreement?<br/>";
            case 'submit':
                return "<input type='{$atts['type']}' name='{$atts['name']}' value='Send'><br/>";
            default:
                return "<input type='{$atts['type']}' name='{$atts['name']}' placeholder='{$atts['placeholder']}'></br>";
        }
    }
}