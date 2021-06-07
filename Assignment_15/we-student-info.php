<?php
/**
 * Plugin Name:       We Student Info
 * Plugin URI:        https://example.com/
 * Description:       Dispay student info using Metadata API
 * Version:           1.0.0
 * Requires at least: 5.6
 * Requires PHP:      5.6
 * Author:            Rajan K.
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       we-student-onfo
 * Domain Path:       /languages/
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

if ( ! class_exists( 'We_Student_Info' ) ) {
    /**
     * Plugin main class
     */
    final class We_Student_Info {
        /**
         * Plugin version
         * 
         * @var string VERSION
         */
        const VERSION = '1.0.0';

        /**
         * Class construct
         */
        private function __construct() {
            register_activation_hook( __FILE__, [ $this, 'activate' ] );

            $this->define_constants();
            $this->studentmeta_integrate_wpdb();

            add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
        }

        /**
         * Run plugins functionalities
         * 
         * @return void
         */
        public function init_plugin() {
            new WdStudentInfo\Asset();
            new WdStudentInfo\Shortcode();
        }

        /**
         * Define necessary constants
         * 
         * @return void
         */
        public function define_constants() {
            define( 'WSI_VERSION', self::VERSION );
            define( 'WSI_PATH', __DIR__ );
            define( 'WSI_FILE', __FILE__ );
            define( 'WSI_URL', plugins_url( '', WSI_FILE ) );
            define( 'WSI_ASSETS', WSI_URL . '/assets' );
        }

        /**
         * Do stuff during plugin instalation
         * 
         * @return void
         */
        public function activate() {
            $installer = new WdStudentInfo\Installer();
            $installer->run();
        }

        /**
         * Integrates sutdentmeta table with $wpdb
         * 
         * @return void
         */
        public function studentmeta_integrate_wpdb() {
            global $wpdb;

            $wpdb->studentmeta = $wpdb->prefix . 'studentmeta';

            return;
        }

        /**
         * Define a singleton instance
         * 
         * @return \We_Student_Info
         */
        public static function init() {
            static $instance = false;

            if ( ! $instance ) {
                $instance = new self();
            }

            return $instance;
        }
    }
}

/**
 * Initialize the plugin
 * 
 * @return \We_Student_Info
 */
function wsi_we_student_init_boot() {
    return We_Student_Info::init();
}

//Start the plugin
wsi_we_student_init_boot();

