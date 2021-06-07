<?php

namespace Book\Reviews;

/**
 * Assets handler class
 */
class Wd_Asset {

	/**
	 * Class constructor
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'wd_enque_assets' ] );
	}

	/**
	 * Define scripts
	 *
	 * @return array
	 */
	public function wd_get_scripts() {
		return [
			'better-rating' => [
				'src'     => WDBR_PLUGIN_ASSETS . '/js/better-rating.js',
				'version' => filemtime( WDBR_PLUGIN_PATH . '/assets/js/better-rating.js' ),
				'deps'    => [ 'jquery' ]
			],
			'main' => [
				'src'     => WDBR_PLUGIN_ASSETS . '/js/main.js',
				'version' => filemtime( WDBR_PLUGIN_PATH . '/assets/js/main.js' ),
				'deps'    => [ 'better-rating' ]
			]
		];
	}

	/**
	 * Define Styles
	 *
	 * @return array
	 */
	public function wd_get_styles() {
		return [
			'font-awesome' => [
				'src'     => '//cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css',
				'version' => '4.7.0',
			],
			'better-rating' => [
				'src'     => WDBR_PLUGIN_ASSETS . '/css/better-rating.css',
				'version' => filemtime( WDBR_PLUGIN_PATH . '/assets/css/better-rating.css' ),
				'deps'    => [ 'font-awesome' ]
			]
		];
	}

	/**
	 * Register admin scripts
	 *
	 * @return void
	 */
	public function wd_enque_assets() {
		$styles = $this->wd_get_styles();
		$scripts = $this->wd_get_scripts();

		foreach ( $styles as $handle => $style ) {
			$deps = isset( $style[ 'deps' ] ) ? $style[ 'deps' ] : false;
			wp_enqueue_style( $handle, $style['src'], $deps, $style[ 'version' ] );
		}

		foreach ($scripts as $handle => $script) {
			$deps = isset( $script[ 'deps' ] ) ? $script[ 'deps' ] : false;
			wp_enqueue_script( $handle, $script['src'], $deps, $script[ 'version' ], true );
		}

		wp_localize_script( 'main', 'ratingJs', [
			'url'     => admin_url( 'admin-ajax.php' ),
			'error'   => __( 'Ops! Something went wrong', 'wd-book-reviews' ),
		] );
	}
}