<?php
namespace Prodigy\Includes\Migrations;

use Prodigy\Includes\Prodigy;

defined( 'ABSPATH' ) || exit;

/**
 * Class ProdigyMigration106
 */
class Prodigy_Db_Migrations {

	/**
	 * @var wpdb
	 */
	protected $db;

	public function __construct() {
		global $wpdb;
		$this->db = $wpdb;
	}

	/**
	 * @param string $table_name
	 * @param string $column
	 * @return bool
	 */
	private function isColumnExist( $table_name, $column ): bool {
		return (bool) $this->db->get_var( "SHOW COLUMNS FROM `{$this->db->prefix}{$table_name}` LIKE '{$column}';" );
	}

	/**
	 * @param string $table_name
	 * @param string $column
	 * @param array  $settings
	 * @return void
	 */
	private function createColumn( $table_name, $column, $settings ): void {
		if ( $this->isColumnExist( $table_name, $column ) ) {
			return;
		}
		$type     = $settings['type'];
		$default  = ! empty( $settings['default'] ) ? ' default ' . $settings['default'] : '';
		$nullable = $settings['nullable'] ?? '';

		$this->db->query( "ALTER TABLE `{$this->db->prefix}{$table_name}` add `{$column}` {$type} {$nullable} {$default};" );
	}

	/**
	 * @return void
	 */
	public function changeProductTypes() :void {
		$all_slugs = get_option( 'pg_all_slugs_product_type' );
		$slugs     = "'" . implode( "', '", $all_slugs ) . "'";

		$products = $this->db->get_col(
			$this->db->prepare(
				"SELECT * FROM {$this->db->prefix}posts wpp
                        LEFT JOIN {$this->db->prefix}postmeta wppm
                        ON wpp.ID = wppm.post_id
                        WHERE wpp.post_type IN ($slugs)
                        AND wppm.meta_key = '%s'",
				array( Prodigy::PRODIGY_REMOTE_PRODUCT_ID )
			)
		);

		if ( ! empty( $products ) ) {
			$product_ids = "'" . implode( "', '", $products ) . "'";
			$this->db->query( "UPDATE {$this->db->prefix}posts SET post_type = 'prodigy-product' WHERE ID IN ($product_ids)" );
		}
	}


	public function changeCategoryTypes( $slug_type, $meta_key, $new_type ) :void {
		$all_slugs = get_option( $slug_type );
		$slugs     = "'" . implode( "', '", $all_slugs ) . "'";

		$categories = $this->db->get_col(
			$this->db->prepare(
				"SELECT wptt.term_taxonomy_id FROM {$this->db->prefix}term_taxonomy wptt
                    LEFT JOIN {$this->db->prefix}termmeta wpt
                    ON wpt.term_id = wptt.term_id
                    WHERE wptt.taxonomy IN ($slugs)
                    AND wpt.meta_key = '%s'",
				array( $meta_key )
			)
		);

		if ( ! empty( $categories ) ) {
			$category_ids = "'" . implode( "', '", $categories ) . "'";
			$this->db->query(
				$this->db->prepare(
					"UPDATE {$this->db->prefix}term_taxonomy 
							SET taxonomy = '%s' WHERE term_taxonomy_id IN ($category_ids)",
					array( $new_type )
				)
			);
		}
	}


	/**
	 * @return void
	 */
	public function run(): void {
		$this->createColumn(
			'prodigy_orders',
			'deleted_at',
			array(
				'type'    => 'TIMESTAMP',
				'default' => 'NULL',
				'null',
			)
		);
		$this->createColumn(
			'prodigy_attribute_taxonomy',
			'remote_id',
			array(
				'type'    => 'INT(11)',
				'default' => 0,
			)
		);
		$this->createColumn( 'prodigy_user_info', 'email', array( 'type' => 'varchar(100)' ) );
		$this->createColumn(
			'prodigy_user_info',
			'is_show',
			array(
				'type'    => 'tinyint',
				'default' => 0,
			)
		);

		$this->changeProductTypes();
		$this->changeCategoryTypes( 'pg_all_slugs_category_type', 'prodigy_hosted_category_relation', 'prodigy-product-category' );
		$this->changeCategoryTypes( 'pg_all_slugs_tag_type', 'prodigy_tag_remote_id', 'prodigy-product-tag' );

		$this->db->query( "ALTER DATABASE `{$this->db->dbname}` CHARACTER SET utf8 COLLATE utf8_general_ci" );

		update_option( 'prodigy_queue_flush_rewrite_rules', 'yes' );
	}
}
