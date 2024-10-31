<?php
/**
 * Migration Class
 *
 * @version    2.1.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
namespace Prodigy\Includes\Migrations;

use Prodigy\Includes\Helpers\Traits\TraitProdigySidebar;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Prodigy_Cache;
use Prodigy\Includes\Prodigy_Options;
use Prodigy\Includes\Support\Customizer\Prodigy_Customizer;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Prodigy_Migration class.
 */
class Prodigy_Migration {
	use TraitProdigySidebar;

	protected $current_version;

	/** @var object Prodigy_Db_Migrations  */
	protected $db_migrations;

	public $cache;

	/** @var Prodigy_Options */
	private $options;

	/**
	 * ProdigyMigration constructor.
	 */
	public function __construct() {
		$this->options = new Prodigy_Options();
		$this->current_version = get_option( 'PRODIGY_VERSION' );
		$this->db_migrations   = new Prodigy_Db_Migrations();
		$this->cache = new Prodigy_Cache();

	}

	/**
	 * check upgrade
	 */
	public function runUpgradeProcess() {
		if ( $this->isRunProcess() ) {
			$this->set_default_options();
			$this->setCustomizerSettings();
			$this->updateDb();
			$this->updatePluginVersion();
			$this->cache->clear();
		}
	}

	/**
	 * @return void
	 */
	private function setCustomizerSettings() {
		$this->setDefaultCustomizerOptions();
		$this->updateCustomizerCartOptionType();
		$this->addNumberPerPageOption();
	}

	/**
	 * @return void
	 */
	private function addNumberPerPageOption() {
		$customizer_options = get_option( 'prodigy_shop_settings', array() );
		if ( isset( $customizer_options['prodigy_shop_products_rows_per_page'] ) ) {
			$rows    = $customizer_options['prodigy_shop_products_rows_per_page'];
			$columns = $customizer_options['prodigy_shop_products_per_row'] ?? Prodigy_Customizer::PRODIGY_PRODUCTS_NUMBER_COLUMNS;
			$customizer_options['prodigy_shop_products_number_items_per_page'] = $rows * $columns;
			update_option( 'prodigy_shop_settings', $customizer_options );
		}
	}

	/**
	 * @return void
	 */
	private function updateCustomizerCartOptionType() {
		$customizer_general_options = get_option( 'prodigy_general_options', array() );
		$cart_widget_option         = $customizer_general_options['prodigy_enable_cart_widget'] ?? false;
		$locations                  = get_nav_menu_locations();
		if (
			$cart_widget_option &&
			is_array( $locations ) &&
			! isset( $customizer_general_options['prodigy_cart_widget_locations'] )
		) {
			$customizer_general_options['prodigy_cart_widget_locations'] = key( $locations );
			update_option( 'prodigy_general_options', $customizer_general_options );
		}
	}

	/**
	 * @return void
	 */
	private function setDefaultCustomizerOptions() {
		$options = get_option( 'theme_mods_' . get_stylesheet() );
		if ( isset( $options['prodigy_general_options'] ) && ( get_option( 'prodigy_general_options' ) === false ) ) {
			add_option( 'prodigy_general_options', $options['prodigy_general_options'] );
		}

		if ( isset( $options['prodigy_product_settings'] ) && ( get_option( 'prodigy_product_settings' ) === false ) ) {
			add_option( 'prodigy_product_settings', $options['prodigy_product_settings'] );
		}

		if ( isset( $options['prodigy_shop_settings'] ) && ( get_option( 'prodigy_shop_settings' ) === false ) ) {
			add_option( 'prodigy_shop_settings', $options['prodigy_shop_settings'] );
		}
	}

	/**
	 * @return bool
	 */
	private function updatePluginVersion(): bool {
		return update_option( 'PRODIGY_VERSION', PRODIGY_VERSION );
	}

	/**
	 * @return void
	 */
	private function updateDb() {
		$this->db_migrations->run();
	}

	/**
	 * Set default customizer, HS and other options
	 *
	 * @return void
	 */
	private function set_default_options() {
		Prodigy::customize_current_theme();
		$this->options->set_default_options();
		$this->delete_excess_block_from_sidebar();
		$this->hide_search_widget();
	}

	/**
	 * @return void
	 */
	private function hide_search_widget() {
		$is_need_version = version_compare( $this->current_version, '2.2.1', '<=' );
		if ( $is_need_version ) {
			$customizer_options  = get_option( 'prodigy_shop_settings', array() );
			$customizer_options['prodigy_shop_search_bar'] = false;
			update_option( 'prodigy_shop_settings', $customizer_options );
		}
	}

	/**
	 * @return bool
	 */
	private function isRunProcess(): bool {
		if ( strpos( $this->current_version, '.' ) === false ) {
			$result = true;
		} else {
			$result = version_compare( $this->current_version, PRODIGY_VERSION, '<' );
		}

		return $result;
	}
}
