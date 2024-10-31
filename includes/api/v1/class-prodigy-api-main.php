<?php
namespace Prodigy\Includes\Api\V1;

use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Prodigy_Cache;

defined( 'ABSPATH' ) || exit;
/**
 * Class Prodigy_Api_Main
 */
class Prodigy_Api_Main {

	const API_SETTINGS_PATH         = '/settings';
	const API_PRODUCTS_PATH         = '/products';
	const API_ATTRIBUTES_PATH       = '/attributes/';
	const API_TAXONOMIES_PATH       = '/taxonomies';
	const API_CATEGORIES_PATH       = '/categories';
	const API_BATCH_CATEGORIES_PATH = '/categories/batches';
	const API_CATALOG_PATH          = '/catalog';
	const API_IMPORT                = '/import';
	const API_TAGS_PATH             = '/tags/';
	const API_BATCH_TAGS_PATH       = '/tags/batches';
	const API_PRODUCTS_REVIEWS      = '/products/reviews';

	/** @var object Prodigy_Cache */
	public $cache;

	/**
	 * @var array
	 */
	protected static array $exception_slug = array(
		'attachment',
		'attachment_id',
		'author',
		'author_name',
		'calendar',
		'cat',
		'category',
		'category__and',
		'category__in',
		'category__not_in',
		'category_name',
		'comments_per_page',
		'comments_popup',
		'customize_messenger_channel',
		'customized',
		'cpage',
		'day',
		'debug',
		'error',
		'exact',
		'feed',
		'fields',
		'hour',
		'link_category',
		'm',
		'minute',
		'monthnum',
		'more',
		'name',
		'nav_menu',
		'nonce',
		'nopaging',
		'offset',
		'order',
		'orderby',
		'p',
		'page',
		'page_id',
		'paged',
		'pagename',
		'pb',
		'perm',
		'post',
		'post__in',
		'post__not_in',
		'post_format',
		'post_mime_type',
		'post_status',
		'post_tag',
		'post_type',
		'posts',
		'posts_per_archive_page',
		'posts_per_page',
		'preview',
		'robots',
		's',
		'search',
		'second',
		'sentence',
		'showposts',
		'static',
		'subpost',
		'subpost_id',
		'tag',
		'tag__and',
		'tag__in',
		'tag__not_in',
		'tag_id',
		'tag_slug__and',
		'tag_slug__in',
		'taxonomy',
		'tb',
		'term',
		'theme',
		'type',
		'w',
		'withcomments',
		'withoutcomments',
		'year',
	);

	/**
	 * CloudPlatform constructor.
	 */
	public function __construct() {
		$this->cache = new Prodigy_Cache();
	}

	/**
	 * @param string|null $key Authorization key.
	 *
	 * @return bool
	 */
	public function is_authorization( ?string $key ): bool {
		return ( get_option( 'pg_store_key' ) === $key );
	}

	/**
	 * @param int $remote_product_id
	 *
	 * @return object|null
	 */
	public function exists_relationship_product_id( int $remote_product_id ): ?object {
		return Prodigy_Product_Template_Builder::get_product_meta_by_remote_id( Prodigy::PRODIGY_REMOTE_PRODUCT_ID, $remote_product_id );
	}

	/**
	 * @param string $type_slug
	 *
	 * @return bool
	 */
	public static function is_valid_name_slug( string $type_slug ): bool {
		$result = true;

		if ( in_array( $type_slug, self::get_list_exception_slug(), true ) ) {
			$result = false;
		}

		return $result;
	}

	/**
	 * @return array
	 */
	public static function get_list_exception_slug(): array {
		return self::$exception_slug;
	}
}
