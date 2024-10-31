<?php
namespace Prodigy\Includes\Helpers\Traits;

trait TraitProdigySidebar {

	/**
	 * @param  string $index
	 *
	 * @return bool
	 */
	public function is_widget_active( string $index ): bool {
		$widgetcolums = wp_get_sidebars_widgets();
		if ( isset( $widgetcolums['prodigy_shop_sidebar'] ) ) {
			foreach ( $widgetcolums['prodigy_shop_sidebar'] as $widget ) {
				$new = preg_replace( '/-\d+(\.\w+)?$/i', '\\1', $widget );
				if ( $new === $index ) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Insert a widget in a sidebar.
	 *
	 * @param  string $widget_id  ID of the widget (search, recent-posts, etc.)
	 * @param  array  $widget_data  Widget settings.
	 * @param  string $sidebar  ID of the sidebar.
	 */
	public function insert_widget_in_sidebar( string $widget_id, array $widget_data, string $sidebar ) {
		// Retrieve sidebars, widgets and their instances
		$sidebars_widgets = get_option( 'sidebars_widgets', array() );
		$widget_instances = get_option( 'widget_' . $widget_id, array() );

		// Retrieve the key of the next widget instance
		$numeric_keys = array_filter( array_keys( $widget_instances ), 'is_int' );
		$next_key     = $numeric_keys ? max( $numeric_keys ) + 1 : 2;

		// Add this widget to the sidebar
		if ( ! isset( $sidebars_widgets[ $sidebar ] ) ) {
			$sidebars_widgets[ $sidebar ] = array();
		}
		$sidebars_widgets[ $sidebar ][] = $widget_id . '-' . $next_key;

		// Add the new widget instance
		$widget_instances[ $next_key ] = $widget_data;

		// Store updated sidebars, widgets and their instances
		update_option( 'sidebars_widgets', $sidebars_widgets );
		update_option( 'widget_' . $widget_id, $widget_instances );
	}

	/**
	 * @param  string $widget_id
	 * @param  string $sidebar
	 */
	public function delete_widgets_from_sidebar( string $widget_id, string $sidebar ) {
		// Retrieve sidebars, widgets and their instances
		$sidebars_widgets = get_option( 'sidebars_widgets', array() );

		if ( isset( $sidebars_widgets[ $sidebar ] ) ) {
			$widgets = array();
			foreach ( $sidebars_widgets[ $sidebar ] as $widget_id_with_key ) {
				if ( ! preg_match( '/^' . $widget_id . '-/', $widget_id_with_key ) ) {
					$widgets[] = $widget_id_with_key;
				}
			}

			$sidebars_widgets[ $sidebar ] = $widgets;
		}

		// Store updated sidebars, widgets and their instances
		update_option( 'sidebars_widgets', $sidebars_widgets );
		delete_option( 'widget_' . $widget_id );
	}

	/**
	 * Truncate sidebar
	 *
	 * @param  array $widgets
	 */
	public function delete_sidebars( $widgets = array() ) {

		$widgets = $widgets ?? array(
			'categories',
			'archives',
			'meta',
			''
		);

		foreach ( $widgets as $widget ) {
			if ( $this->is_widget_active( $widget ) ) {
				$this->delete_widgets_from_sidebar( $widget, 'prodigy_shop_sidebar' );
			}
		}

		$this->delete_excess_block_from_sidebar();
	}

	/**
	 * @param  array $filters
	 */
	public function set_filter_widget_settings( array $filters ) {
		$active_filter   = array( 'title' => esc_html__( 'Active Filters', 'prodigy' ) );
		$price_filter    = array( 'title' => esc_html__( 'Price Filter', 'prodigy' ) );
		$filters_widget  = array(
			'title'           => esc_html__( 'Filter By', 'prodigy' ),
			'query_type'      => 'and',
			'list_attributes' => $filters,
		);
		$category_widget = array(
			'title'        => esc_html__( 'Browse', 'prodigy' ),
			'sorting'      => 'ID',
			'count'        => '1',
			'hierarchical' => '1',
			'hide_empty'   => '1',
			'max_depth'    => false,
		);

		$widgets = array(
			'active_filters_prodigy_widget' => $active_filter,
			'filters_prodigy_widget'        => $filters_widget,
			'categories_prodigy_widget'     => $category_widget,
			'prodigy_price_filter_widget'   => $price_filter,
		);

		foreach ( $widgets as $widget => $settings ) {
			if ( ! $this->is_widget_active( $widget ) ) {
				$this->insert_widget_in_sidebar( $widget, $settings, 'prodigy_shop_sidebar' );
			}
		}

	}


	/**
	 * Delete excess blocks from sidebar
	 */
	public function delete_excess_block_from_sidebar() {
		$widgets = get_option( 'sidebars_widgets' );
		if ( isset( $widgets['prodigy_shop_sidebar'] ) ) {
			foreach ( $widgets['prodigy_shop_sidebar'] as $key => $widget ) {
				if ( preg_match( '/^block-(\d+)$/', $widget ) ) {
					unset( $widgets['prodigy_shop_sidebar'][ $key ] );
				}
			}
		}
		update_option( 'sidebars_widgets', $widgets );
	}
}
