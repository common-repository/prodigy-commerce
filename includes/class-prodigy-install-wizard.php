<?php

/**
 * Fired during plugin activation
 *
 * @version 1.0.0
 * @package prodigy/includes
 */
namespace Prodigy\Includes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once ABSPATH . 'wp-admin/includes/upgrade.php';

/**
 * Class Prodigy_Install_Wizard
 */
class Prodigy_Install_Wizard {

	/**
	 * Set table after plugin install
	 * if run unit-tests this func off or return of first
	 */
	public static function set_tables() {
		global $wpdb;

		$collate                    = self::get_charset_collate();
		$tables                     = '';
		$prodigy_attribute_taxonomy = $wpdb->prefix . 'prodigy_attribute_taxonomy';
		$like                       = '%' . $wpdb->prefix . 'prodigy_attribute_taxonomy%';
		if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $like ) ) != $prodigy_attribute_taxonomy ) {
			$tables .= "
            CREATE TABLE {$prodigy_attribute_taxonomy} (
                 id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                 slug  varchar(200),
                 name varchar(200),
                 order_by tinyint(1) default 0,
                 public tinyint(1) default 1,
				 remote_id INT(11) default 0,
                 constraint wp_prodigy_attribute_taxonomy_slug_uindex unique (slug)
            ) $collate;";
		}

		$prodigy_orders = $wpdb->prefix . 'prodigy_orders';
		$like_orders    = '%' . $wpdb->prefix . 'prodigy_orders%';
		if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $like_orders ) ) != $prodigy_orders ) {
			$tables .= " 
            CREATE TABLE {$prodigy_orders} (
                 id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                 local_user_hash varchar(255) NOT NULL,
                 order_number int(11) NOT NULL,
                 token varchar(255) NOT NULL,
                 status TINYINT(1) default 0,
                 includes text,
                 deleted_at timestamp null default NULL,
                 created_at timestamp default CURRENT_TIMESTAMP,
                 updated_at timestamp default CURRENT_TIMESTAMP
            ) $collate;";
		}

		$prodigy_user_info = $wpdb->prefix . 'prodigy_user_info';
		$like_user_info    = '%' . $wpdb->prefix . 'prodigy_user_info%';
		if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $like_user_info ) ) != $prodigy_user_info ) {
			$tables .= " 
            CREATE TABLE {$prodigy_user_info} (
                 id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                 user_session_hash varchar(255) NOT NULL,
                 name varchar(255)
            ) $collate;";
		}

		if ( ! empty( $tables ) ) {
			dbDelta( $tables );
		}
	}

	/**
	 * Set collate for custom tables
	 *
	 * @return string
	 */
	public static function get_charset_collate() {
		return 'ENGINE=InnoDB DEFAULT CHARSET=utf8';
	}
}
