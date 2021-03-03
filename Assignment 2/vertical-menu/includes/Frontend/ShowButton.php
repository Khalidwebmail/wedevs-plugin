<?php

namespace Vertical\Frontend;

class ShowButton {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'load_css' ] );
        add_action( 'wp_body_open', [ $this, 'show_button' ]);
    }

    public function show_button () {
        $btn_lablel = 'Vertical Button';
    
        echo '
        <a class="btn book-now desktop open-datepicker-popup" href="#" title="Vertical Button">'.$btn_lablel.'</a>
        <div class="scroll"></div>
        
        <p id="text-body">
            There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. 
        </p>
        ';
    }

    public function load_css() {
        wp_enqueue_style( 'button-style', __DIR__ .'/assets/frontend/style.css');
    }
}