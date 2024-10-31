<?php
namespace Prodigy\Includes\Support\Customizer;

use WP_Customize_Control;

/**
 * @version 2.0.4
 * @package prodigy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Prodigy_Customizer_Control_Ratio extends WP_Customize_Control {

	/**
	 * Declare the control type.
	 *
	 * @var string
	 */
	public $type = 'prodigy-ratio-control';

	/**
	 * Render control.
	 */
	public function render_content() {
		if ( empty( $this->choices ) ) {
			return;
		}

		$value         = $this->value( 'ratio' );
		$custom_width  = $this->value( 'custom_width' );
		$custom_height = $this->value( 'custom_height' );
		?>

		<span class="customize-control-title">
			<?php echo esc_html( $this->label ); ?>
		</span>

		<?php if ( ! empty( $this->description ) ) : ?>
			<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
		<?php endif; ?>

		<ul id="input_<?php echo esc_attr( $this->id ); ?>" class="prodigy-ratio-control">
			<?php foreach ( $this->choices as $key => $radio ) : ?>
				<li>
					<input type="radio" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $this->id . $key ); ?>" <?php $this->link( 'ratio' ); ?> <?php checked( $value, $key ); ?> />
					<label for="<?php echo esc_attr( $this->id . $key ); ?>"><?php echo esc_html( $radio['label'] ); ?><br/><span class="description"><?php echo esc_html( $radio['description'] ); ?></span></label>

					<?php if ( 'custom' === $key ) : ?>
						<span class="prodigy-ratio-control-aspect-ratio">
							<input type="text" pattern="\d*" size="3" value="<?php echo esc_attr( $custom_width ); ?>" <?php $this->link( 'custom_width' ); ?> /> : <input type="text" pattern="\d*" size="3" value="<?php echo esc_attr( $custom_height ); ?>" <?php $this->link( 'custom_height' ); ?> />
						</span>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php
	}
}
