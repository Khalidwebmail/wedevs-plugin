<?php

namespace Related\Product;

/**
 * Class Related_Product
 */
class Related_Product
{
    /**
     * Related_Product constructor.
     */
    public function __construct()
    {
        add_filter( 'woocommerce_product_tabs', [ $this, 'woo_related_product_tab' ], 98 );
        add_action( 'template_redirect', [ $this, 'woo_add_to_cart_product' ] );
    }

    /**
     * Add related product tab
     * @param $tabs
     * @return array
     */
    public function woo_related_product_tab( $tabs ) {

        $tabs['related_product_tab'] = [
            'title' 	=> __( 'Related Product', 'show-related-product' ),
            'priority' 	=> 50,
            'callback' 	=> [ $this, 'woo_related_product_content' ]
        ];

        return $tabs;
    }

    /**
     * Get related product
     */
    public function woo_related_product_content() {
        global $product;
        $id = $product->get_id();
        wc_get_related_products( $id );
    }

    /**
     * Add to cart product
     */
    public function woo_add_to_cart_product() {
        global $post;

        if ( is_singular( 'product' ) ) {
            $product_id = $post->ID;
            $found = false;
            //check if product already in cart
            if ( sizeof( WC()->cart->get_cart() ) > 0 ) {
                foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
                    $_product = $values['data'];
                    if ( $_product->get_id() == $product_id )
                        $found = true;
                }
                // if product not found, add it
                if ( ! $found )
                    WC()->cart->add_to_cart( $product_id );
            } else {
                // if no products in cart, add it
                WC()->cart->add_to_cart( $product_id );
            }
        }

//        if ( is_singular( 'product' ) ) {
//
//            $product_id = $post->ID; //replace with your product id
//            $found = false;
//            $cart_total = 30; //replace with your cart total needed to add above item
//
//            if ( $woocommerce->cart->total >= $cart_total ) {
//                //check if product already in cart
//                if ( sizeof( $woocommerce->cart->get_cart()) > 0 ) {
//                    foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
//                        $_product = $values['data'];
//                        if ( $_product->get_id() == $product_id )
//                            $found = true;
//                    }
//                    // if product not found, add it
//                    if ( ! $found )
//                        $woocommerce->cart->add_to_cart( $product_id );
//                } else {
//                    // if no products in cart, add it
//                    $woocommerce->cart->add_to_cart( $product_id );
//                }
//            }
//        }
    }
}