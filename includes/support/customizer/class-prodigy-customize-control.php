<?php
namespace Prodigy\Includes\Support\Customizer;

use WP_Customize_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Prodigy_Customize_Control' ) ) :
	class Prodigy_Customize_Control extends WP_Customize_Control {
		public $encodeLabel = true;

		protected function render_content() {
			$input_id         = '_customize-input-' . $this->id;
			$description_id   = '_customize-description-' . $this->id;
			$describedby_attr = ( ! empty( $this->description ) ) ? ' aria-describedby="' . esc_attr( $description_id ) . '" ' : '';
			switch ( $this->type ) {
				case 'checkbox':
					?>
				<span class="customize-inside-control-row">
					<input
						id="<?php echo esc_attr( $input_id ); ?>"
						<?php echo esc_attr( $describedby_attr ); ?>
						type="checkbox"
						value="<?php echo esc_attr( $this->value() ); ?>"
						<?php $this->link(); ?>
						<?php checked( $this->value() ); ?>
					/>
					<label for="<?php echo esc_attr( $input_id ); ?>"><?php echo $this->encodeLabel ? esc_html( $this->label ) : esc_attr( $this->label ); ?></label>
					<?php if ( ! empty( $this->description ) ) : ?>
						<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo esc_attr( $this->description ); ?></span>
					<?php endif; ?>
				</span>
					<?php
					break;
				case 'radio':
					if ( empty( $this->choices ) ) {
						return;
					}

					$name = '_customize-radio-' . $this->id;
					?>
					<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo $this->encodeLabel ? esc_html( $this->label ) : $this->label; ?></span>
			<?php endif; ?>
					<?php if ( ! empty( $this->description ) ) : ?>
				<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo esc_attr( $this->description ); ?></span>
			<?php endif; ?>

					<?php foreach ( $this->choices as $value => $label ) : ?>
				<span class="customize-inside-control-row">
						<input
							id="<?php echo esc_attr( $input_id . '-radio-' . $value ); ?>"
							type="radio"
							<?php echo esc_attr( $describedby_attr ); ?>
							value="<?php echo esc_attr( $value ); ?>"
							name="<?php echo esc_attr( $name ); ?>"
							<?php $this->link(); ?>
							<?php checked( $this->value(), $value ); ?>
							/>
						<label for="<?php echo esc_attr( $input_id . '-radio-' . $value ); ?>"><?php echo esc_html( $label ); ?></label>
					</span>
			<?php endforeach; ?>
					<?php
					break;
				case 'select':
					if ( empty( $this->choices ) ) {
						return;
					}

					?>
					<?php if ( ! empty( $this->label ) ) : ?>
				<label for="<?php echo esc_attr( $input_id ); ?>" class="customize-control-title"><?php echo $this->encodeLabel ? esc_html( $this->label ) : esc_attr( $this->label ); ?></label>
			<?php endif; ?>
					<?php if ( ! empty( $this->description ) ) : ?>
				<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo esc_attr( $this->description ); ?></span>
			<?php endif; ?>

				<select id="<?php echo esc_attr( $input_id ); ?>" <?php echo esc_attr( $describedby_attr ); ?> <?php $this->link(); ?>>
					<?php
					foreach ( $this->choices as $value => $label ) {
						echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' . esc_attr( $label ) . '</option>';
					}
					?>
				</select>
					<?php
					break;
				case 'textarea':
					?>
					<?php if ( ! empty( $this->label ) ) : ?>
				<label for="<?php echo esc_attr( $input_id ); ?>" class="customize-control-title"><?php echo $this->encodeLabel ? esc_html( $this->label ) : esc_attr( $this->label ); ?></label>
			<?php endif; ?>
					<?php if ( ! empty( $this->description ) ) : ?>
				<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo esc_attr( $this->description ); ?></span>
			<?php endif; ?>
				<textarea
					id="<?php echo esc_attr( $input_id ); ?>"
					rows="5"
					<?php echo esc_attr( $describedby_attr ); ?>
					<?php $this->input_attrs(); ?>
					<?php $this->link(); ?>
				><?php echo esc_textarea( $this->value() ); ?></textarea>
					<?php
					break;
				case 'dropdown-pages':
					?>
					<?php if ( ! empty( $this->label ) ) : ?>
				<label for="<?php echo esc_attr( $input_id ); ?>" class="customize-control-title"><?php echo $this->encodeLabel ? esc_html( $this->label ) : esc_attr( $this->label ); ?></label>
			<?php endif; ?>
					<?php if ( ! empty( $this->description ) ) : ?>
				<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo esc_attr( $this->description ); ?></span>
			<?php endif; ?>

					<?php
					$dropdown_name     = '_customize-dropdown-pages-' . $this->id;
					$show_option_none  = __( '&mdash; Select &mdash;' );
					$option_none_value = '0';
					$dropdown          = wp_dropdown_pages(
						array(
							'name'              => esc_attr( $dropdown_name ),
							'echo'              => 0,
							'show_option_none'  => esc_attr( $show_option_none ),
							'option_none_value' => esc_attr( $option_none_value ),
							'selected'          => esc_attr( $this->value() ),
						)
					);
					if ( empty( $dropdown ) ) {
						$dropdown  = sprintf( '<select id="%1$s" name="%1$s">', esc_attr( $dropdown_name ) );
						$dropdown .= sprintf( '<option value="%1$s">%2$s</option>', esc_attr( $option_none_value ), esc_html( $show_option_none ) );
						$dropdown .= '</select>';
					}

					// Hackily add in the data link parameter.
					$dropdown = str_replace( '<select', '<select ' . $this->get_link() . ' id="' . esc_attr( $input_id ) . '" ' . $describedby_attr, $dropdown );

					// Even more hacikly add auto-draft page stubs.
					// @todo Eventually this should be removed in favor of the pages being injected into the underlying get_pages() call. See <https://github.com/xwp/wp-customize-posts/pull/250>.
					$nav_menus_created_posts_setting = $this->manager->get_setting( 'nav_menus_created_posts' );
					if ( $nav_menus_created_posts_setting && current_user_can( 'publish_pages' ) ) {
						$auto_draft_page_options = '';
						foreach ( $nav_menus_created_posts_setting->value() as $auto_draft_page_id ) {
							$post = get_post( $auto_draft_page_id );
							if ( $post && 'page' === $post->post_type ) {
								$auto_draft_page_options .= sprintf( '<option value="%1$s">%2$s</option>', esc_attr( $post->ID ), esc_html( $post->post_title ) );
							}
						}
						if ( $auto_draft_page_options ) {
							$dropdown = str_replace( '</select>', $auto_draft_page_options . '</select>', $dropdown );
						}
					}

					echo esc_attr( $dropdown );
					?>
					<?php if ( $this->allow_addition && current_user_can( 'publish_pages' ) && current_user_can( 'edit_theme_options' ) ) : // Currently tied to menus functionality. ?>
				<button type="button" class="prodigy-button-link add-new-toggle">
						<?php
						/* translators: %s: Add New Page label. */
						printf( __( '+ %s' ), esc_attr( get_post_type_object( 'page' )->labels->add_new_item ) );
						?>
				</button>
				<div class="new-content-item">
					<label for="create-input-<?php echo esc_attr( $this->id ); ?>"><span class="screen-reader-text"><?php esc_html_e( 'New page title' ); ?></span></label>
					<input type="text" id="create-input-<?php echo esc_attr( $this->id ); ?>" class="create-item-input" placeholder="<?php esc_attr_e( 'New page title&hellip;' ); ?>">
					<button type="button" class="button add-content"><?php esc_html( 'Add' ); ?></button>
				</div>
			<?php endif; ?>
					<?php
					break;
				default:
					?>
					<?php if ( ! empty( $this->label ) ) : ?>
				<label for="<?php echo esc_attr( $input_id ); ?>" class="customize-control-title"><?php echo $this->encodeLabel ? esc_html( $this->label ) : esc_attr( $this->label ); ?></label>
			<?php endif; ?>
					<?php if ( ! empty( $this->description ) ) : ?>
				<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo esc_attr( $this->description ); ?></span>
			<?php endif; ?>
				<input
					id="<?php echo esc_attr( $input_id ); ?>"
					type="<?php echo esc_attr( $this->type ); ?>"
					<?php echo esc_attr( $describedby_attr ); ?>
					<?php $this->input_attrs(); ?>
					<?php if ( ! isset( $this->input_attrs['value'] ) ) : ?>
						value="<?php echo esc_attr( $this->value() ); ?>"
					<?php endif; ?>
					<?php $this->link(); ?>
				/>
					<?php
					break;
			}
		}
	}
endif;
