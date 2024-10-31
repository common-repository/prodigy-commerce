<?php

namespace Prodigy\Includes\Support\Addons\Elementor\Classes;

use Elementor\Plugin;
use Prodigy\Includes\Content\Prodigy_Product_Parser;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;

class Prodigy_Api extends \Elementor\Api {

	/**
	 * Elementor library option key.
	 */
	const LIBRARY_OPTION_KEY = 'prodigy_elementor_remote_info_library';

	/**
	 * Elementor feed option key.
	 */
	const FEED_OPTION_KEY = 'prodigy_elementor_remote_info_feed_data';

	public static $api_info_url                  = '/wp-content/plugins/prodigy-wp-plugin/static/info.json';
	private static $api_get_template_content_url = '/wp-content/plugins/prodigy-wp-plugin/static/templates/%d.json';


	public static function getApiInfoUrl() {
		return '/wp-content/plugins/' . get_prodigy_plugin_directory_name() . '/static/info.json';
	}

	private static function getApiTemplateContentUrl() {
		return '/wp-content/plugins/' . get_prodigy_plugin_directory_name() . '/static/templates/%d.json';
	}


	/**
	 * @param int $template_id
	 * @return array|mixed|\WP_Error
	 */
	public static function get_template_content( $template_id ) {
		parent::get_template_content( $template_id );
		$url = sprintf( get_site_url() . self::getApiTemplateContentUrl(), $template_id );

		$streamContext = stream_context_create(
			array(
				'ssl' => array(
					'verify_peer'      => false,
					'verify_peer_name' => false,
				),
			)
		);

		if ( wp_remote_get( $url, $streamContext ) ) {
			$body_args = array(
				// Which API version is used.
				'api_version' => ELEMENTOR_VERSION,
				// Which language to return.
				'site_lang'   => get_bloginfo( 'language' ),
			);

			/**
			 * API: Template body args.
			 *
			 * Filters the body arguments send with the GET request when fetching the content.
			 *
			 * @param array $body_args Body arguments.
			 */
			$body_args = apply_filters( 'elementor/api/get_templates/body_args', $body_args );

			$response = wp_remote_get(
				$url,
				array(
					'timeout'   => 40,
					'body'      => $body_args,
					'sslverify' => false,
				)
			);

			if ( is_wp_error( $response ) ) {
				return $response;
			}

			$response_code = (int) wp_remote_retrieve_response_code( $response );

			if ( 200 !== $response_code ) {
				return new \WP_Error( 'response_code_error', sprintf( 'The request returned with a status code of %s.', $response_code ) );
			}

			$template_content = json_decode( wp_remote_retrieve_body( $response ), true );

			if ( isset( $template_content['error'] ) ) {
				return new \WP_Error( 'response_error', $template_content['error'] );
			}

			if ( Prodigy_Product_Template_Builder::get_random_product() === null ) {
				return new \WP_Error( 'template_data_error', 'There are no products in your store. Create at least one product to proceed.' );
			}

			if ( empty( $template_content['data'] ) && empty( $template_content['content'] ) ) {
				return new \WP_Error( 'template_data_error', 'An invalid data was returned.' );
			}

			return $template_content;
		} else {
			$library = Plugin::$instance->common->get_component( 'connect' )->get_app( 'library' );
			return $library->get_template_content( $template_id );
		}
	}

	public static function get_library_data( $force_update = false ) {
		self::get_info_data( $force_update );

		$library_data = get_option( self::LIBRARY_OPTION_KEY );

		if ( empty( $library_data ) ) {
			return array();
		}

		return $library_data;
	}

	private static function get_info_data( $force_update = false ) {
		$cache_key = 'prodigy_elementor_remote_info_api_data_' . ELEMENTOR_VERSION;

		$info_data = get_transient( $cache_key );

		if ( $force_update || false === $info_data ) {
			$timeout = ( $force_update ) ? 25 : 8;

			$response = wp_remote_get(
				get_site_url() . self::getApiInfoUrl(),
				array(
					'timeout'   => $timeout,
					'body'      => array(
						// Which API version is used.
						'api_version' => ELEMENTOR_VERSION,
						// Which language to return.
						'site_lang'   => get_bloginfo( 'language' ),
					),
					'sslverify' => false,
				)
			);

			if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
				set_transient( $cache_key, array(), 2 * HOUR_IN_SECONDS );

				return false;
			}

			$info_data = json_decode( wp_remote_retrieve_body( $response ), true );

			if ( empty( $info_data ) || ! is_array( $info_data ) ) {
				set_transient( $cache_key, array(), 2 * HOUR_IN_SECONDS );

				return false;
			}

			if ( isset( $info_data['library'] ) ) {
				update_option( self::LIBRARY_OPTION_KEY, $info_data['library'], 'no' );

				unset( $info_data['library'] );
			}

			if ( isset( $info_data['feed'] ) ) {
				update_option( self::FEED_OPTION_KEY, $info_data['feed'], 'no' );

				unset( $info_data['feed'] );
			}

			set_transient( $cache_key, $info_data, 12 * HOUR_IN_SECONDS );
		}

		return $info_data;
	}
}
