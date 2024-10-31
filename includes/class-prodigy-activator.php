<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @version    2.1.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */

namespace Prodigy\Includes;

use Prodigy\Includes\Content\Prodigy_Product_Attributes;
use Prodigy\Includes\Frontend\Pages\Prodigy_Page;
use Prodigy\Includes\Helpers\Traits\TraitProdigySidebar;

defined( 'ABSPATH' ) || exit;

/**
 * Class Prodigy_Activator
 */
class Prodigy_Activator {
	use TraitProdigySidebar;

	public $prodigy_pages;

	/** @var Prodigy_Options */
	private $options;

	public function __construct() {
		$this->options = new Prodigy_Options();
		$this->prodigy_pages = new Prodigy_Page();
		$this->install_prodigy_pages();
		$this->install_sidebars();
		$this->setDefaultTables();
		$this->setDefaultOptions();


		update_option( 'prodigy_queue_flush_rewrite_rules', 'yes' );
	}

	/**
	 * Install shop page sidebar
	 */
	public function install_sidebars() {
		$attribute_obj = new Prodigy_Product_Attributes();
		$attributes    = $attribute_obj->select_attribute_taxonomy_like_slug( get_option( 'pg_url_domain_hosted_system' ) );

		$filters = array();

		foreach ( $attributes as $key => $attribute ) {
			$filters[ $key ] = $attribute->id;
		}

		$this->delete_sidebars();
		$this->set_filter_widget_settings( $filters );
	}

	/**
	 * @return void
	 */
	public function install_prodigy_pages() :void {
		global $wpdb;

		$prodigy_pages = array(
			Prodigy_Page::PAGE_TYPE_SHOP => array(
				'name'  => _x( 'shop', 'Page slug', 'prodigy' ),
				'title' => _x( 'Shop', 'Page title', 'prodigy' ),
			),
			Prodigy_Page::PAGE_TYPE_CART => array(
				'name'    => _x( 'cart', 'Page slug', 'prodigy' ),
				'title'   => _x( 'Cart', 'Page title', 'prodigy' ),
				'content' => '[prodigy_cart] [prodigy_related_products]',
			),
			Prodigy_Page::PAGE_TYPE_THANK => array(
				'name'    => _x( 'thank-you', 'Page slug', 'prodigy' ),
				'title'   => _x( 'Thank you', 'Page title', 'prodigy' ),
				'content' => '[prodigy_thank_you_page]',
			),
		);

		$page_ids = $this->prodigy_pages->create_pages( $prodigy_pages );
		$this->prodigy_pages->prodigy_pages_update_options( $page_ids );

		if ( defined( 'PRODIGY_VERSION' ) ) {
			update_option( 'PRODIGY_VERSION', PRODIGY_VERSION );
		}
	}



	/**
	 * @return void
	 */
	public function setDefaultTables() :void {
		global $wpdb;
		Prodigy_Install_Wizard::set_tables();
	}

	/**
	 * Activate plugin options
	 *
	 * @return void
	 */
	public function setDefaultOptions() :void {
		$this->options->set_default_options();
		Prodigy::customize_current_theme();
	}

}
