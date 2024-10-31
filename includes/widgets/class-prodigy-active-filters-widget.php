<?php
/**
 * Prodigy active filters widget class
 *
 * @version    1.0.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */
namespace Prodigy\Includes\Widgets;

use WP_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Active_Filters_Prodigy_Widget
 */
class Prodigy_Active_Filters_Widget extends WP_Widget {

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
	 * Active_Filters_Prodigy_Widget constructor.
	 */
	public function __construct() {

		$this->default_title = esc_html__( 'Active Filters', 'prodigy' );

		$widget_ops = array(
			'classname'   => 'active_filters_prodigy_widget',
			'description' => 'Prodigy Active Filters',
		);
		parent::__construct( 'active_filters_prodigy_widget', 'Prodigy Active Filters', $widget_ops );
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

		if ( ! empty( $instance ) ) {
			$query = http_build_query( $instance, '', ' ' );
			$str  .= do_shortcode( '[prodigy_active_filter ' . $query . ']' ) . $args['after_widget'];
		}

		echo $str;
	}

	/**
	 * @param array $instance
	 *
	 * @return string|void
	 */
	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : $this->default_title;
		$is_show_attribute = ! empty( $instance['show_attribute_name'] ) ? $this->bool_mapper[ $instance['show_attribute_name'] ] : '';
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
			<input
					class="checkbox"
					id="<?php echo esc_attr( $this->get_field_id( 'show_attribute_name' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'show_attribute_name' ) ); ?>"
					type="checkbox"
					value="1"
				<?php
				if ( isset( $this->bool_mapper[ $is_show_attribute ] ) ) {
					echo 'checked';
				}
				?>
			>
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_attribute_name' ) ); ?>">
				<?php esc_attr_e( 'Show attribute name', 'prodigy' ); ?>
			</label>
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
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['show_attribute_name']     = ( ! empty( $new_instance['show_attribute_name'] ) ) ? sanitize_text_field( $new_instance['show_attribute_name'] ) : false;

		return $instance;
	}
}
