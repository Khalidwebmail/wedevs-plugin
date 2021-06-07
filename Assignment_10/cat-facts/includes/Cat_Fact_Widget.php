<?php

namespace Cat\Facts;

/**
 * Class Cat_Fact_Widget
 * @package Cat\Facts
 */
class Cat_Fact_Widget {
	/**
	 * Class constructor
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'wp_dashboard_setup', [ $this, 'register_dashboard' ] );
	}

	/**
	 * Register Dashboard
	 *
	 * @return void
	 */
	public function register_dashboard() {
		wp_add_dashboard_widget(
			'cf_dashboard',
			__( 'My Cat Facts', 'cat-facts' ),
			[ $this, 'render_dashboard' ]
		);
	}

	/**
	 * Render dashboard
	 *
	 * /facts Retrieve and query facts
	 *
	 * @return void
	 */
	public function render_dashboard() {
		$url = 'https://cat-fact.herokuapp.com/facts';

		$cat_facts = get_transient( 'wcf_all_facts' );

		if ( false === $cat_facts ) {
			$cat_facts = json_decode( wp_remote_retrieve_body( wp_remote_get( $url ) ) );

			set_transient( 'wcf_all_facts', $cat_facts, DAY_IN_SECONDS );
		}

		if ( ! empty( $cat_facts ) ) {

			foreach( $cat_facts as $cat_fact ) {
				$single_link = "https://cat-fact.herokuapp.com/#/cat/facts/{$cat_fact->_id}";

				printf(
					"<p><a href='%s' target='_blank'>%s</p>",
					esc_url( $single_link ),
					esc_attr( $cat_fact->text )
				);
			}

		}
	}
}