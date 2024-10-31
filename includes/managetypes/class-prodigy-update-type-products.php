<?php

/**
 * Prodigy admin product listener class
 *
 * @version 1.0.0
 * @package prodigy/admin
 */
namespace Prodigy\Includes\Managetypes;

use Prodigy\Includes\Content\Prodigy_Api_Client;
use Prodigy\Includes\Helpers\Prodigy_Formatting;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Queue\Prodigy_Background_Process;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Prodigy_Product_Listener
 */
class Prodigy_Update_Type_Products extends Prodigy_Background_Process {

	/**
	 * @var string
	 */
	protected $action = 'pg_update_type_product_queue';

	/**
	 * @param mixed $id
	 *
	 * @return bool|mixed
	 */
	protected function task( $id ) {

		$type = Prodigy::get_prodigy_product_type();

		$arr = array(
			'ID'        => $id,
			'post_type' => $type,
		);

		wp_update_post( $arr );

		return false;
	}

	public function complete() {
		parent::complete();
		update_option( 'pg_access_update_type_products_queue', false );
		$this->update_hs_urls();
		Prodigy::refresh_permalink();
	}

	public function update_hs_urls() {
		$api_client_new = new Prodigy_Api_Client();
		$params         = array(
			'url'                => Prodigy_Formatting::prodigy_format_site_url( site_url() ),
			'category_page_path' => '/' . Prodigy::get_prodigy_category_type(),
			'product_page_path'  => '/' . Prodigy::get_prodigy_product_type(),
		);

		$api_url            = $api_client_new::API_PROTOCOL . PRODIGY_API_DOMAIN . $api_client_new::API_CONNECTION_URL;
		$request_connection = $api_client_new->put_remote_content( $api_url, $params );

		if ( isset( $request_connection['data'] ) ) {
			if ( $request_connection['code'] !== 204 ) {
				if ( PRODIGY_DEBUG_MODE ) {
					do_action( 'logger', __LINE__ . __METHOD__ . __CLASS__, 'error' );
					do_action( 'logger', $request_connection, 'error' );
				}
			}
		}
	}

}
