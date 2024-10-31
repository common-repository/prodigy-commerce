<?php
namespace Prodigy\Includes\Frontend\Mappers;

/**
 * Prodigy search data mapper
 *
 * @version    2.8.6
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Search_Data_Mapper extends Prodigy_Main_Data_Mapper {

	/**
	 * @param array $options
	 *
	 * @return array
	 */
	public function get_default_parameters( array $options ): array {
		$widget = $options['idWidget'] ?? '';
		if ( ! empty( $widget ) ) {
			$options = get_option( $widget );
		}

		$icon_type = 'icon';
		if ( ! empty( $options['prg_style_search_icon']['value']['url'] ) ) {
			$icon_type = 'svg';
		}
		$customizer_shop_options = get_option( 'prodigy_shop_settings' );
		$icon_class              = $options['prg_style_search_icon']['value'] ?? 'icon icon-search';
		$placeholder             = $options['prg_style_search_icon_placeholder'] ?? 'Search';
		$search_type             = $options['type'] ?? 'normal';

		return array(
			'settings'                => $options,
			'customizer_shop_options' => $customizer_shop_options,
			'icon_class'              => $icon_class,
			'placeholder'             => $placeholder,
			'search_type'             => $search_type,
			'icon_type'               => $icon_type
		);
	}
}