<?php

namespace WdStudentInfo;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Installer calss
 */
class Installer {
    /**
     * Run the installer
     * 
     * @return void
     */
    public function run() {
        $this->add_version();
        $this->create_table();
    }

    /**
     * Add plugin install time and version into db
     * 
     * @return void
     */
    public function add_version() {
        $installed = get_option( 'wsi_installed' );

        if ( ! $installed ) {
            update_option( 'wsi_installed', time() );
        }

        update_option( 'wsi_version', WSI_VERSION );
    }

    /**
     * Create students table
     * 
     * @return void
     */
    public function create_table() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $schemas = [ 
            "CREATE TABLE {$wpdb->prefix}students (
                id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                first_name varchar(100) NOT NULL DEFAULT '',
                last_name varchar(100) NOT NULL DEFAULT '',
                s_class varchar(50) NOT NULL DEFAULT '',
                roll varchar(30) NOT NULL DEFAULT '',
                reg_no varchar(30) NOT NULL DEFAULT '',
                created_at datetime NOT NULL,
                PRIMARY KEY (id)
            ) {$charset_collate}",
            "CREATE TABLE {$wpdb->prefix}studentmeta (
                meta_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                student_id bigint(20) unsigned NOT NULL default '0',
                meta_key varchar(255) default NULL,
                meta_value longtext,
                PRIMARY KEY (meta_id),
                KEY student (student_id),
                KEY meta_key (meta_key( 191 ))
            ) {$charset_collate}", 
        ];

        if ( ! function_exists( 'dbDelta' ) ) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        foreach( $schemas as $schema ) {
            dbDelta( $schema );
        }
    }
}
