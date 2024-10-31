<?php
namespace Prodigy\Includes\Content;

defined( 'ABSPATH' ) || exit;

/**
 * Class Prodigy_Content_Order
 *
 * @version 2.0.0
 */
class Prodigy_Order_Parser extends Prodigy_Main_Content {

	/**
	 * Line items data relation
	 */
	const REMOTE_TYPE_LINE_ITEMS = 'line-items';

	/**
	 * Subscription data relation
	 */
	const SUBSCRIPTION_CONDITION = 'subscription-condition';

	/**
	 * Personalization data relation
	 */
	const PERSONALIZATION_FIELDS = 'personalization-fields';

	const CHECKOUT_STATE_CONFIRMATION = 'confirmation';

	/**
	 * Response relation logo-options type of data
	 */
	const LOGO_OPTIONS = 'logo-options';

	/**
	 * Response relation logo type of data
	 */
	const LOGO = 'logos';

	/**
	 * Response relation logo-locations type of data
	 */
	const LOGO_LOCATIONS = 'logo-locations';

	/**
	 * @var $order
	 */
	private $order;

	/**
	 * Status order
	 *
	 * @var string $checkout_state
	 */
	private $checkout_state;

	/**
	 * @param array $order
	 */
	public function __construct( array $order ) {
		parent::__construct();
		$this->order = $order;
		$this->set_checkout_state( $order );
	}

	/**
	 * @param array $order
	 *
	 * @return void
	 */
	public function set_checkout_state( array $order ) {
		$this->checkout_state = isset( $order['data'] ) ? $order['data']['attributes']['checkout-state'] : '';
	}

	/**
	 * @return array
	 */
	public function get_up_sell_products(): array {
		return $this->get_up_sell_products_main( $this->order ?? array() );
	}

	/**
	 * @return array
	 */
	public function get_cross_sell_products(): array {
		return $this->get_cross_sell_products_main( $this->order ?? array() );
	}

	/**
	 * @return array
	 */
	public function get_line_items(): array {
		$id_relationships = array();

		if ( isset( $this->order['data']['relationships'] ) && ! empty( $this->order['data']['relationships'] ) ) {
			$data_parse       = $this->order['data']['relationships'][ self::REMOTE_TYPE_LINE_ITEMS ];
			$id_relationships = wp_list_pluck( $data_parse['data'], 'id', 'id' );
		}

		if ( $this->checkout_state === self::CHECKOUT_STATE_CONFIRMATION ) {
			$info_include = array();
		} else {
			$info_include = $this->parse_included_obj_by_ids( $id_relationships, $this->order, self::REMOTE_TYPE_LINE_ITEMS );
		}

		foreach ( $info_include as $key => $item ) {
			if ( isset( $item['relationships'][ self::LOGO_OPTIONS ]['data'] ) ) {
				$info_include[ $key ]['attributes']['logos'] = $this->get_logos_by_logo_option( $item['relationships']['logo-options']['data'] );
			}
			if ( isset( $item['relationships'][ self::PERSONALIZATION_FIELDS ]['data'] ) ) {
				$ids = array_map(
					function ( $n ) {
						return $n['id'];
					},
					$item['relationships'][ self::PERSONALIZATION_FIELDS ]['data']
				);
				$info_include[ $key ]['attributes']['personalization'] = $this->get_personalizations( $ids );
			}

			foreach ( $this->order['included'] as $included_item ) {
				if ( isset( $item['relationships'][ self::SUBSCRIPTION_CONDITION ]['data']['id'] ) && $item['relationships'][ self::SUBSCRIPTION_CONDITION ]['data']['id'] === $included_item['id'] ) {
					$info_include[ $key ]['subscriptions'] = $included_item;
				}
			}
		}

		return $info_include;
	}


	/**
	 * @param int $logo_option_relation_id
	 *
	 * @return array
	 */
	private function parse_logo_options_by_relation_id( int $logo_option_relation_id = 0 ): array {
		if ( empty( $this->order['included'] ) ) {
			return array();
		}

		$logo           = array();
		$logo_relations = $this->get_order_logo_by_logo_option( $logo_option_relation_id );

		foreach ( $logo_relations as $key => $relation ) {
			$logo[ $key ]['logo']            = $this->get_order_logo_by_relation_and_type( $relation['logo']['data']['id'], self::LOGO );
			$logo[ $key ]['logo']['visible'] = $relation['visible'];
			$logo[ $key ]['location']        = $this->get_order_logo_by_relation_and_type( $relation['logo-location']['data']['id'], self::LOGO_LOCATIONS );
		}

		return $logo;
	}


	/**
	 * @param array $logo_option_relations
	 *
	 * @return array
	 */
	public function get_logos_by_logo_option( array $logo_option_relations ): array {
		$logos = array();
		foreach ( $logo_option_relations as $relation ) {
			$logo_info = $this->parse_logo_options_by_relation_id( $relation['id'] );
			if ( ! empty( $logo_info ) ) {
				$logos[ $relation['id'] ] = reset( $logo_info );
			}
		}

		return $logos;
	}

	/**
	 * @param array $ids
	 *
	 * @return array
	 */
	public function get_personalizations( array $ids ): array {
		$fields = array();
		foreach ( $ids as $id ) {
			foreach ( $this->order['included'] as $key => $relation ) {
				if ( $relation['id'] === $id ) {
					$fields[ $key ][ $relation['id'] ]['label']  = $relation['attributes']['label'] ?? '';
					$fields[ $key ][ $relation['id'] ]['value']  = $relation['attributes']['value'] ?? '';
					$fields[ $key ][ $relation['id'] ]['amount'] = $relation['attributes']['amount'] ?? '';
				}
			}
		}

		return $fields;
	}

	/**
	 * @param int $relation_id
	 *
	 * @return array
	 */
	protected function get_order_logo_by_logo_option( int $relation_id ): array {
		$logo_relation_ids = array();

		if ( empty( $this->order['included'] ) ) {
			return array();
		}

		foreach ( $this->order['included'] as $include ) {
			if ( ! empty( $relation_id ) &&
				(int) $include['id'] === $relation_id &&
				$include['type'] === self::LOGO_OPTIONS
			) {
				$logo_relation_ids[ $relation_id ] = $include['relationships'];
				if ( isset( $include['attributes']['visible'] ) ) {
					$logo_relation_ids[ $relation_id ]['visible'] = $include['attributes']['visible'];
				}
			}
		}

		return $logo_relation_ids;
	}

	/**
	 * @param int    $relation_id
	 * @param string $type
	 *
	 * @return array
	 */
	protected function get_order_logo_by_relation_and_type( int $relation_id, string $type ): array {
		$logo_relation_ids = array();

		if ( empty( $this->order['included'] ) ) {
			return array();
		}

		foreach ( $this->order['included'] as $include ) {
			if ( ! empty( $relation_id ) &&
				(int) $include['id'] === $relation_id &&
				$include['type'] === $type
			) {
				$logo_relation_ids = $include['attributes'];
			}
		}

		return $logo_relation_ids;
	}

	/**
	 * @return false|object
	 */
	public function get_attributes() {
		return $this->order['data']['attributes'] ?? false;
	}

	/**
	 * @return bool
	 */
	public function is_order_item_deleted(): bool {
		$result = false;
		if ( isset( $this->order['data']['attributes'] ) && $this->order['data']['attributes']['item-was-deleted'] ) {
			$result = true;
		}

		return $result;
	}
}
