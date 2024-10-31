<?php
/**
 * Prodigy common widget class
 *
 * @version    1.0.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
namespace Prodigy\Includes\Widgets;

use Prodigy\Includes\Prodigy;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Common_Prodigy_Widget
 */
class Prodigy_Common_Widget {

	/**
	 * Common_Prodigy_Widget constructor.
	 */
	public function __construct() {
		$this->change_state_widgets();
	}

	/**
	 * We control state widgets
	 */
	public function change_state_widgets() {
		if (
			empty( is_active_widget( false, false, 'filters_prodigy_widget', false ) )
			&& get_option( 'prodigy_widget_change_default_state_filter' )
		) {
			update_option( 'prodigy_widget_change_default_state_filter', false );
		}
	}

	/**
	 * Show widget on specific pages
	 *
	 * @return bool
	 */
	public static function is_catalog_page() {
		global $wp;
		$result = false;

		$shop = strpos( $wp->request, 'shop' );
		if ( ! empty( Prodigy::get_prodigy_category_type() ) ) {
			$category = strpos( $wp->request, Prodigy::get_prodigy_category_type() );
		}

		if ( ! empty( Prodigy::get_prodigy_tag_type() ) ) {
			$tag = strpos( $wp->request, Prodigy::get_prodigy_tag_type() );
		}

		if ( $shop !== false
			 || $category !== false
			 || $tag !== false
		) {
			$result = true;
		}

		return $result;
	}
}
