<?php

namespace My\Crud;

/**
 * Installer class
 */
class Installer {

	public function run() {
		$this->add_version();
		$this->create_table();
	}

	/**
	 * add_version
	 * Store plugin version to db
	 * when install plugin
	 * @return void
	 */
	public function add_version() {
		$installed = get_option( 'wd_crud_installed' );
		if( ! $installed ) {
			update_option( 'wd_crud_installed', time() );
		}
		update_option( 'wd_crud_installed', WD_CRUD_VERSION );
	}

	/**
	 * create_table
	 * Create table with plugin activation
	 * @return void
	 */
	public function create_table() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();

		$schema = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}ac_addresses (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(50) NOT NULL,
            phone VARCHAR(15) NOT NULL,
            address TEXT,
            created_by bigint(20) unsigned NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) $charset_collate";

		if( ! function_exists( 'dbDelta' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		}
		dbDelta( $schema );
	}
}