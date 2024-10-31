<?php
namespace Prodigy\Includes\Synchronization\Content;

use Prodigy\Includes\Content\Prodigy_Api_Client;
use Prodigy\Includes\Demo\Exception\Prodigy_Demo_Content_Exception;
use Prodigy\Includes\Models\Prodigy_Categories;
use Prodigy\Includes\Models\Prodigy_Products;
use Prodigy\Includes\Models\Prodigy_Reviews;
use Prodigy\Includes\Models\Prodigy_Taxonomies;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Queue\Prodigy_Background_Process;
use Prodigy\Includes\Synchronization\Prodigy_Synchronization;

defined( 'ABSPATH' ) || exit;

/**
 * Class Prodigy_Start_Process
 *
 * @version 2.0.0
 * @package Prodigy\Includes\Synchronization\Content
 */
class Prodigy_Start_Process extends Prodigy_Background_Process {

	/** @var object Prodigy_Api_Client  */
	public $api_client;

	protected $action = 'prodigy_set_synchronization_process_types';

	const COUNT_ITEMS = 100;

	/**
	 * Prodigy_Start_Process constructor.
	 */
	public function __construct() {
		parent::__construct();

		$this->api_client = new Prodigy_Api_Client();
	}

	/**
	 * @param mixed $types
	 *
	 * @return false
	 * @throws Prodigy_Demo_Content_Exception
	 */
	protected function task( $types ) {
		update_option( Prodigy_Synchronization::PRODIGY_NEEDS_SYNC_NOTIFICATION, 1 );

		foreach ( $types as $type ) {
			$i = 0;
			do {
				$i++;
				sleep( 2 );
				$content_url  = get_option( 'prodigy_sync_url_' . $type );
				$process_type = get_option( Prodigy_Synchronization::PRODIGY_SYNCHRONIZATION_TYPE );

				$query = '';
				if ( $process_type !== Prodigy_Synchronization::PRODIGY_DEMO_PROCESS ) {
					$query = '?items_count=' . self::COUNT_ITEMS;
				}

				$url           = Prodigy_Api_Client::API_PROTOCOL . PRODIGY_API_DOMAIN . $content_url . $query;
				$response      = $this->api_client->get_remote_content( $url );
				$data          = json_decode( wp_remote_retrieve_body( $response ), true );
				$model         = $this->get_current_model( $type );
				$content       = isset( $data['data'] ) ? $data['data']['attributes'] : array();
				$error_message = Prodigy_Synchronization::get_error_notification_message();

				update_option( Prodigy_Synchronization::PRODIGY_SYNC_STATUS, Prodigy_Synchronization::PRODIGY_SYNC_STATUS_PROCESS );

				if ( ! empty( $content['items'] ) ) {
					$validate_method_name = $this->get_validate_method( $type );
					if ( ! empty( $validate_method_name ) ) {
						$is_valid = call_user_func( array( $model, $validate_method_name ), $content['items'] );

						if ( $is_valid !== false ) {
							$saving_method_name = $this->get_save_method( $type );
							call_user_func( array( $model, $saving_method_name ), $content['items'] );
						} else {
							update_option( Prodigy_Synchronization::PRODIGY_SYNC_STATUS, Prodigy_Synchronization::PRODIGY_SYNC_STATUS_ERROR );
							update_option( Prodigy_Synchronization::PRODIGY_SYNC_MESSAGE_OPTION, $error_message );
							if ( PRODIGY_DEBUG_MODE ) {
								if ( $process_type === Prodigy_Synchronization::PRODIGY_DEMO_PROCESS ) {
									throw new Prodigy_Demo_Content_Exception();
								}
								do_action( 'logger', __LINE__ . __METHOD__ . __CLASS__ . ' ' . $type . 'sync validation', 'error' );
							}
						}
					}
				}

				if (
					$i > 7 &&
					isset( $content['completed'], $content['synchronized-count'], $content['items'] ) &&
					$content['completed'] === false &&
					empty( $content['synchronized-count'] ) && empty( $content['items'] )
				) {
					update_option( Prodigy_Synchronization::PRODIGY_SYNC_STATUS, Prodigy_Synchronization::PRODIGY_SYNC_STATUS_ERROR );
					update_option( Prodigy_Synchronization::PRODIGY_SYNC_MESSAGE_OPTION, $error_message );
					if ( PRODIGY_DEBUG_MODE ) {
						if ( $process_type === Prodigy_Synchronization::PRODIGY_DEMO_PROCESS ) {
							throw new Prodigy_Demo_Content_Exception();
						}
						do_action( 'logger', __LINE__ . __METHOD__ . __CLASS__ . ' ' . $type . ' synchronize type error!', 'error' );
						do_action( 'logger', __LINE__ . __METHOD__ . __CLASS__, 'info' );
						do_action( 'logger', $content, 'info' );
					}
					break;
				}
			} while (
				isset( $content['completed'] ) && ! $content['completed']
			);
		}

		return false;
	}


	/**
	 * @param string $type
	 *
	 * @return Prodigy_Categories|Prodigy_Products|Prodigy_Reviews|Prodigy_Taxonomies|string
	 */
	public function get_current_model( string $type ) {
		switch ( $type ) {
			case 'category':
				$model = new Prodigy_Categories();
				break;
			case 'product':
				$model = new Prodigy_Products();
				break;
			case 'property':
				$model = new Prodigy_Taxonomies();
				break;
			case 'review':
				$model = new Prodigy_Reviews();
				break;
			default:
				$model = '';
		}

		return $model;
	}


	/**
	 * @param string $type
	 *
	 * @return string
	 */
	public function get_save_method( string $type ): string {
		switch ( $type ) {
			case 'category':
				$name = 'add_categories';
				break;
			case 'product':
				$name = 'add_products';
				break;
			case 'property':
				$name = 'add_taxonomies';
				break;
			case 'review':
				$name = 'add_reviews';
				break;
			default:
				$name = '';
		}

		return $name;
	}

	/**
	 * @param string $type
	 *
	 * @return string
	 */
	public function get_validate_method( string $type ): string {
		switch ( $type ) {
			case 'category':
				$name = 'validate_categories';
				break;
			case 'product':
				$name = 'validate_products';
				break;
			case 'property':
				$name = 'validate_taxonomies_for_create';
				break;
			case 'review':
				$name = 'validate_product_reviews';
				break;
			default:
				$name = '';
		}

		return $name;
	}


	protected function complete() {
		parent::complete();
		if ( $this->is_queue_empty() ) {
			update_option( Prodigy_Synchronization::PRODIGY_SYNC_STATUS, Prodigy_Synchronization::PRODIGY_SYNC_STATUS_SUCCESS );
			Prodigy::refresh_permalink();
		}
	}
}
