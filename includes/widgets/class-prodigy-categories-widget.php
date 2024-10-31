<?php
/**
 * Prodigy common widget class
 *
 * @version    2.0.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
namespace Prodigy\Includes\Widgets;

use WP_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Categories_Prodigy_Widget
 */
class Prodigy_Categories_Widget extends WP_Widget {

	public $bool_mapper = array(
		'true'  => true,
		'false' => false,
		'1'     => true,
		'0'     => false,
	);

	/**
	 * @var string
	 */
	protected $default_title;

	/**
	 * Categories_Prodigy_Widget constructor.
	 */
	public function __construct() {

		$this->default_title = esc_html__( 'Browse', 'prodigy' );

		$widget_ops = array(
			'classname'   => 'categories_prodigy_widget',
			'description' => 'Prodigy Product Categories',
		);
		parent::__construct( 'categories_prodigy_widget', 'Prodigy Product Categories', $widget_ops );
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
			$str  .= do_shortcode( '[prodigy_categories_filter ' . $query . ']' ) . $args['after_widget'];
		}

		echo $str;
	}

	/**
	 * @param array $instance
	 *
	 * @return string|void
	 */
	public function form( $instance ) {
		$title        = isset( $instance['title'] ) ? $instance['title'] : $this->default_title;
		$sorting      = ! empty( $instance['sorting'] ) ? $instance['sorting'] : '';
		$count        = ! empty( $instance['show_product_count'] ) ? $this->bool_mapper[ $instance['show_product_count'] ] : '';
		$hierarchical = ! empty( $instance['show_hierarchy'] ) ? $this->bool_mapper[ $instance['show_hierarchy'] ] : '';
		$hide_empty   = ! empty( $instance['hide_empty'] ) ? $this->bool_mapper[ $instance['hide_empty'] ] : '';
		$max_depth    = ! empty( $instance['max_depth'] ) ? $instance['max_depth'] : '';
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
			<label for="<?php echo esc_attr( $this->get_field_id( 'sorting' ) ); ?>">
				<?php esc_attr_e( 'Order by', 'prodigy' ); ?>
			</label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'sorting' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'sorting' ) ); ?>">
				<option value="ID" 
				<?php
				if ( $sorting == 'ID' ) {
					echo 'selected';
				}
				?>
				>Category ID
				</option>
				<option value="slug" 
				<?php
				if ( $sorting == 'slug' ) {
					echo 'selected';
				}
				?>
				>Name
				</option>
			</select>
		</p>
		<p>
			<input
					class="checkbox"
					id="<?php echo esc_attr( $this->get_field_id( 'show_product_count' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'show_product_count' ) ); ?>"
					type="checkbox"
					value="1"
				<?php
				if ( isset( $this->bool_mapper[ $count ] ) ) {
					echo 'checked';
				}
				?>
			>
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_product_count' ) ); ?>">
				<?php esc_attr_e( 'Show product counts', 'prodigy' ); ?>
			</label>
		</p>
		<p>
			<input
					class="checkbox"
					id="<?php echo esc_attr( $this->get_field_id( 'show_hierarchy' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'show_hierarchy' ) ); ?>"
					type="checkbox"
					value="1"
				<?php
				if ( isset( $this->bool_mapper[ $hierarchical ] ) ) {
					echo 'checked';
				}
				?>
			>
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_hierarchy' ) ); ?>">
				<?php esc_attr_e( 'Show hierarchy', 'prodigy' ); ?>
			</label>
		</p>
		<p>
			<input
					class="checkbox"
					id="<?php echo esc_attr( $this->get_field_id( 'hide_empty' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'hide_empty' ) ); ?>"
					type="checkbox"
					value="1"
				<?php
				if ( isset( $this->bool_mapper[ $hide_empty ] ) ) {
					echo 'checked';
				}
				?>
			>
			<label for="<?php echo esc_attr( $this->get_field_id( 'hide_empty' ) ); ?>">
				<?php esc_attr_e( 'Hide empty categories', 'prodigy' ); ?>
			</label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'max_depth' ) ); ?>">
				<?php esc_attr_e( 'Maximum depth', 'prodigy' ); ?>
			</label>
			<input
					class="widefat"
					id="<?php echo esc_attr( $this->get_field_id( 'max_depth' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'max_depth' ) ); ?>"
					type="text"
					value="<?php echo esc_attr( $max_depth ); ?>"
				<?php
				if ( $max_depth ) {
					echo 'checked';
				}
				?>
			>

		</p>
		<?php
	}

	/**
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                       = array();
		$instance['title']              = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['sorting']            = ( ! empty( $new_instance['sorting'] ) ) ? sanitize_text_field( $new_instance['sorting'] ) : 'ID';
		$instance['show_product_count'] = ( ! empty( $new_instance['show_product_count'] ) ) ? sanitize_text_field( $new_instance['show_product_count'] ) : false;
		$instance['show_hierarchy']     = ( ! empty( $new_instance['show_hierarchy'] ) ) ? sanitize_text_field( $new_instance['show_hierarchy'] ) : false;
		$instance['hide_empty']         = ( ! empty( $new_instance['hide_empty'] ) ) ? sanitize_text_field( $new_instance['hide_empty'] ) : false;
		$instance['max_depth']          = ( ! empty( $new_instance['max_depth'] ) ) ? sanitize_text_field( $new_instance['max_depth'] ) : false;

		return $instance;
	}
}
