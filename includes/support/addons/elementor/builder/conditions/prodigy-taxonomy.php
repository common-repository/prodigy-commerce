<?php
namespace Prodigy\Includes\Support\Addons\Elementor\Builder\Conditions;

use ElementorPro\Modules\QueryControl\Module as QueryModule;
use ElementorPro\Modules\ThemeBuilder\Conditions as ThemeBuilderCondition;
use ElementorPro\Modules\ThemeBuilder\Conditions\In_Sub_Term;
use ElementorPro\Modules\ThemeBuilder\Conditions\In_Taxonomy;
use ElementorPro\Modules\ThemeBuilder\Conditions\Post_Type_By_Author;
use Prodigy\Includes\Prodigy as ProdigyPlugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class ProdigyTaxonomy extends In_Taxonomy {

	/**
	 * @var \WP_Taxonomy
	 */
	private $taxonomy;

	public function __construct( $data ) {
		parent::__construct( $data );

		$this->taxonomy = $data['object'];
	}

	public function get_label() {
		/* translators: %s: Taxonomy label. */
		return sprintf( esc_html__( '%s', 'elementor-pro' ), $this->taxonomy->labels->singular_name );
	}

	protected function register_controls() {
		$this->add_control(
			'taxonomy',
			array(
				'section'        => 'settings',
				'type'           => QueryModule::QUERY_CONTROL_ID,
				'select2options' => array(
					'dropdownCssClass' => 'elementor-conditions-select2-dropdown',
				),
				'autocomplete'   => array(
					'object'   => QueryModule::QUERY_OBJECT_TAX,
					// 'display' => 'detailed',
					'by_field' => 'term_id',
					'query'    => array(
						'taxonomy' => $this->taxonomy->name,
					),
				),
			)
		);
	}
}
