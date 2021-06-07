<?php

namespace Contact\Form;

/**
 * Installer class
 */
class Installer {

    /**
     * Run the installer
     */
    public function run() {
        $this->add_version();
        $this->create_table();
    }

    /**
     * Check plugin is installed if not insert
     * install time, and add plugin version
     *
     * @return void
     */
    public function add_version() {
        $installed = get_option( 'wpcf_installed' );

        if ( ! $installed ) {
            update_option( 'wpcf_installed', time() );
        }

        update_option( 'wpcf_version', WPCF_PLUGIN_VERSION );
    }

    /**
     * Create necessary database tables
     *
     * @return void
     */
    public function create_table() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $schema = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}contact_messages` (
          `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
          `name` varchar(60) NOT NULL,
          `email` varchar(60) NOT NULL,
          `message` text NOT NULL,
          `ip` varchar(30) NOT NULL,
          `created_at` datetime NOT NULL,
          `updated_at` datetime DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) $charset_collate";

        if ( ! function_exists('dbDelta') ) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        dbDelta( $schema );
    }

}