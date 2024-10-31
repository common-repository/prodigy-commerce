<?php

namespace Prodigy\Includes;

use Prodigy\Includes\Demo\Exception\Prodigy_Demo_Content_Exception;
use Prodigy\Includes\Content\Prodigy_Api_Client;
use Prodigy\Includes\Synchronization\Content\Prodigy_Process_Factory;

defined( 'ABSPATH' ) || exit;

class Prodigy_Synchronization {

	const PRODIGY_SYNC_STATUS             = 'prodigy_synchronization_status';
	const PRODIGY_NEEDS_SYNC_NOTIFICATION = 'prodigy_needs_sync_notification';
	const PRODIGY_SYNC_MESSAGE_OPTION     = 'prodigy_sync_message_option';
	const PRODIGY_SYNCHRONIZATION_TYPE    = 'prodigy_synchronization_type';

	const PRODIGY_SYNC_STATUS_PROCESS = 'process';
	const PRODIGY_SYNC_STATUS_SUCCESS = 'success';
	const PRODIGY_SYNC_STATUS_ERROR   = 'error';

	const PRODIGY_PROCESS_TYPE = 'prodigy_process_type';

	const PRODIGY_DEMO_PROCESS   = 'demo';
	const PRODIGY_MANUAL_PROCESS = 'manual';
	const PRODIGY_AUTO_SYNC      = 'autosync';
	const PRODIGY_IMPORT_PROCESS = 'import';


	/**
	 * @var object \Prodigy\Includes\Prodigy_Api_Client
	 */
	public $api_client;
	public $start_queue;

	public function __construct() {
		$this->api_client = new Prodigy_Api_Client();
	}

	/**
	 * @param string $process_url
	 *
	 * @return bool
	 * @throws Prodigy_Demo_Content_Exception
	 */
	public function run_sync_process( string $process_url ): bool {

		$url      = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . $process_url;
		$params   = array(
			'with_existed_entities' => true,
		);
		$response = $this->api_client->post_remote_content( $url, $params );
		$result   = false;
		update_option( self::PRODIGY_SYNCHRONIZATION_TYPE, self::PRODIGY_MANUAL_PROCESS );
		if ( isset( $response['data'] ) ) {
			$result = $this->set_options( $response['data'] );
		}

		return $result;
	}

	/**
	 * @param array $data
	 *
	 * @return bool
	 * @throws Prodigy_Demo_Content_Exception
	 */
	public function run_import_process( array $data ): bool {
		$result = false;
		update_option( self::PRODIGY_SYNCHRONIZATION_TYPE, self::PRODIGY_IMPORT_PROCESS );
		if ( ! empty( $data ) ) {
			$result = $this->set_options( $data );
		}

		return $result;
	}


	/**
	 * @return string
	 */
	public static function get_error_notification_message(): string {
		$type_option = get_option( self::PRODIGY_SYNCHRONIZATION_TYPE );

		$message = '';
		if ( $type_option === 'manual' ) {
			$message = __( 'Failed to synchronize products. Please try again later', 'prodigy' );
		} elseif ( $type_option === 'demo' ) {
			$message = __( 'Error installing demo content', 'prodigy' );
		} elseif ( $type_option === 'import' ) {
			$message = __( 'Failed to synchronize products after import. Please try again later', 'prodigy' );
		}

		return $message;
	}


	/**
	 * @param array $options
	 *
	 * @return bool
	 * @throws Prodigy_Demo_Content_Exception
	 */
	public function set_options( array $options ): bool {
		$is_set_options = $this->set_sync_options( $options );

		if ( $is_set_options ) {
			$this->start_queue = new Prodigy_Process_Factory();
			$this->start_queue->start_queues_by_types();
		} else {
			if ( PRODIGY_DEBUG_MODE ) {
				do_action( 'logger', __LINE__ . __METHOD__ . __CLASS__ . ' ' . 'Sync settings saving error', 'error' );
			}
			throw new Prodigy_Demo_Content_Exception();
		}

		return $is_set_options;
	}


	/**
	 * @param array $options
	 *
	 * @return bool
	 * @throws Prodigy_Demo_Content_Exception
	 */
	public function set_sync_options( array $options ): bool {
		$process_types         = array();
		$is_update_sync_params = false;
		$type_option           = get_option( self::PRODIGY_SYNCHRONIZATION_TYPE );
		if ( ! empty( $options ) ) {

			foreach ( $options as $data ) {
				if ( isset( $data['attributes']['entity-type'] ) ) {
					$content_type = $data['attributes']['entity-type'];
					update_option( 'prodigy_sync_url_' . $content_type, $data['attributes']['url'] );
					update_option( 'prodigy_sync_count_' . $content_type, $data['attributes']['total-count'] );
					update_option( 'prodigy_sync_status_' . $content_type, (int) $data['attributes']['completed'] );
					$process_types[]       = $content_type;
					$is_update_sync_params = true;
				} else {
					update_option( self::PRODIGY_SYNC_MESSAGE_OPTION, self::get_error_notification_message() );
					if ( PRODIGY_DEBUG_MODE ) {
						if ( $type_option === 'demo' ) {
							throw new Prodigy_Demo_Content_Exception();
						}

						do_action( 'logger', __LINE__ . __METHOD__ . __CLASS__ . ' ' . 'Synchronizations settings undefined', 'error' );
					}
					$is_update_sync_params = false;
				}
			}
		}

		if ( $is_update_sync_params ) {
			update_option( 'prodigy_sync_process_types', $process_types );
			$is_update_sync_params = ! empty( get_option( 'prodigy_sync_process_types' ) );
		}

		return $is_update_sync_params;
	}

}
