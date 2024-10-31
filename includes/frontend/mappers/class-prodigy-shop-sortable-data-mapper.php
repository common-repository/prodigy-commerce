<?php
namespace Prodigy\Includes\Frontend\Mappers;

use Prodigy\Includes\Frontend\Prodigy_Layouts_Manager;
use Prodigy\Includes\Support\Customizer\Prodigy_Customizer;

/**
 * Prodigy shop sortable
 *
 * @version    3.0.4
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
class Prodigy_Shop_Sortable_Data_Mapper extends Prodigy_Main_Data_Mapper {

	/**
	 * Prepare data and variables to inject in template
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	public function get_default_parameters( array $options ): array {
		$search = '';
		if ( isset( $_GET['_wpnonce'], $_GET['search'] ) || wp_verify_nonce( sanitize_key( $_GET['_wpnonce'] ?? '' ), 'store-nonce' ) ) {
			$search = wp_strip_all_tags( sanitize_text_field( wp_unslash( $_GET['search'] ) ?? '' ) );
		}

		$customizer_shop_options       = get_option( 'prodigy_shop_settings' );
		$prodigy_shop_default_sortable = $customizer_shop_options['prodigy_shop_default_sortable'] ?? '-created_at';

		$show_sorting         = $customizer_shop_options['prodigy_shop_products_sortable'] ?? true;
		$prodigy_shop_sidebar = $customizer_shop_options['prodigy_shop_sidebar_display'] ?? Prodigy_Customizer::PRODIGY_SHOW_SIDEBAR;
		$widget_products      = $elementor_settings['widget_products'] ?? array();

		if ( isset( $widget_products['content_archive_products_content_order_by'] ) &&
			( Prodigy_Layouts_Manager::is_elementor_live_preview() || Prodigy_Layouts_Manager::is_elementor_template() ) ) {
			$show_sorting = true;
			$order        = '';
			if ( isset( $widget_products['content_archive_products_content_order'] )
				&& $widget_products['content_archive_products_content_order'] === 'desc' ) {
				$order = '-';
			}
			$sort_param = $order . $widget_products['content_archive_products_content_order_by'];
		} else {
			$sort_param = $prodigy_shop_default_sortable;
		}

		if ( isset( $_GET['sort'] ) ) {
			$sort_param = sanitize_text_field( wp_unslash( $_GET['sort'] ) );
		}

		$sort_array = array(
			'-created_at' => esc_html__( 'Newness: high to low', 'prodigy' ),
			'created_at'  => esc_html__( 'Newness: low to high', 'prodigy' ),
			'-rating'     => esc_html__( 'Average rating: high to low', 'prodigy' ),
			'rating'      => esc_html__( 'Average rating: low to high', 'prodigy' ),
			'price'       => esc_html__( 'Price: low to high', 'prodigy' ),
			'-price'      => esc_html__( 'Price: high to low', 'prodigy' ),
		);

		$has_sidebar = $prodigy_shop_sidebar === Prodigy_Customizer::PRODIGY_SHOW_FILTER_BUTTON;

		return array(
			'show_sorting'         => $show_sorting,
			'sort_array'           => $sort_array,
			'has_sidebar'          => $has_sidebar,
			'prodigy_shop_sidebar' => $prodigy_shop_sidebar,
			'sort_param'           => $sort_param,
			'search'               => $search,
		);
	}
}
