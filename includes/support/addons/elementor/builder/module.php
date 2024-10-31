<?php
namespace Prodigy\Includes\Support\Addons\Elementor\Builder;

use Elementor\Core\Documents_Manager;
use Elementor\TemplateLibrary\Source_Local;
use ElementorPro\Base\Module_Base;
use ElementorPro\Modules\ThemeBuilder\Documents\Theme_Document;
use ElementorPro\Plugin;
use Prodigy\Includes\Support\Addons\Elementor\Builder\Conditions\Prodigy;
use Prodigy\Includes\Support\Addons\Elementor\Builder\Documents\Cart;
use Prodigy\Includes\Support\Addons\Elementor\Builder\Documents\Product;
use Prodigy\Includes\Support\Addons\Elementor\Builder\Documents\Product_Archive;
use Prodigy\Includes\Prodigy as ProdigyPlugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Module extends Module_Base {

	public $docs_types;

	public function __construct() {
		parent::__construct();

		add_action( 'elementor/documents/register', array( $this, 'register_documents' ) );
		add_action( 'elementor/theme/register_conditions', array( $this, 'register_conditions' ), 100 );
		add_filter( 'elementor/theme/need_override_location', array( $this, 'theme_template_include' ), 10, 2 );
	}

	public function theme_template_include( $need_override_location, $location ) {
		if ( is_singular( array( ProdigyPlugin::PRODIGY_POST_TYPE_DEFAULT ) ) && 'single' === $location ) {
			$need_override_location = true;
		}

		return $need_override_location;
	}

	public static function is_active() {
		return true;
	}

	/**
	 * @param Documents_Manager $documents_manager
	 */
	public function register_documents( $documents_manager ) {

		$this->docs_types = array(
			'product-archive-prodigy' => Product_Archive::get_class_full_name(),
			'product-prodigy'         => Product::get_class_full_name(),
		);

		foreach ( $this->docs_types as $type => $class_name ) {
			$documents_manager->register_document_type( $type, $class_name );
		}
	}

	/**
	 * @param $conditions_manager
	 */
	public function register_conditions( $conditions_manager ) {
		$prodigy_condition = new Prodigy();
		$conditions_manager->get_condition( 'general' )->register_sub_condition( $prodigy_condition );
	}

	public function get_name() {
		return 'prodigy';
	}


	public function add_product_post_class( $classes ) {
		$classes[] = 'product';

		return $classes;
	}

	public function add_products_post_class_filter() {
		add_filter( 'post_class', array( $this, 'add_product_post_class' ) );
	}

	public function remove_products_post_class_filter() {
		remove_filter( 'post_class', array( $this, 'add_product_post_class' ) );
	}

	public function get_document( $post_id ) {
		$document = null;

		try {
			$document = Plugin::elementor()->documents->get( $post_id );
		} catch ( \Exception $e ) {
			// Do nothing.
			unset( $e );
		}

		if ( ! empty( $document ) && ! $document instanceof Theme_Document ) {
			$document = null;
		}

		return $document;
	}

	public function get_template_type( $post_id ) {
		return Source_local::get_template_type( $post_id );
	}

	public function is_theme_template( $post_id ) {
		$document = Plugin::elementor()->documents->get( $post_id );

		return $document instanceof Theme_Document;
	}


	public static function is_product_search() {
		return is_search() && ProdigyPlugin::PRODIGY_POST_TYPE_DEFAULT === get_query_var( 'post_type' );
	}

}
