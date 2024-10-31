<?php
/**
 * Prodigy cart widget class
 *
 * @version    1.0.0
 * @package    Prodigy
 * @subpackage Prodigy/includes
 */

namespace Prodigy\Includes\Widgets;

use Prodigy\Includes\Frontend\Shortcodes\Prodigy_Short_Code_Cart;
use WP_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Cart_Prodigy_Widget
 */
class Prodigy_Cart_Widget extends WP_Widget {

	/**
	 * @var string
	 */
	protected $default_title;

	/**
	 * Search_Prodigy_Widget constructor.
	 */
	public function __construct() {

		$this->default_title = esc_html__( 'Shopping Cart', 'prodigy' );

		$widget_ops = array(
			'classname'   => 'prodigy_cart_widget',
			'description' => 'Prodigy Product Cart',
		);
		parent::__construct( Prodigy_Short_Code_Cart::NAME, 'Prodigy Product Cart', $widget_ops );
	}

	/**
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		if ( wp_is_json_request() ) {
			return '';
		}

		echo esc_html( $args['before_widget'] );

		if ( ! empty( $instance['title'] ) ) {
			echo esc_html( $args['before_title'] ) . esc_html( apply_filters( 'widget_title', $instance['title'] ) ) . esc_html( $args['after_title'] );
		}

		echo do_shortcode( '[' . Prodigy_Short_Code_Cart::NAME . ']' );

		echo esc_html( $args['after_widget'] );
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
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

		return $instance;
	}
}
