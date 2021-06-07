<?php

namespace Vertical\Frontend;

/**
 * Class ShowButton
 * @package Vertical\ShowButton
 */
class ShowButton {
	/**
	 * ShowButton constructor.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'load_script' ] );
		add_action( 'wp_body_open', [ $this, 'show_button' ] );
	}


	public function show_button () {
		$btn_lablel = apply_filters( 'update_button_label', 'Click me' );

		echo '
        <a class="btn book-now desktop open-datepicker-popup" onclick="showHide()" href="#" title="Vertical Button">'. $btn_lablel .'</a>
        <div class="scroll"></div>
        
        <p id="text-body">
            There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. 
        </p>
        ';
	}

	/**
	 * Include css file
	 */
	public function load_script() {
		wp_enqueue_style( 'button-style', MENU_ASSETS .'/style.css');
		wp_enqueue_script( 'button-script', MENU_ASSETS .'/main.js');
	}
}