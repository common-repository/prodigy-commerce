<?php

namespace Prodigy\Includes\Api\V1;

use Exception;
use Prodigy\Includes\Demo\Exception\Prodigy_Demo_Content_Exception;
use Prodigy\Includes\Demo\Prodigy_Default_Content;
use Prodigy\Includes\Demo\Prodigy_Factory_Demo_Content;
use Prodigy\Includes\Demo\Prodigy_Strategy_Demo_Content;
use WP_REST_Request;

defined( 'ABSPATH' ) || exit;

/**
 * Class CloudPlatform
 */
class Prodigy_Install_Demo_Content {

	/**
	 * CloudPlatform constructor.
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'platform_register_route' ) );
		add_action( 'wp_ajax_install_demo_content', array( $this, 'install_demo_content' ) );
	}

	/**
	 * Import demo content
	 *
	 * @return void
	 */
	public function install_demo_content() {
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'wizard-form' ) ) {
			return;
		}

		$item_demo = isset( $_POST['item_demo'] ) ? sanitize_text_field( wp_unslash( $_POST['item_demo'] ) ) : '';
		if ( ! $this->is_valid_content_item( $item_demo ) ) {
			wp_send_json_error( null, 422 );
		}
		$result = false;
		try {
			$strategy = new Prodigy_Strategy_Demo_Content( Prodigy_Factory_Demo_Content::create( $item_demo ) );
			$result   = $strategy->installDemoContent( $item_demo );
		} catch ( Prodigy_Demo_Content_Exception $exception ) {
			wp_send_json_error( $exception->getMessage(), 422 );
		} catch ( Exception $exception ) {
			wp_send_json_error( $exception->getMessage(), 422 );
		}

		wp_send_json_success( $result );
	}

	/**
	 * Register routes.
	 */
	public function platform_register_route() {

		register_rest_route(
			get_prodigy_plugin_directory_name() . '/v1',
			'demo-content-finish',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'contentInstalled' ),
				'permission_callback' => true,
			)
		);

		register_rest_route(
			get_prodigy_plugin_directory_name() . '/v1',
			'import',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'import_demo_content' ),
				'permission_callback' => true,
			)
		);
	}

	/**
	 * Check if content item is valid.
	 *
	 * @param string $item
	 *
	 * @return bool
	 */
	private function is_valid_content_item( string $item ): bool {
		$result     = true;
		$list_items = Prodigy_Default_Content::getDefaultItems();

		if ( ! key_exists( $item, $list_items ) ) {
			$result = false;
		}

		return $result;
	}

	/**
	 *
	 * @param WP_REST_Request $request_params
	 *
	 * @return void
	 */
	public function store( WP_REST_Request $request_params ) {
		$item = $request_params['item_demo'];

		if ( ! $this->is_valid_content_item( $item ) ) {
			wp_send_json_error( null, 422 );
		}
		$result = false;
		try {
			$strategy = new Prodigy_Strategy_Demo_Content( Prodigy_Factory_Demo_Content::create( $item ) );
			$strategy->parseDemoContent();
			$result = $strategy->installDemoContent( $item );
		} catch ( Prodigy_Demo_Content_Exception $exception ) {
			wp_send_json_error( $exception->getMessage(), 422 );
		} catch ( Exception $exception ) {
			wp_send_json_error( $exception->getMessage(), 422 );
		}

		wp_send_json_success( $result );
	}
}
