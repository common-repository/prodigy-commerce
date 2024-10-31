<?php

/**
 * Prodigy price filters widget class
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
 * Class Prodigy_Price_Filter_Widget
 */
class Prodigy_Price_Filter_Widget extends WP_Widget {

	/**
	 * @var string
	 */
	protected $default_title;

	/**
	 * Prodigy_Price_Filter_Widget constructor.
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'prodigy_load_attributes_style' ) );

		$this->default_title = esc_html__( 'Price Filter', 'prodigy' );

		$widget_ops = array(
			'classname'   => 'prodigy_price_filter_widget',
			'description' => 'Prodigy Price Filter',
		);
		parent::__construct( 'prodigy_price_filter_widget', 'Prodigy Price Filter', $widget_ops );
	}


	public function prodigy_load_attributes_style() {
		wp_enqueue_script(
			'select2',
			dirname( plugin_dir_url( __FILE__ ) ) . '/../web/libraries/select2/js/select2.min.js',
			array( 'jquery' ),
			PRODIGY_VERSION
		);

		wp_enqueue_style(
			'select2.min.css',
			dirname( plugin_dir_url( __FILE__ ) ) . '/../web/libraries/select2/css/select2.min.css',
			array(),
			PRODIGY_VERSION
		);
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
			$str  .= do_shortcode( '[prodigy_price_filter ' . $query . ']' ) . $args['after_widget'];
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

		<?php
	}

	/**
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                    = array();
		$instance['title']           = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['filter_by_price'] = ( ! empty( $new_instance['filter_by_price'] ) ) ? sanitize_text_field( $new_instance['filter_by_price'] ) : '';

		return $instance;
	}
}
