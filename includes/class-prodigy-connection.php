<?php
namespace Prodigy\Includes;

use Prodigy\Includes\Api\V1\Prodigy_Api_Main;
use Prodigy\Includes\Content\Prodigy_Api_Client;
use Prodigy\Includes\Synchronization\Prodigy_Synchronization;

/**
 * Store connection class
 */
class Prodigy_Connection {

	/** @var object Prodigy_Api_Client  */
	public $api_client;
	public $connection_url;

	/**
	 * @param Prodigy_Api_Client|null $api_client
	 */
	public function __construct( Prodigy_Api_Client $api_client = null ) {
		$this->api_client     = $api_client ?? new Prodigy_Api_Client();
		$this->connection_url = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . Prodigy_Api_Client::API_CONNECTION_URL;
	}

	/**
	 * @param string $token
	 * @return bool
	 */
	public function is_store_already_connected( string $token ) :string {
		$current_token = get_option( 'pg_store_key' );
		return $current_token && $current_token === $token;
	}

	/**
	 * @return bool
	 */
	public function has_connected_store() :bool {
		return (bool) get_option( 'pg_store_key' );
	}

	/**
	 * @param string             $token
	 * @param Prodigy_Api_Client $api_client
	 * @return bool
	 */
	public function connect_store( string $token, Prodigy_Api_Client $api_client ): bool {
		$params = array(
			'api_key'                   => $token,
			'url'                       => get_home_url(),
			'products_callback_path'    => '/wp-json/' . get_prodigy_plugin_directory_name() . '/v1' . Prodigy_Api_Main::API_PRODUCTS_PATH,
			'categories_callback_path'  => '/wp-json/' . get_prodigy_plugin_directory_name() . '/v1' . Prodigy_Api_Main::API_CATEGORIES_PATH,
			'attributes_callback_path'  => '/wp-json/' . get_prodigy_plugin_directory_name() . '/v1' . Prodigy_Api_Main::API_TAXONOMIES_PATH,
			'import_callback_path'      => '/wp-json/' . get_prodigy_plugin_directory_name() . '/v1' . Prodigy_Api_Main::API_IMPORT,
			'cache_reset_callback_path' => '/wp-json/' . get_prodigy_plugin_directory_name() . '/v1' . Prodigy_Api_Main::API_CATALOG_PATH . '/reset',
			'settings_callback_path'    => '/wp-json/' . get_prodigy_plugin_directory_name() . '/v1' . Prodigy_Api_Main::API_SETTINGS_PATH,
			'category_page_path'        => '/' . Prodigy::get_prodigy_category_slug(),
			'product_page_path'         => '/' . Prodigy::get_prodigy_product_slug(),
		);

		$request_connection = $api_client->post_remote_content( $this->connection_url, $params );

		if ( isset( $request_connection['code'] )
			&& $request_connection['code'] === \WP_Http::OK
			&& ! array_key_exists( 'error', $request_connection )
		) {
			update_option( 'pg_store_key', $token );
			update_option( 'pg_domain_hosted_system', $request_connection['data']['attributes']['name'] );
			update_option( 'pg_url_domain_hosted_system', $request_connection['data']['attributes']['subdomain'] );
			update_option( 'pg_step_wizard', 1 );
			update_option( Prodigy_Synchronization::PRODIGY_PROCESS_TYPE_AUTO_SYNC, Prodigy_Synchronization::PRODIGY_AUTO_SYNC );

			return true;
		}

		update_option( 'pg_store_key', false );
		if ( PRODIGY_DEBUG_MODE ) {
			do_action( 'logger', __LINE__ . __METHOD__ . __CLASS__, 'error' );
			do_action( 'logger', $request_connection, 'error' );
		}

		return false;
	}

	/**
	 * @return bool
	 */
	public function disconnect_store() :bool {
		$request_disconnection = $this->api_client->delete_remote_content( $this->connection_url );
        $result['code'] = wp_remote_retrieve_response_code( $request_disconnection );

        if ($result['code'] == \WP_Http::NO_CONTENT) {
            update_option('pg_store_key', '');
            return true;
        } else {
            if (PRODIGY_DEBUG_MODE) {
                do_action('logger', $request_disconnection['message'] . $request_disconnection['code'], 'error');
            }
        }



		$errors = $this->api_client->get_list_errors( $request_disconnection );
		if ( PRODIGY_DEBUG_MODE ) {
			do_action( 'logger', implode( ', ', $errors ) . $status_code, 'error' );
		}

		return false;
	}

}
