<?php

namespace WdRestApi;

/**
 * Installer class
 */
class Installer {
    /**
     * Add plugin version and create table
     * 
     * @return void
     */
    public function run() {
        $this->add_version();
        $this->add_tables();
    }

    /**
     * Add plugin version and time
     * 
     * @return void
     */
    public function add_version() {
        $installed = get_option( 'wcfn_activate_time' );

        if ( ! $installed ) {
            update_option( 'wcfn_activate_time', time() );
        }

        update_option( 'WE_REST_PLUGIN_VERSION', WE_REST_PLUGIN_VERSION );
    }

    /**
     * Add table to database
     * 
     * @return void
     */
    public function add_tables() {
        global $wpdb;

        $cherset_collate = $wpdb->get_charset_collate();

        $schema = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}wcfn_contact` (
        `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(100) NOT NULL,
        `email` varchar(100) NOT NULL,
        `message` varchar(255) NOT NULL,
        `created_at` datetime NOT NULL,
        PRIMARY KEY (`id`),
        KEY `email` (`email`)
        ) {$cherset_collate}";

        if ( ! function_exists( 'dbDelta' ) ) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        dbDelta( $schema );
    }
}