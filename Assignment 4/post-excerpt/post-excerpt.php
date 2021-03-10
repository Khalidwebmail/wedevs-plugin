<?php
/**
 * Plugin Name:       Post Excerpt
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Use to save additional meta info of post.
 * Version:           1.0.0
 * Author:            Khalid Ahmed
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       post-excerpt
 */

use Post\Excerpt\Admin\Metabox;
use Post\Excerpt\Frontend\Shortcode;

if( !defined( 'ABSPATH') ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

final class Post_Excerpt {
    /**
     * Plugin version
     */
    const version = "1.0";

    private function __construct()
    {
        $this->define_constants();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        add_action( 'init', [ $this, 'init_plugin' ] );
    }
    
    /**
     * initialize singleton instance
     *
     * @return \Post_Excerpt
     */
    public static function init()
    {
        static $instance  = false;

        if(! $instance) {
            $instance = new self();
        }

        return $instance;
    }
    
    /**
     * define required plugins constants
     *
     * @return void
     */
    public function define_constants()
    {
        define( 'WD_EXCERPT_VERSION', self::version );
        define( 'WD_EXCERPT_FILE', __FILE__ );
        define( 'WD_EXCERPT_PATH', __DIR__ );
        define( 'WD_EXCERPT_URL', plugins_url( '', WD_EXCERPT_FILE ) );
    }
        
    /**
     * initialize the plugin
     *
     * @return void
     */

    public function init_plugin()
    {
        if( is_admin() ) {
            new Metabox();
        }
        else{
            new Shortcode();
        }
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() 
    {
        $installed = get_option( 'wd_excerpt_installed' );
        if( ! $installed ) {
            update_option( 'wd_excerpt_installed', time() );
        }
        update_option( 'wd_excerpt_installed', WD_EXCERPT_VERSION );
    }
}

/**
 * iniitalize the main plugin
 *
 * @return \Post_Excerpt
 */
function start_post_excerpt()
{
    return Post_Excerpt::init();
}

/**
 * Kick of plugin
 */
start_post_excerpt();