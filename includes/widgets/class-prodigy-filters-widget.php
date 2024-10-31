<?php

/**
 * Prodigy filters widget class
 *
 * @version    2.0.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
namespace Prodigy\Includes\Widgets;

use Prodigy\Includes\Content\Prodigy_Product_Attributes;
use WP_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Filters_Prodigy_Widget
 */
class Prodigy_Filters_Widget extends WP_Widget {

	const DEFAULT_VISIBLE_AMOUNT = 4;
	const DEFAULT_EXPANDED_AMOUNT = 1;

	/**
	 * @var string
	 */
	protected $default_title;
	protected $list_attrs;

	/**
	 * Filters_Prodigy_Widget constructor.
	 */
	public function __construct() {
		$this->default_title = esc_html__( 'Filter By', 'prodigy' );

		$widget_ops = array(
			'classname'   => 'filters_prodigy_widget',
			'description' => 'Prodigy Product Filters',
		);
		parent::__construct( 'filters_prodigy_widget', 'Prodigy Product Filters', $widget_ops );

		$obj_attrs        = new Prodigy_Product_Attributes();
		$this->list_attrs = $obj_attrs->get_attribute_taxonomies();
	}

	/**
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		if ( wp_is_json_request() ) {
			return '';
		}

		$str = $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			$str .= $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		if ( ! empty( $instance ) ) {
			$query = http_build_query( $instance, '', ' ' );
			$str  .= do_shortcode( '[prodigy_attributes_filter ' . $query . ']' ) . $args['after_widget'];
		}

		echo $str;
	}

	/**
	 * @param array $instance
	 *
	 * @return string|void
	 */
	public function form( $instance ) {
		$title           = $instance['title'] ?? $this->default_title;
		$query_type      = ! empty( $instance['query_type'] ) ? $instance['query_type'] : '';
		$filter_by_price = ! empty( $instance['filter_by_price'] ) ? $instance['filter_by_price'] : '';
		$list_attributes = empty( $instance['list_attributes'] ) ? wp_list_pluck( $this->list_attrs, 'id' ) : $instance['list_attributes'];
		$visible_amount  = $instance['visible_amount'] ?? self::DEFAULT_VISIBLE_AMOUNT;
		$expanded_amount  = $instance['expanded_amount'] ?? self::DEFAULT_EXPANDED_AMOUNT;
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_attr_e( 'Title:', 'prodigy' ); ?>
			</label>

			<input
					class="widefat"
					id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
					type="text"
					value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'list_attributes' ) ); ?>">
				<?php esc_attr_e( 'Attributes multi-select:', 'prodigy' ); ?>
			</label>
			<select class="widefat js-list-attributes-widget-filter"
					multiple="true"
					data-plugin="select2"
					id="<?php echo esc_attr( $this->get_field_id( 'list_attributes' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'list_attributes' ) ); ?>[]"
			>
				<?php
				foreach ( $this->list_attrs as $attr ) :
					$selected_filter = '';
					if ( in_array( $attr->id, $list_attributes ) ) {
						$selected_filter = 'selected';
					}
					?>
					<option value="<?php esc_html_e( $attr->id ); ?>" <?php echo esc_html( $selected_filter ); ?>><?php esc_html_e( $attr->name ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'visible_amount' ) ); ?>">
				<?php esc_attr_e( 'Number of visible items  :', 'prodigy' ); ?>
			</label>

			<input
					class="widefat"
					id="<?php echo esc_attr( $this->get_field_id( 'visible_amount' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'visible_amount' ) ); ?>"
					type="number"
					value="<?php echo esc_attr( $visible_amount ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'expanded_amount' ) ); ?>">
				<?php esc_attr_e( 'Number of expanded sections:', 'prodigy' ); ?>
			</label>

			<input
					class="widefat"
					id="<?php echo esc_attr( $this->get_field_id( 'expanded_amount' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'expanded_amount' ) ); ?>"
					type="number"
					value="<?php echo esc_attr( $expanded_amount ); ?>">
		</p>

		<?php

		$sidebar_id = is_active_widget( 0, 0, 'filters_prodigy_widget' );

		if ( ! empty( $instance ) && $sidebar_id ) :
			?>
			<script type="text/javascript">
				(function ($) {
					$('.js-list-attributes-widget-filter').select2({
						width: '100%',
					});

				})(jQuery);

			</script>

			<?php
		endif;
	}

	/**
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {

		$active_filter = is_active_widget( false, false, 'filters_prodigy_widget', false );

		$instance                    = array();
		$instance['title']           = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['query_type']      = ( ! empty( $new_instance['query_type'] ) ) ? sanitize_text_field( $new_instance['query_type'] ) : 'and';
		$instance['list_attributes'] = ( ! empty( $new_instance['list_attributes'] ) ) ? $new_instance['list_attributes'] : '';
		$instance['visible_amount']  = isset( $new_instance['visible_amount'] ) ? (int) $new_instance['visible_amount'] : '';
		$instance['expanded_amount'] = isset( $new_instance['expanded_amount'] ) ? (int) $new_instance['expanded_amount'] : '';

		if ( !empty( $active_filter ) && !empty( array_diff( (array) $old_instance['list_attributes'], $new_instance['list_attributes'] ) ) ) {
			update_option( 'prodigy_widget_change_default_state_filter', (bool) $active_filter );
		}

		return $instance;
	}
}
