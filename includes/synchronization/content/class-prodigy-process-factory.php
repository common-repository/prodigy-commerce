<?php
namespace Prodigy\Includes\Synchronization\Content;

defined( 'ABSPATH' ) || exit;
/**
 * Class Prodigy_Process_Factory
 *
 * @package Prodigy\Includes\Synchronization\Content
 */
class Prodigy_Process_Factory {

	public $start_process;

	public function __construct() {
		$this->start_process = new Prodigy_Start_Process();
	}


	/**
	 *  Send batch products action
	 */
	public function start_queues_by_types() {
		$this->add_batch_to_queue();
		$this->start_queues();
	}


	/**
	 *  Start products queues
	 */
	public function start_queues() {
		$is_status_process = $this->check_queue_key( 'prodigy_set_synchronization_process_types' );
		if ( empty( $is_status_process ) ) {
			$this->start_process->save()->dispatch();
		}
	}

	/**
	 *  Add products to queue
	 */
	public function add_batch_to_queue() {
		$types = get_option( 'prodigy_sync_process_types' );

		if ( ! empty( $types ) ) {
			$this->start_process->push_to_queue( $types );
		}
	}

	/**
	 * @param string $process_name
	 *
	 * @return mixed
	 */
	public function check_queue_key( string $process_name ) {
		global $wpdb;
		$like = '%' . $process_name . '%';
		return $wpdb->get_results(
			$wpdb->prepare(
				"SELECT option_name
                   FROM $wpdb->options
                   WHERE option_name
                   LIKE %s",
				$like
			)
		);
	}


	/**
	 * @param string $process_name
	 *
	 * @return array|object|null
	 */
	public function delete_queue_key( string $process_name ) {
		global $wpdb;

		$like = '%' . $process_name . '%';
		return $wpdb->get_results(
			$wpdb->prepare(
				"DELETE
                   FROM $wpdb->options
                   WHERE option_name
                   LIKE %s",
				$like
			)
		);
	}

}
