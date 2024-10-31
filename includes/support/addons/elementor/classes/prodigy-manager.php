<?php

namespace Prodigy\Includes\Support\Addons\Elementor\Classes;

use Elementor\Api;
use Elementor\Core\Common\Modules\Ajax\Module as Ajax;
use Elementor\Plugin;
use Elementor\Plugin as ElementorPlugin;
use Elementor\TemplateLibrary\Manager;
use Elementor\TemplateLibrary\Source_Local;
use Elementor\User;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * @version 2.0.7
 */
class Prodigy_Manager {

	private $manager;

	public function __construct( Manager $manager ) {
		$this->manager = $manager;

		// Unregister source with closure binding, thank Steve.
		$unregister_source = function ( $id ) {
			unset( $this->_registered_sources[ $id ] );
		};

		$unregister_source->call( $this->manager, 'remote' );

		$this->manager->register_source( 'Prodigy\Includes\Support\Addons\Elementor\Classes\Prodigy_Source_Custom' );
		$this->reset_actions();
	}

	private function reset_actions() {
		remove_action( 'elementor/ajax/register_actions', array( $this->manager, 'register_ajax_actions' ) );
		remove_action( 'wp_ajax_elementor_library_direct_actions', array( $this->manager, 'handle_direct_actions' ) );

		add_action( 'elementor/ajax/register_actions', array( $this, 'register_ajax_actions' ) );
		add_action( 'wp_ajax_elementor_library_direct_actions', array( $this, 'handle_direct_actions' ) );
	}

	public function register_ajax_actions( Ajax $ajax ) {
		$library_ajax_requests = array(
			'get_library_data',
			'get_template_data',
			'save_template',
			'update_templates',
			'delete_template',
			'import_template',
			'mark_template_as_favorite',
		);

		foreach ( $library_ajax_requests as $ajax_request ) {
			$ajax->register_ajax_action(
				$ajax_request,
				function( $data ) use ( $ajax_request ) {
					return $this->handle_ajax_request( $ajax_request, $data );
				}
			);
		}
	}

	private function handle_ajax_request( $ajax_request, array $data ) {
		if ( ! User::is_current_user_can_edit_post_type( Source_Local::CPT ) ) {
			throw new \Exception( 'Access Denied' );
		}

		if ( ! empty( $data['editor_post_id'] ) ) {
			$editor_post_id = absint( $data['editor_post_id'] );

			if ( ! get_post( $editor_post_id ) ) {
				throw new \Exception( esc_html__( 'Post not found.', 'elementor' ) );
			}

			Plugin::$instance->db->switch_to_post( $editor_post_id );
		}

		$result = call_user_func( array( $this, $ajax_request ), $data );

		if ( is_wp_error( $result ) ) {
			throw new \Exception( $result->get_error_message() );
		}

		return $result;
	}


	public function __call( $method, $args ) {
		$args;
		if ( method_exists( $this->manager, $method ) ) {
			return call_user_func_array( array( $this->manager, $method ), $args );
		}
	}

	public function get_library_data( array $args ) {

		$native_library_data = Api::get_library_data( ! empty( $args['sync'] ) );
		$library_data        = Prodigy_Api::get_library_data( ! empty( $args['sync'] ) );

		$library_data = self::merge_types( $native_library_data, $library_data );

		return array(
			'templates' => $this->get_templates(),
			'config'    => $library_data['types_data'],
		);
	}

	/**
	 * @param array $custom_data
	 * @return false|mixed|void
	 */
	public static function merge_types( $elementor_data, $custom_data ) {

		if ( isset( $custom_data['types_data']['block']['categories'] ) ) {
			foreach ( $custom_data['types_data']['block']['categories'] as $item ) {
				if ( ! in_array( $item, $elementor_data['types_data']['block']['categories'] ) ) {
					array_push( $elementor_data['types_data']['block']['categories'], $item );
				}
			}
		}

		if ( isset( $custom_data['templates'] ) ) {
			foreach ( $custom_data['templates'] as $item ) {
				if ( ! in_array( $item, $elementor_data['templates'] ) ) {
					array_push( $elementor_data['templates'], $item );
				}
			}
		}

		if ( isset( $custom_data['categories'] ) ) {
			foreach ( $custom_data['categories'] as $item ) {
				if ( ! in_array( $item, $elementor_data['categories'] ) ) {
					array_push( $elementor_data['categories'], $item );
				}
			}
		}

		return $elementor_data;
	}

}
