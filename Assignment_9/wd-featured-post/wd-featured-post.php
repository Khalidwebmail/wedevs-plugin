<?php
/**
 * Plugin Name:       Wd Featured Post
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Display Featured Posts with shortcode.
 * Version:           1.0.0
 * Requires PHP:      7.0
 * Author:            John Smith
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wd-featured-post
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


if( file_exists( __DIR__. '/vendor/autoload.php' ) ) {
	require_once __DIR__. '/vendor/autoload.php';
}

final class Wd_Featured_Post {
    const VERSION = '1.0.0';

    private function __construct() {
        add_action( 'init', [ $this, 'wd_init_plugin' ] );
    }

    /**
     * Initialize the plugin
     * 
     * @return void
     */
    public function wd_init_plugin() {
        if( is_admin() ) {
            new \Post\Admin();
        }
        new \Post\Frontend();
    }

    /**
     * Initialize a singleton instance
     * 
     * @return \Wd_Featured_Posts
     */
    public static function wd_init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }
        return $instance;
    }
}

/**
 * Initialize the main plugin
 * 
 * @return \Wd_Featured_Posts
 */
function wd_featured_post_boot() {
    return Wd_Featured_Post::wd_init();
}

// Start the plugin
wd_featured_post_boot();