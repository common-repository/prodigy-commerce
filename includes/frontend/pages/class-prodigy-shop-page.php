<?php

/**
 * Prodigy shop page class
 *
 * @version    2.8.9
 * @package    prodigy/includes/public/pages
 */

namespace Prodigy\Includes\Frontend\Pages;

use Prodigy\Includes\Frontend\Mappers\Prodigy_Active_Filter_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Filter_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Price_Filter_Data_Mapper;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Shop_Data_Mapper;
use Prodigy\Includes\Frontend\Prodigy_Public;
use Prodigy\Includes\Frontend\Shortcodes\Prodigy_Short_Code_Active_Filter;
use Prodigy\Includes\Content\Prodigy_Catalog_Filters_Parser;
use Prodigy\Includes\Content\Prodigy_Catalog_Products_Parser;
use Prodigy\Includes\Content\Prodigy_Request_Maker;
use Prodigy\Includes\Helpers\Prodigy_Template;
use Prodigy\Includes\Models\Prodigy_Categories;
use Prodigy\Includes\Models\Prodigy_Taxonomies;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Prodigy_Pagination;
use Prodigy\Includes\Support\Prodigy_Themes_Support;
use Prodigy\Includes\Helpers\Prodigy_Page;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Prodigy_Product_Page
 */
class Prodigy_Shop_Page extends Prodigy_Page {

	const NUMBER_ITEMS_PER_PAGE = 9;

	/**
	 * Prodigy_All_Products_Page constructor.
	 */
	public function __construct() {
		$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_url( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
		$page_id     = isset( $_GET['page_id'] ) ? sanitize_key( wp_unslash( $_GET['page_id'] ) ) : 1;
		$current_url = isset( $page_id ) ? $request_uri : wp_parse_url( $request_uri, PHP_URL_PATH );
		$taxonomy    = $this->get_taxonomy_form_url();

		if ( self::is_archive_page_url( $current_url, $taxonomy ) ) {
			$priority = 10;
			if ( isset( wp_get_theme()->template ) &&
				wp_get_theme()->template === Prodigy_Themes_Support::PRODIGY_DIVI_THEME
			) {
				$priority = 210;
			}
			add_filter( 'template_include', array( $this, 'prodigy_elementor_shop_render' ), $priority );
		}

		add_action( 'wp_ajax_prodigy-load-shop-filters', array( $this, 'prodigy_get_catalog_filters' ) );
		add_action( 'wp_ajax_nopriv_prodigy-load-shop-filters', array( $this, 'prodigy_get_catalog_filters' ) );

		add_action( 'wp_ajax_prodigy-load-shop-products', array( $this, 'prodigy_get_catalog_products' ) );
		add_action( 'wp_ajax_nopriv_prodigy-load-shop-products', array( $this, 'prodigy_get_catalog_products' ) );

		add_action( 'wp_head', array( $this, 'prodigy_set_meta_tags' ) );
	}

	/**
	 * @return string
	 */
	public function get_taxonomy_form_url(): string {
		$taxonomy = '';

		if ( isset( $_GET[ Prodigy::get_prodigy_category_type() ] ) &&
			sanitize_text_field( wp_unslash( $_GET[ Prodigy::get_prodigy_category_type() ] ) )
		) {
			$taxonomy = Prodigy::get_prodigy_category_type();
		}
		if ( isset( $_GET[ Prodigy::get_prodigy_tag_type() ] ) &&
			sanitize_text_field( wp_unslash( $_GET[ Prodigy::get_prodigy_tag_type() ] ) )
		) {
			$taxonomy = Prodigy::get_prodigy_tag_type();
		}

		return $taxonomy;
	}

	/**
	 * Set meta tags from hosted system
	 *
	 * @return void
	 */
	public function prodigy_set_meta_tags() {
		$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_url( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
		$url_params  = wp_parse_url( $request_uri );
		$path        = explode( '/', sanitize_url( $url_params['path'] ) );
		$is_category = false;
		foreach ( $path as $key => $part ) {
			if ( ! empty( $part ) && $part === Prodigy::get_prodigy_category_type() ) {
				$is_category = true;
				unset( $path[ $key ] );
				$new_array = array_values( array_diff( $path, array( '' ) ) );
			}
		}

		if ( $is_category ) {
			$category_term = Prodigy_Taxonomies::get_taxonomy_by_different_slugs(
				Prodigy::get_prodigy_category_type(),
				$new_array[0] ?? ''
			);

			if ( isset( $category_term->term_id ) ) {
				$description = get_term_meta( $category_term->term_id, Prodigy_Categories::CATEGORY_META_DESCRIPTION, true );
				$title       = get_term_meta( $category_term->term_id, Prodigy_Categories::CATEGORY_META_TITLE, true );
				?>
				<script>document.title = "<?php echo esc_attr( $title ); ?>"</script>
				<meta name="description" content="<?php echo esc_attr( $description ); ?>"/>
				<?php
			}
		}
	}

	/**
	 * @param array $params
	 *
	 * @return array
	 */
	public function prepare_params( array $params ): array {
		unset( $params['action'], $params['_'] );

		return $params;
	}

	/**
	 * Render shop page with ajax
	 */
	public function prodigy_get_catalog_products(): array {
		$params          = $this->prepare_params( $_GET ?? array() );
		$products_parser = new Prodigy_Catalog_Products_Parser();
		$query_params    = $products_parser->set_query_catalog_params( $params );
		$category        = $products_parser->get_catalog_category_param( $params['tax_slug'] ?? '', $params['tax_name'] ?? '' );
		if ( ! empty( $category ) ) {
			$query_params = $category . '&' . $query_params;
		}
		$query_string = $products_parser->catalog_query_builder( $query_params, (int) $products_parser->get_number_per_page() );
		$content      = Prodigy_Request_Maker::get_instance()->do_catalog_products_request( $query_string );
		$products     = $products_parser::get_products( $content );
		$total_number = $products[0]['attributes']['products-count'] ?? 0;
		unset( $params['tax_slug'], $params['tax_name'] );

		$query = isset( $_SERVER['QUERY_STRING'] ) ? sanitize_url( wp_unslash( $_SERVER['QUERY_STRING'] ) ) : '';
		$pg    = isset( $_GET['pg'] ) ? sanitize_key( wp_unslash( $_GET['pg'] ) ) : 1;

		$sort_params = array(
			'paged'       => Prodigy_Pagination::get_current_page( $params ),
			'count_items' => count( $products ),
			'total_count' => $total_number ?? 0,
			'url'         => $query,
		);

		$product_template = empty( $products ) ? 'shop/no-search-results.php' : 'shop/products-loop.php';
		$page             = $pg;

		$count_pages = 1;
		if ( ! empty( $products ) ) {
			$total_number    = ! empty( $total_number ) ? (int) $total_number : 1;
			$number_per_page = $products_parser->get_number_per_page();
			$count_pages     = Prodigy_Pagination::calculate_count_pages( $total_number, $number_per_page );
		}

		$pagination_params = array(
			'pages'       => $count_pages,
			'url'         => $this->get_catalog_url( $query_string ),
			'page'        => Prodigy_Pagination::get_current_page( $params ),
			'page_number' => $page,
		);

		$pagination_template = empty( $pagination_params['pages'] ) ? '' : 'shop/pagination.php';

		$result = array(
			'pagination' => $pagination_params,
			'sort'       => Prodigy_Template::prodigy_get_template_html( $pagination_template, array( 'data' => $sort_params ) ),
		);

		if ( wp_doing_ajax() ) {
			$result['pagination']        = Prodigy_Template::prodigy_get_template_html( 'shop/pagination.php', array( 'data' => $pagination_params ) );
			$result['pagination_list']   = Prodigy_Template::prodigy_get_template_html( 'shop/pagination.php', array( 'data' => $pagination_params ) );
			$data_mapper                 = new Prodigy_Shop_Data_Mapper();
			$data['content']['products'] = $products;
			$parameters                  = $data_mapper->get_default_parameters( $data );
			$result['products']          = Prodigy_Template::prodigy_get_template_html( $product_template, $parameters );
			wp_send_json_success( $result );
		}

		$result['products'] = $products;

		return $result;
	}


	/**
	 * Render shop page with ajax
	 */
	public function prodigy_get_catalog_filters() {
		$query        = $this->prepare_params( $_GET ?? array() );
		$filterParser = new Prodigy_Catalog_Filters_Parser();
		$category     = $filterParser->get_catalog_category_param( $query['tax_slug'] ?? '', $query['tax_name'] ?? '' );
		$query_params = $filterParser->set_query_catalog_params( $query );
		if ( ! empty( $category ) ) {
			$query_params = $category . '&' . $query_params;
		}

		$query_string              = $filterParser->catalog_query_builder( $query_params, (int) $filterParser->get_number_per_page() );
		$content                   = Prodigy_Request_Maker::get_instance()->do_catalog_filters_request( $query_string );
		$filter                    = $filterParser::get_attributes( $content );
		$active_shortcode          = new Prodigy_Short_Code_Active_Filter();
		$filter_widget_options     = get_option( 'widget_filters_prodigy_widget' );
		$key_filter_widget_options = key( array_filter( $filter_widget_options, 'is_int', ARRAY_FILTER_USE_KEY ) );

		$query     = isset( $_POST['query'] ) ? sanitize_text_field( wp_unslash( $_POST['query'] ) ) : '';
		$filter_id = isset( $_GET['filter_widget_id'] ) ? sanitize_key( wp_unslash( $_GET['filter_widget_id'] ) ) : '';

		$filter_widget_params = array();
		if ( ! empty( $filter ) ) {
			$filter_widget_params = array(
				'filters' => $filter,
				'query'   => $query,
				'options' => $filter_widget_options,
			);
		}

		if ( wp_doing_ajax() ) {
			$mapper_filter             = new Prodigy_Active_Filter_Data_Mapper();
			$options['attr_shortcode'] = $mapper_filter->get_widget_settings();
			$active_filter_params      = $mapper_filter->get_default_parameters( $options );
			$result['active']          = Prodigy_Template::prodigy_get_template_html( 'shortcode/active-filters.php', $active_filter_params );
			$filters                   = new Prodigy_Filter_Data_Mapper();
			$options                   = get_option( 'pg_elementor_filter_widget_' . $filter_id, array() );
			$filters_params            = $filters->get_default_parameters( $options );
			$result['filters']         = Prodigy_Template::prodigy_get_template_html( $filters_params['layout'], $filters_params );
			$price_filter              = new Prodigy_Price_Filter_Data_Mapper();
			$price_filter_params       = $price_filter->get_default_parameters();
			$result['price_filter']    = Prodigy_Template::prodigy_get_template_html( 'shortcode/price-filter.php', $price_filter_params );

			wp_send_json_success( $result );
		}

		$result['active'] = $active_shortcode->output( $filter_widget_options[ $key_filter_widget_options ] ?? array(), null, $filter_widget_params );

		return $result;
	}

	/**
	 * @param string $query
	 *
	 * @return string
	 */
	public function get_catalog_url( string $query ): string {
		global $wp;

		$url       = isset( $_GET['current_url'] ) ? sanitize_url( wp_unslash( $_GET['current_url'] ) ) : '';
		$attr      = isset( $_GET['attr'] ) ? sanitize_text_field( wp_unslash( $_GET['attr'] ) ) : '';
		$max_price = isset( $_GET['price_max'] ) ? sanitize_text_field( wp_unslash( $_GET['price_max'] ) ) : '';
		$min_price = isset( $_GET['price_min'] ) ? sanitize_text_field( wp_unslash( $_GET['price_min'] ) ) : '';
		$sort      = isset( $_GET['sort'] ) ? sanitize_text_field( wp_unslash( $_GET['sort'] ) ) : '';
		$page_id   = isset( $_GET['page_id'] ) ? sanitize_key( wp_unslash( $_GET['page_id'] ) ) : '';

		$current_url = $url ?? home_url( $wp->request );

		if ( ! empty( $attr ) && ! empty( $current_url ) ) {
			$args = array();
			foreach ( $attr as $key => $value ) {
				$args[ 'attr[' . $key . ']' ] = $value;
			}
			$current_url = add_query_arg( $args, $current_url );
		}

		if ( ! empty( $max_price ) && ! empty( $min_price ) ) {
			$args        = array(
				'price_max' => $max_price,
				'price_min' => $min_price,
			);
			$current_url = add_query_arg( $args, $current_url );
		}

		if ( ! empty( $sort ) ) {
			$args        = compact( 'sort' );
			$current_url = add_query_arg( $args, $current_url );
		}

		if ( wp_doing_ajax() && ! empty( $page_id ) ) {
			$params = $_GET;
			unset( $params['current_url'] );
			$current_url = home_url( $wp->request ) . '?' . http_build_query( $params );
		}

		return remove_query_arg( 'pg', $current_url );
	}

	/**
	 * Render shop page
	 */
	public function prodigy_elementor_shop_render() {
		if ( Prodigy_Public::skip() ) {
			return;
		}

		$this->render_catalog_template();
	}

	/**
	 * @return void
	 */
	private function render_catalog_template() {
		$content_shop = $this->prodigy_get_catalog_products();
		Prodigy_Template::prodigy_get_template( 'archive-product.php', array( 'content' => $content_shop ) );
	}

	/**
	 * @param string $url
	 * @param string $taxonomy
	 *
	 * @return bool
	 */
	public static function is_archive_page_url( string $url, string $taxonomy = '' ): bool {
		$is_shop = false;

		if ( isset( $_GET['page_id'] ) && Prodigy_Page::prodigy_get_page_id( 'shop' ) === (int) $_GET['page_id'] ) {
			return true;
		}

		$url_params = wp_parse_url( $url );
		$path       = explode( '/', $url_params['path'] );
		$page_id    = Prodigy_Page::prodigy_get_page_id( 'shop' );
		foreach ( $path as $slug ) {
			if ( ! empty( $slug ) && self::is_shop_page( $slug, $page_id ) ) {
				$is_shop = true;
				break;
			}
		}

		if ( ! empty( $taxonomy ) ) {
			$is_shop = self::is_shop_page( $taxonomy, $page_id );
		}

		return $is_shop;
	}

	/**
	 * @param string $slug
	 * @param int    $page_id
	 *
	 * @return bool
	 */
	public static function is_shop_page( string $slug, int $page_id ): bool {
		$post = get_post( $page_id );

		return $slug === Prodigy::get_prodigy_category_slug() ||
				$slug === Prodigy::get_prodigy_tag_slug() ||
				$slug === Prodigy::get_prodigy_category_type() ||
				$slug === Prodigy::get_prodigy_tag_type() ||
				( isset( $post ) && $slug === $post->post_name );
	}
}
