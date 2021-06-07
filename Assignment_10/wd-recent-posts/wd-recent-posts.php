<?php
/**
 * Plugin Name:       Wd Recent Posts
 * Plugin URI:        https://example.com/
 * Description:       Display recent posts on dashboard
 * Version:           1.0.0
 * Author:            Khalid Ahmed.
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wd-recent-posts
 * Domain Path:       /languages/
 */

// Prevent Direce access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';


/**
 * Plugin main class
 */
final class Wd_Recent_Posts {
    /**
     * Plugin version
     *
     * @var string version
     */
    const version = '1.0.0';

    /**
     * Class constructor
     *
     * @return void
     */
    private function __construct() {
        $this->define_constants();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );

        add_action( 'init', [ $this, 'init_plugin' ] );
    }

    /**
     * Run all necessary plugin functionalities
     *
     * @return void
     */
    public function init_plugin() {
        new \Recent\Posts\Assets();

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            new \Recent\Posts\Ajax();
        }

        new \Recent\Posts\Dashboard();
    }

    /**
     * Define all necessary constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'WRP_VERSION', self::version );
        define( 'WRP_PATH', __DIR__ );
        define( 'WRP_FILE', __FILE__ );
        define( 'WRP_URL', plugins_url( '', WRP_FILE ) );
        define( 'WRP_ASSETS', WRP_URL . '/assets' );
    }

    /**
     * Add plugin version and time
     *
     * @return void
     */
    public function activate() {
        $installed = get_option( 'wrp_installed' );

        if ( ! $installed ) {
            update_option( 'wrp_installed', time() );
        }

        update_option( 'wrp_version', WRP_VERSION );
    }

    /**
     * Initialize Singleton Instance
     *
     * @return \We_Recent_Posts
     */
    public static function init() {
        $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }
}


/**
 * Initialize the plugin
 * 
 * @return \Wd_Recent_Posts
 */
function wd_recent_posts_boot() {
    return Wd_Recent_Posts::init();
}

// Start the plugin
wd_recent_posts_boot();