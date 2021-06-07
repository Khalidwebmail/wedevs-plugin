<?php

namespace Mailchimp\Subscription;

/**
 * Widget class
 */
class Subscription_Widget extends \WP_Widget {
    /**
     * Class constructor
     */
    public function __construct() {
        parent::__construct(
            'we_subscription_form',
            __( 'We Subscription Form', 'we-subscription-form' ),
            [ 'description' => __( 'Display MailChimp subscription form', 'we-subscription-form' ) ]
        );

        add_action( 'widgets_init', [ $this, 'register_widget' ] );
    }

    /**
     * Register MailChimp widget
     * 
     * @return void
     */
    public function register_widget() {
        register_widget( '\Mailchimp\Subscription\Subscription_Widget' );
    }

    /**
     * Display widget frontend
     * 
     * @param array $args
     * @param array $instance
     * 
     * @return void
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
 
        if ( ! empty( $instance['wsf_title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', __( $instance['wsf_title'], 'we-subscription-form' ) ) . $args['after_title'];
        }
 
        echo '<div class="textwidget">';
        
        if ( ! empty( $instance['wsf_list'] ) ) {
            $id = esc_attr( $instance['wsf_list'] );

            ?>
                <p>
                    <form id='wsf_widget_form' class='search-form'>
                    <input type='text' data-id='<?php echo esc_attr( $id ); ?>' name='wsf_subscribe' id='wsf_subscribe' class='ragular-text search-field' placeholder='Provide your email'><br/>
                    <input class='search-submit' type='submit' name='wsf_submit' id='wsf_submit' value='Subscribe'>
                    </form> 
                </p>
            <?php

        } else {
            echo __( 'Please configure MailChimp properly', 'we-subscription-form' );
        }
 
        echo '</div>';
 
        echo $args['after_widget'];

        wp_enqueue_script( 'wsf-main' );
    }

    /**
     * Display settings form
     * 
     * @return void
     */
    public function form( $instance ) {
        $title         = ( isset( $instance['wsf_title'] ) ) ? esc_attr( $instance['wsf_title'] ): '';
        $selected_item = ( isset( $instance['wsf_list'] ) ) ? esc_attr( $instance['wsf_list'] )  : '';

        $api_key = get_option( 'wcf_api_settings' );

        //Get all audiance ID from mailchimp database via api call
        $audiences = $this->get_all_audience_id( $api_key );

        ?>
        <p>
            <label for='<?php echo esc_attr( $this->get_field_id( 'wsf_title' ) ); ?>'><?php echo esc_html__( 'Title', 'we-subscription' ); ?></label><br/>
            <input class='widefat' type='text' name='<?php echo esc_attr( $this->get_field_name( 'wsf_title' ) ); ?>' id='<?php echo esc_attr( $this->get_field_id( 'wsf_title' ) ); ?>' value='<?php echo $title; ?>'>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'wsf_list' ) ); ?>"><?php echo esc_html__( 'Mailchimp group', 'we-subscription-form' ); ?></label><br/>
            <select class='widefat' name="<?php echo esc_attr( $this->get_field_name( 'wsf_list' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'wsf_list' ) ); ?>">
                <option selected="selected" value="">Select one</option>
                <?php foreach( $audiences->lists as $audience ): ?>

                    <option value="<?php echo esc_attr( $audience->id ) ?>" <?php selected( $audience->id, $selected_item, 1 ); ?>><?php echo esc_html__( $audience->name, 'we-subscription-form' ); ?></option>

                <?php endforeach; ?>
            </select>
        <p>

        <?php
    }

    /**
     * Update settings field
     * 
     * @return array
     */
    public function update( $new_instance, $old_instance ) {
        $instance = [];
        
        $instance['wsf_title'] = ( isset( $new_instance['wsf_title'] ) ) ? sanitize_text_field( $new_instance['wsf_title'] ): '';
        $instance['wsf_list']  = ( isset( $new_instance['wsf_list'] ) ) ? sanitize_text_field( $new_instance['wsf_list'] )  : '';

        return $instance;
    }

    /**
     * Get all Audience ID
     * 
     * @return array
     */
    public function get_all_audience_id( $api_key ) {
        $url = 'https://us1.api.mailchimp.com/3.0/lists/';

        $args = [
            'headers' => [
                'Authorization' => "apikey {$api_key}"
            ]
        ];

        $response = json_decode( wp_remote_retrieve_body( wp_remote_get( $url, $args ) ) );

        return $response;
    }

}
