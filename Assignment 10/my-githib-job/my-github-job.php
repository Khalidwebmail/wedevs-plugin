<?php

/** 
**
 * Plugin Name:         My Github job
 * Plugin URI:          http://example.com
 * Description:         A simple WordPress plugin that can track github's job.
 * Version:             1.0.0
 * Requires at least:   5.2
 * Author:              Ahmed Abdullah
 * Author URI:          http://example.com/
 * License:             GPLv2.0-or-later
 * License URI:         https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:         my-github-job
 * Domain Path:         /languages
 *
 * @package MyGithubJob
 */
use My\GitHub\Frontend\Shortcode;

if( !defined( "ABSPATH" ) ) {
    exit;
}

if( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';
}

final class MyGithubJob {
    /**
     * Plugin version
     */
    public const WD_JOB_VERSION = '1.0.0';

    /**
     * Define class constructor
     */
    private function __construct() {
        $this->wd_job_define_constant();
        add_action( 'activate_plugin', [ $this, 'wd_job_activate_plugin' ] );
        add_action( 'init', [ $this, 'wd_job_initiate_plugin' ] );
    }

    /**
     * Define plugin related constant
     */
    public function wd_job_define_constant() {
        define( 'WD_JOB_GITHUB_VERSION', self::WD_JOB_VERSION );
        define( 'WD_JOB_GITHUB_BASE_NAME', plugin_basename( __FILE__ ) );
        define( 'WD_JOB_GITHUB_BASE_PATH', __DIR__ );
        define( 'WD_JOB_GITHUB_INCLUDE_PATH', __DIR__ . '/includes' );
        define( 'WD_JOB_GITHUB_URL', plugins_url( '', __FILE__ ) );
    }

    /**
     * Activating the plugin
     *
     * @return void
     */
    public function wd_job_activate_plugin() {
        if ( ! get_option( 'wd_job_github_installed' ) ) {
            update_option( 'wd_job_github_installed', time() );
        }
        update_option( 'wd_job_github_version', WD_JOB_GITHUB_VERSION );
    }

    /**
     * Initiate the plugin
     *
     * @return void
     */
    public function wd_job_initiate_plugin() {
        if( ! is_admin() ) {
            new Shortcode();
        }
    }

    /**
     * Init method for MyGithubJob
     *
     * @return false|\MyGithubJob
     */
    public static function wd_job_init() {
        $instance = false;
        if ( ! $instance ) {
            $instance = new self();
        }
        return $instance;
    }
}

/**
 * Initialize the MyGithubJob
 *
 * @return void
 */
function wd_job_github() {
    MyGithubJob::wd_job_init();
}

/**
 * Hit start
 */
wd_job_github();
