<?php

namespace Prodigy\Includes\Support\Addons\Elementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Prodigy_Product;

class ElementorBaseWidget extends \Elementor\Widget_Base {

	/**
	 * @inheritDoc
	 */
	public function get_name(): string {
		return 'pg-widget-page';
	}

	/**
	 * @inheritDoc
	 */
	public function get_icon(): string {
		return 'prgicon-product-description';
	}

	/**
	 * @inheritDoc
	 */
	public function get_categories(): array {
		return array( 'prodigy-addons' );
	}

	/**
	 * @inheritDoc
	 */
	protected function register_controls() {
	}

	/**
	 * @inheritDoc
	 */
	protected function render() {
	}

	/**
	 * @return array
	 */
	protected function prg_get_settings(): array {
		$settings = $this->get_settings_for_display();

		update_option( $this->get_id(), $settings );

		$settings = array_filter(
			$settings,
			function ( $val, $key ) {
				return strpos( $key, 'prg_' ) === 0;
			},
			ARRAY_FILTER_USE_BOTH
		);

		$settings_keys = array_map(
			function ( $value ) {
				return str_replace( 'prg_', '', $value );
			},
			array_keys( $settings )
		);

		$settings             = array_combine( $settings_keys, $settings );
		$settings['idWidget'] = $this->get_id();

		return $settings;
	}
}
