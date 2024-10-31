<?php
namespace Prodigy\Includes\Widgets;

use WP_Widget;
/**
 * Prodigy search widget class
 *
 * @version    1.0.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Search_Prodigy_Widget
 */
class Prodigy_Search_Widget extends WP_Widget {

	/**
	 * @var string
	 */
	protected $default_title;

	/**
	 * Search_Prodigy_Widget constructor.
	 */
	public function __construct() {

		$this->default_title = esc_html__( 'Products search', 'prodigy' );

		$widget_ops = array(
			'classname'   => 'prodigy_search_widget',
			'description' => 'Prodigy Product Search',
		);
		parent::__construct( 'prodigy_search_widget', 'Prodigy Product Search', $widget_ops );
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

		$str .= do_shortcode( '[prodigy_search]' ) . $args['after_widget'];

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
					value="<?php echo esc_attr( $title ); ?>"
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
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

		return $instance;
	}
}
