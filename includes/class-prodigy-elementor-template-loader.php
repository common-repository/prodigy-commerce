<?php

namespace Prodigy\Includes;

use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Item;
use Prodigy\Includes\Helpers\Prodigy_Page;

/**
 * Template Loader
 *
 * @version    2.3.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */

defined( 'ABSPATH' ) || exit;

/**
 * Template loader class.
 */
class Prodigy_Elementor_Template_Loader {

	/**
	 * @return bool
	 */
	public static function is_exclude_shop_template(): bool {
		if ( ! is_page( Prodigy_Page::prodigy_get_page_id( 'shop' ) ) ) {
			return false;
		}

		$elementor_options = get_option( 'elementor_pro_theme_builder_conditions' );
		if ( ! isset( $elementor_options['archive'] ) || ! is_array( $elementor_options['archive'] ) ) {
			return false;
		}

		$exclude = false;
		foreach ( $elementor_options['archive'] as $key => $elementor_option ) {
			if ( ! preg_grep( '/exclude\/product_archive/', $elementor_option ) ) {
				continue;
			}
			if ( preg_grep( '/^exclude\/product_archive\/shop_page$/', $elementor_option ) ) {
				$exclude = true;
				break;
			}
		}

		return $exclude;
	}

	/**
	 * @return bool
	 */
	public static function is_include_shop_template(): bool {
		if ( ! is_page( Prodigy_Page::prodigy_get_page_id( 'shop' ) ) ) {
			return false;
		}

		$elementor_options = get_option( 'elementor_pro_theme_builder_conditions' );
		if ( ! isset( $elementor_options['archive'] ) || ! is_array( $elementor_options['archive'] ) ) {
			return false;
		}

		$include = false;
		foreach ( $elementor_options['archive'] as $key => $elementor_option ) {
			if ( ! preg_grep( '/include\/product_archive/', $elementor_option ) ) {
				continue;
			}
			if ( preg_grep( '/^include\/product_archive\/shop_page$/', $elementor_option ) ) {
				$include = true;
				break;
			}
		}

		return $include;
	}

	/**
	 * @return bool
	 */
	public static function is_exclude_archive_template(): bool {
		if ( ! is_post_type_archive( Prodigy::get_prodigy_product_type() )
			&& ! is_tax( Prodigy::get_prodigy_category_type() )
			&& ! is_tax( Prodigy::get_prodigy_tag_type() )
			&& ! is_page( Prodigy_Page::prodigy_get_page_id( 'shop' ) )
		) {
			return false;
		}

		$elementor_options = get_option( 'elementor_pro_theme_builder_conditions' );
		if ( ! isset( $elementor_options['archive'] ) || ! is_array( $elementor_options['archive'] ) ) {
			return false;
		}

		$exclude = false;
		foreach ( $elementor_options['archive'] as $key => $elementor_option ) {
			if ( ! preg_grep( '/exclude\/product_archive/', $elementor_option ) ) {
				continue;
			}
			if ( preg_grep( '/^exclude\/product_archive$/', $elementor_option )
				|| preg_grep( '/^exclude\/product_archive\/shop_page$/', $elementor_option )
				|| preg_grep( '/^exclude\/product_archive\/' . Prodigy::get_prodigy_category_type() . '$/', $elementor_option )
				|| preg_grep( '/^exclude\/product_archive\/' . Prodigy::get_prodigy_tag_type() . '$/', $elementor_option )
			) {
				$exclude = true;
				break;
			}

			$categories = preg_grep(
				'/include\/product_archive\/' . Prodigy::get_prodigy_category_type() . '(.*)\/(\d)/',
				$elementor_option
			);
			$categories = preg_replace(
				'/include\/product_archive\/' . Prodigy::get_prodigy_category_type() . '(.*)\//',
				'',
				$categories
			);
			$tags       = preg_grep(
				'/include\/product_archive\/' . Prodigy::get_prodigy_tag_type() . '(.*)\/(\d)/',
				$elementor_option
			);
			$tags       = preg_replace(
				'/include\/product_archive\/' . Prodigy::get_prodigy_tag_type() . '(.*)\//',
				'',
				$tags
			);

			if ( ( $categories && is_tax( PRODIGY::get_prodigy_category_type(), $categories ) )
				|| ( $tags && is_tax( Prodigy::get_prodigy_tag_type(), $tags ) )
			) {
				$exclude = true;
				break;
			}
		}

		return $exclude;
	}

	/**
	 * @return bool
	 */
	public static function is_include_archive_template(): bool {
		if ( ! is_post_type_archive( Prodigy::get_prodigy_product_type() )
			&& ! is_tax( Prodigy::get_prodigy_category_type() )
			&& ! is_tax( Prodigy::get_prodigy_tag_type() )
			&& ! is_page( Prodigy_Page::prodigy_get_page_id( 'shop' ) )
		) {
			return false;
		}

		$elementor_options = get_option( 'elementor_pro_theme_builder_conditions' );
		if ( ! isset( $elementor_options['archive'] ) || ! is_array( $elementor_options['archive'] ) ) {
			return false;
		}

		$include = false;
		foreach ( $elementor_options['archive'] as $key => $elementor_option ) {
			if ( ! preg_grep( '/include\/product_archive/', $elementor_option ) ) {
				continue;
			}
			if ( preg_grep( '/^include\/product_archive$/', $elementor_option )
				|| preg_grep( '/^exclude\/product_archive\/shop_page$/', $elementor_option )
				|| preg_grep( '/^include\/product_archive\/' . Prodigy::get_prodigy_category_type() . '$/', $elementor_option )
				|| preg_grep( '/^include\/product_archive\/' . Prodigy::get_prodigy_tag_type() . '$/', $elementor_option )
			) {
				$include = true;
				break;
			}
			$categories = preg_grep(
				'/include\/product_archive\/' . Prodigy::get_prodigy_category_type() . '(.*)\/(\d)/',
				$elementor_option
			);
			$categories = preg_replace(
				'/include\/product_archive\/' . Prodigy::get_prodigy_category_type() . '(.*)\//',
				'',
				$categories
			);
			$tags       = preg_grep(
				'/include\/product_archive\/' . Prodigy::get_prodigy_tag_type() . '(.*)\/(\d)/',
				$elementor_option
			);
			$tags       = preg_replace(
				'/include\/product_archive\/' . Prodigy::get_prodigy_tag_type() . '(.*)\//',
				'',
				$tags
			);

			if ( ( $categories && is_tax( Prodigy::get_prodigy_category_type(), $categories ) )
				|| ( $tags && is_tax( Prodigy::get_prodigy_tag_type(), $tags ) )
			) {
				$include = true;
				break;
			}
		}

		return $include;
	}

	/**
	 * @return bool
	 */
	public static function is_include_single_template(): bool {
		if ( ! is_singular( Prodigy::get_prodigy_product_type() ) ) {
			return false;
		}

		global $post, $prodigy_product;
		$elementor_options = get_option( 'elementor_pro_theme_builder_conditions' );
		if ( ! isset( $elementor_options['single'] ) || ! is_array( $elementor_options['single'] ) ) {
			return false;
		}
		if ( empty( $prodigy_product ) || ( isset( $prodigy_product->id ) && $prodigy_product->get_id() !== $post->ID ) ) {
			$prodigy_product = self::prodigy_get_product( $post );
		}
		$include = false;
		foreach ( $elementor_options['single'] as $elementor_option ) {
			if ( ! preg_grep( '/include\/prodigy-product/', $elementor_option ) ) {
				continue;
			}
			if ( preg_grep( '/^include\/prodigy-product$/', $elementor_option )
				|| preg_grep( '/^include\/prodigy-product\/in_' . Prodigy::get_prodigy_tag_type() . '$/', $elementor_option )
				|| preg_grep( '/^include\/prodigy-product\/in_' . Prodigy::get_prodigy_category_type() . '$/', $elementor_option ) ) {
				$include = true;
				break;
			}
			$categories = preg_grep( '/include\/prodigy-product\/in_' . Prodigy::get_prodigy_category_type() . '(.*)\/(\d)/', $elementor_option );
			$categories = preg_replace( '/include\/prodigy-product\/in_' . Prodigy::get_prodigy_category_type() . '(.*)\//', '', $categories );

			$tags = preg_grep( '/include\/prodigy-product\/in_' . Prodigy::get_prodigy_tag_type() . '(.*)\/(\d)/', $elementor_option );
			$tags = preg_replace( '/include\/prodigy-product\/in_' . Prodigy::get_prodigy_tag_type() . '(.*)\//', '', $tags );

			if (
				has_post_category( end( $categories ), $post ) ||
				has_post_tag( end( $tags ), $post )
			) {
				$include = true;
				break;
			}
		}

		return $include;
	}

	/**
	 * @return bool
	 */
	public static function is_exclude_single_template(): bool {
		if ( ! is_singular( Prodigy::get_prodigy_product_type() ) ) {
			return false;
		}

		global $post, $prodigy_product;
		$elementor_options = get_option( 'elementor_pro_theme_builder_conditions' );
		if ( ! isset( $elementor_options['single'] ) || ! is_array( $elementor_options['single'] ) ) {
			return false;
		}
		if ( empty( $prodigy_product ) ) {
			$product_template = new Prodigy_Product_Template_Builder( new Prodigy_Product_Template_Item() );
			$prodigy_product  = $product_template->get_product( (int) ( $post->ID ?? 0 ) );
		}
		$exclude = false;
		foreach ( $elementor_options['single'] as $elementor_option ) {
			if ( ! preg_grep( '/exclude\/prodigy-product/', $elementor_option ) ) {
				continue;
			}
			if ( preg_grep( '/^include\/prodigy-product$/', $elementor_option )
				|| preg_grep( '/^include\/prodigy-product\/in_' . Prodigy::get_prodigy_tag_type() . '$/', $elementor_option )
				|| preg_grep( '/^include\/prodigy-product\/in_' . Prodigy::get_prodigy_category_type() . '$/', $elementor_option ) ) {
				$include = true;
				break;
			}
			$categories = preg_grep( '/include\/prodigy-product\/in_' . Prodigy::get_prodigy_category_type() . '(.*)\/(\d)/', $elementor_option );
			$categories = preg_replace( '/include\/prodigy-product\/in_' . Prodigy::get_prodigy_category_type() . '(.*)\//', '', $categories );

			$tags = preg_grep( '/include\/prodigy-product\/in_' . Prodigy::get_prodigy_tag_type() . '(.*)\/(\d)/', $elementor_option );
			$tags = preg_replace( '/include\/prodigy-product\/in_' . Prodigy::get_prodigy_tag_type() . '(.*)\//', '', $tags );

			if ( has_post_category( array_shift( $categories ) ?? -1, $post ) || has_post_tag( array_shift( $tags ) ?? -1, $post ) ) {
				$exclude = true;
				break;
			}
		}

		return $exclude;
	}

	/**
	 * @return bool
	 */
	public static function is_elementor_page(): bool {
		return false;
		$shop_page_id = Prodigy_Page::prodigy_get_page_id( 'shop' );
		if ( ! is_page( $shop_page_id ) ) {
			return false;
		}
		if ( get_post_meta( $shop_page_id, '_elementor_edit_mode', true ) === 'builder' ) {
			return true;
		}

		return false;
	}

	/**
	 * @return bool
	 */


	/**
	 * @return bool
	 */
	public static function is_use_archive_template(): bool {
		return self::is_include_archive_template() || self::is_exclude_archive_template()
				|| self::is_include_shop_template() || self::is_exclude_shop_template();
	}

	/**
	 * @return bool
	 */
	public static function is_use_product_template(): bool {
		return ( self::is_include_single_template() || self::is_exclude_single_template() );
	}

	/**
	 * @param array|null $options
	 *
	 * @return bool
	 */
	public static function is_live_mode( array $options = null ): ?bool {
		return isset( $options );
	}

	/**
	 * @param $post
	 *
	 * @return false|Frontend\Prodigy_Product_Template_Item|null
	 */
	public static function prodigy_get_product( $post ) {
		$product_id = self::prodigy_get_product_id( $post );

		if ( ! $product_id ) {
			return false;
		}

		$product_template = new Prodigy_Product_Template_Builder( new Prodigy_Product_Template_Item() );

		return $product_template->get_product( (int) $product_id );
	}

	/**
	 * @param $product
	 *
	 * @return false|float|int|mixed|string
	 */
	public static function prodigy_get_product_id( $product ) {
		global $post;

		if ( false === $product && isset( $post, $post->ID ) && Prodigy::PRODIGY_POST_TYPE_DEFAULT === get_post_type( $post->ID ) ) {
			return absint( $post->ID );
		} elseif ( is_numeric( $product ) ) {
			return $product;
		} elseif ( is_object( $product ) ) {
			return $product->id;
		} elseif ( ! empty( $product->ID ) ) {
			return $product->ID;
		} else {
			return false;
		}
	}
}
