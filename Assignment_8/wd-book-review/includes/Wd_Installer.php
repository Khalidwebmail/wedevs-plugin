<?php

namespace Book\Reviews;

/**
 * Installer class
 */
class Wd_Installer {

	/**
	 * Run the installer
	 */
	public function wd_run() {
		$this->wd_add_version();
		$this->create_table();
	}

	/**
	 * Check plugin is installed if not insert
	 * install time, and add plugin version
	 *
	 * @return void
	 */
	public function wd_add_version() {
		$installed = get_option( 'wdbr_installed' );

		if ( ! $installed ) {
			update_option( 'wdbr_installed', time() );
		}

		update_option( 'wdbr_version', WDBR_PLUGIN_VERSION );
	}

	/**
	 * Create necessary database tables
	 *
	 * @return void
	 */
	public function create_table() {
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		$schema = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}book_review_rating` (
          `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
          `post_id` int(11) UNSIGNED NOT NULL,
          `user_id` int(11) UNSIGNED NOT NULL,
          `ip` varchar(30) NOT NULL,
          `rating` int(11) NOT NULL,
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