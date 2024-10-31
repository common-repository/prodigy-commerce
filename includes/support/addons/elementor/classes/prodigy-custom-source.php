<?php

namespace Prodigy\Includes\Support\Addons\Elementor\Classes;

use Elementor\Api;
use Elementor\Plugin;
use Elementor\TemplateLibrary\Source_Remote;
use Elementor\Core\Common\Modules\Connect\Module as ConnectModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * @version 2.0.7
 */
class Prodigy_Source_Custom extends Source_Remote {


	/**
	 * Get remote templates.
	 *
	 * Retrieve remote templates from Elementor.com servers.
	 *
	 * @param array $args Optional. Nou used in remote source.
	 *
	 * @return array Remote templates.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_items( $args = array() ) {
		$library_data = Prodigy_Api::get_library_data();

		$templates = array();

		if ( ! empty( $library_data['templates'] ) ) {
			foreach ( $library_data['templates'] as $template_data ) {
				$templates[] = $this->prepare_template( $template_data );
			}
		}

		return array_merge( $templates, parent::get_items() );
	}


	/**
	 * Get remote template data.
	 *
	 * Retrieve the data of a single remote template from Elementor.com servers.
	 *
	 * @param array  $args Custom template arguments.
	 * @param string $context Optional. The context. Default is `display`.
	 *
	 * @return array|\WP_Error Remote Template data.
	 * @throws \Exception
	 * @since 1.5.0
	 * @access public
	 */
	public function get_data( array $args, $context = 'display' ) {
		$data = parent::get_data( $args, $context );
		if ( ! is_wp_error( $data ) ) {
			return $data;
		}
		$data = Prodigy_Api::get_template_content( $args['template_id'] );

		if ( is_wp_error( $data ) ) {
			return $data;
		}

		// BC.
		$data = (array) $data;

		$data['content'] = $this->replace_elements_ids( $data['content'] );
		$data['content'] = $this->process_export_import_content( $data['content'], 'on_import' );

		$post_id  = $args['editor_post_id'];
		$document = Plugin::$instance->documents->get( $post_id );
		if ( $document ) {
			$data['content'] = $document->get_elements_raw_data( $data['content'], true );
		}

		return $data;
	}

	/**
	 * @param array $template_data
	 *
	 * @return array
	 */
	private function prepare_template( array $template_data ): array {
		$favorite_templates = $this->get_user_meta( 'favorites' );
		// BC: Support legacy APIs that don't have access tiers.
		if ( isset( $template_data['access_tier'] ) ) {
			$access_tier = $template_data['access_tier'];
		} else {
			$access_tier = 0 === $template_data['access_level']
				? ConnectModule::ACCESS_TIER_FREE
				: ConnectModule::ACCESS_TIER_ESSENTIAL;
		}
		return array(
			'template_id'     => $template_data['id'],
			'source'          => $this->get_id(),
			'type'            => $template_data['type'],
			'subtype'         => $template_data['subtype'],
			'title'           => $template_data['title'],
			'thumbnail'       => $template_data['thumbnail'],
			'date'            => $template_data['tmpl_created'],
			'author'          => $template_data['author'],
			'tags'            => json_decode( $template_data['tags'] ),
			'isPro'           => true,
			'accessLevel'     => $template_data['access_level'],
			'accessTier'      => $access_tier,
			'popularityIndex' => (int) $template_data['popularity_index'],
			'trendIndex'      => (int) $template_data['trend_index'],
			'hasPageSettings' => ( '1' === $template_data['has_page_settings'] ),
			'url'             => $template_data['url'],
			'favorite'        => ! empty( $favorite_templates[ $template_data['id'] ] ),
		);
	}
}
