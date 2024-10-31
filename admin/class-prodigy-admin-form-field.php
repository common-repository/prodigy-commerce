<?php

namespace Prodigy\Admin;

use WP_Post;

/**
 * Prodigy admin settings form fields helper class
 *
 * @version 1.0.0
 * @package prodigy/admin
 */
class Prodigy_Admin_Form_Field {

	/**
	 * The post instance.
	 *
	 * @var WP_Post|bool
	 */
	public $post = false;

	/**
	 * The prefix for the field name.
	 *
	 * @var string
	 */
	public string $prefix = '';

	/**
	 * The HTML for the field.
	 *
	 * @var string
	 */
	protected string $html = '';

	/**
	 * Prodigy_Admin_Form_Field constructor.
	 *
	 * @param array $settings
	 */
	public function __construct( array $settings = array() ) {
		foreach ( $settings as $key => $setting ) {
			$this->$key = $setting;
		}
	}

	/**
	 * Generate HTML for displaying fields
	 *
	 * @param array $field
	 *
	 * @return string
	 */
	public function display_field( array $field = array() ): string {
		$html = $this->build_html( $field );

		if ( isset( $field['fields'] ) && is_array( $field['fields'] ) ) {
			foreach ( $field['fields'] as $child_field ) {
				$html .= $this->build_html( $child_field );
			}
		}

		return $this->wrap( $field, $html );
	}

	/**
	 * @param array $field
	 *
	 * @return string
	 */
	public function get_text_input( array $field ): string {
		$field = $this->prepare_field( $field );

		return '<input 
			type="' . esc_attr( $field['type'] ) . '"
			id="' . esc_attr( $field['id'] ) . '"
			name="' . esc_attr( $field['name'] ) . '" 
			placeholder="' . esc_attr( $field['placeholder'] ) . '" 
			value="' . esc_attr( $field['value'] ) . '" 
			' . implode( ' ', $field['attributes'] ) . '
			class="' . esc_attr( implode( ' ', $field['class'] ) ) . '" />' . "\n";
	}

	/**
	 * @param array $field
	 *
	 * @return string
	 */
	public function get_textarea( array $field ): string {
		$attributes         = $field['attributes'] ?? array();
		$attributes['rows'] = $attributes['rows'] ?? 5;
		$attributes['cols'] = $attributes['cols'] ?? 50;
		$field              = $this->prepare_field( $field );

		return '<textarea 
			id="' . esc_attr( $field['id'] ) . '" 
			name="' . esc_attr( $field['name'] ) . '" 
			class="' . esc_attr( implode( ' ', $field['class'] ) ) . '"
			' . implode( ' ', $field['attributes'] ) . '
			placeholder="' . esc_attr( $field['placeholder'] ) . '">' . esc_textarea( $field['value'] ) . '</textarea>' . "\n";
	}

	/**
	 * @param array $field
	 *
	 * @return string
	 */
	public function get_checkbox( array $field ): string {
		$field   = $this->prepare_field( $field );
		$checked = checked( $field['value'], '1', false );

		$html = '<label><input id="' . esc_attr( $field['id'] ) . '" 
			type="' . esc_attr( $field['type'] ) . '"
			class="' . esc_attr( implode( ' ', $field['class'] ) ) . '" 
			' . implode( ' ', $field['attributes'] ) . '
			name="' . esc_attr( $field['name'] ) . '" ' . $checked . '/>' . "\n";

		$html .= isset( $field['text'] ) ? '<span class="main-checkbox__text">' . $field['text'] . ' </span>' : '';
		$html .= '</label>';

		return $html;
	}

	/**
	 * @param array $field
	 *
	 * @return string
	 */
	public function get_multi_checkbox( array $field ): string {
		$field = $this->prepare_field( $field );

		$html = '';
		foreach ( $field['options'] as $k => $v ) {
			$checked = is_array( $field['value'] ) && in_array( $k, $field['value'], true );
			$html   .= '<label for="' . esc_attr( $field['id'] . '_' . $k ) . '" class="checkbox_multi prodigy-main-label">
				<input type="checkbox" ' . checked( $checked, true, false ) . '
					name="' . esc_attr( $field['name'] ) . '[]" 
					value="' . esc_attr( $k ) . '" 
					id="' . esc_attr( $field['id'] . '_' . $k ) . '" /> ' . $v . '</label> ';
		}

		return $html;
	}

	/**
	 * @param array $field
	 *
	 * @return string
	 */
	public function get_radio_input( array $field ): string {
		$field = $this->prepare_field( $field );

		$html = '';
		foreach ( $field['options'] as $k => $v ) {
			$checked = $k === $field['value'];
			$html   .= '<label for="' . esc_attr( $field['id'] . '_' . $k ) . '" 
				class="prodigy-main-label"><input type="radio" ' . checked( $checked, true, false ) . ' 
				name="' . esc_attr( $field['name'] ) . '" value="' . esc_attr( $k ) .
				' ' . implode( ' ', $field['attributes'] ) . '" 
				id="' . esc_attr( $field['id'] . '_' . $k ) . '" /> ' . $v . '</label> ';
		}

		return $html;
	}

	/**
	 * @param array $field
	 *
	 * @return string
	 */
	public function get_dropdown( array $field ): string {
		$field = $this->prepare_field( $field );

		$html = sprintf(
			'<select name="%s" id="%s" %s class="%s">',
			esc_attr( $field['name'] ),
			esc_attr( $field['id'] ),
			implode( ' ', $field['attributes'] ),
			esc_attr( implode( ' ', $field['class'] ) )
		);

		if ( isset( $field['options'] ) ) {
			foreach ( $field['options'] as $k => $v ) {
				if ( is_array( $v ) ) {
					$label = $v['label'] ?? '';
					$html  .= sprintf( '<optgroup label="%s">', $label );
					if ( isset( $v['options'] ) ) {
						foreach ( $v['options'] as $kk => $vv ) {
							$selected = $kk === $field['value'];
							$html     .= sprintf( '<option %s value="%s">%s</option>', selected( $selected, true, false ), esc_attr( $kk ), $vv );
						}
					}
					$html .= '</optgroup>';
				} else {
					$selected = (string) $k === (string) $field['value'];
					$html     .= sprintf( '<option %s value="%s">%s</option>', selected( $selected, true, false ), esc_attr( $k ), $v );
				}
			}
		}

		$html .= '</select> ';

		return $html;
	}

	/**
	 * @param array $field
	 *
	 * @return string
	 */
	public function get_color_input( array $field ): string {
		$field = $this->prepare_field( $field );

		return '<div class="color-picker" style="position:relative;">
					<input type="text"
						id="' . esc_attr( $field['id'] ) . '"
						name="' . esc_attr( $field['name'] ) . '"
						placeholder="' . esc_attr( $field['placeholder'] ) . '"
						value="' . esc_attr( $field['value'] ) . '"
						' . implode( ' ', $field['attributes'] ) . '
						class="color ' . esc_attr( implode( ' ', $field['class'] ) ) . '" />
					<div style="position:absolute;background:#FFF;z-index:99;border-radius:100%;"
						class="colorpicker"></div>
				</div>';
	}

	/**
	 * @param array $field
	 *
	 * @return array
	 */
	private function prepare_field( array $field ): array {
		$field = array_merge(
			array(
				'type'        => 'text',
				'class'       => array(),
				'placeholder' => '',
				'default'     => '',
				'description' => '',
				'label'       => '',
				'attributes'  => array(),
			),
			$field
		);

		$field['class'] = ! is_array( $field['class'] ) ? array( $field['class'] ) : $field['class'];
		$field['name']  = $this->prefix . ( $field['name'] ?? $field['id'] );
		$field_value    = $field['value'] ?? '';

		if ( ! isset( $field['value'] ) ) {
			if ( $this->post ) {
				$field_value = get_post_meta( $this->post->ID, $field['id'], true );
			} else {
				$field_value = get_option( $field['id'] );
			}
		}
		$field['value'] = $field_value ?? $field['default'];

		$attributes = array_filter(
			$field['attributes'],
			function ( $value, $key ) {
				return ! in_array(
                    $key,
                    array(
						'class',
						'type',
						'value',
						'placeholder',
					),
					true
				) && ! is_array( $value );
			},
			ARRAY_FILTER_USE_BOTH
		);

		foreach ( $attributes as $attribute => &$attribute_value ) {
			$attribute_value = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
		}
		$field['attributes'] = $attributes;

		return $field;
	}


	/**
	 * @param array $field
	 *
	 * @return string
	 */
	protected function build_html( array $field = array() ): string {
		$html = '';

		switch ( $field['type'] ) {
			case 'section_title':
				$html .= '<h4 class="prodigy-plugin-settings__subtitle">' . $field['label'] . '</h4>';
				break;
			case 'textarea':
				$html .= $this->get_textarea( $field );
				break;
			case 'checkbox':
				$html .= $this->get_checkbox( $field );
				break;
			case 'multi_checkbox':
				$html .= $this->get_multi_checkbox( $field );
				break;
			case 'radio':
				$html .= $this->get_radio_input( $field );
				break;
			case 'dropdown':
				$html .= $this->get_dropdown( $field );
				break;
			case 'color':
				$html .= $this->get_color_input( $field );
				break;
			default:
				$html .= $this->get_text_input( $field );
				break;
		}
		if ( ! empty( $field['description'] ) ) {
			$html .= '<span class="description">' . $field['description'] . '</span>';
		}
		return $html;
	}

	/**
	 * @param array  $field
	 * @param string $html
	 *
	 * @return string
	 */
	protected function wrap( array $field = array(), string $html = '' ): string {
		if ( 'section_title' === $field['type'] || 'hidden' === $field['type'] ) {
			return $html;
		}

		$class = $field['wrapper-class'] ?? '';
		$label = $field['label'] ?? '';
		return "
			<div class=\"prodigy-form-row mb-26 $class\">
				<div class=\"prodigy-form-left-col\">
					<p>$label</p>
				</div>
				<div class=\"prodigy-form-right-col\">
					$html
				</div>
			</div>
		";
	}
}
