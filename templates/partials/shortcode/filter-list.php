<?php
/* Template Name: Attributes Filter shortcode */

use Prodigy\Includes\Frontend\Mappers\Prodigy_Filter_Data_Mapper;
use Prodigy\Includes\Prodigy;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<h3 class="prodigy-filter__title prodigy-filter-title-js"><?php echo esc_html( $heading_text ); ?></h3>
<div class="prodigy-filter-js prodigy-filter__list-filter prodigy-filter__list">
	<?php foreach ( $filters ?? array() as $filter ) : ?>
		<?php if ( ! empty( $filter['values'] ) ) : ?>
			<div class="prodigy-filter__item">
				<h5 class="prodigy-filter__subtitle">
					<span><?php echo esc_html( ucwords( $filter['name'] ) ); ?></span>
				</h5>

				<?php
				$index = 1;
				?>
				<ul class="prodigy-filter__item-list filter__item-list-js"
					id="filter_attr_<?php echo esc_attr( $filter['id'] ); ?>"
					data-count-show="<?php echo esc_attr( $count_show_attributes_value ); ?>">
					<?php
					foreach ( $filter['values'] as $attribute_values ) {
						if ( count( $filter['values'] ) < Prodigy_Filter_Data_Mapper::SHOW_ATTRIBUTE_VALUE_BY_COUNT_PRODUCTS
						) {
							continue;
						}

						if ( isset( $current_object->taxonomy ) && ! empty( $current_object->taxonomy === Prodigy::get_prodigy_category_type() )
							&& count( $filter['values'] ) < Prodigy_Filter_Data_Mapper::SHOW_ATTRIBUTE_VALUE_BY_COUNT_PRODUCTS
						) {
							continue;
						}

						$list_args = $filters_output[ $attribute_values['name'] ];

						if ( empty( $list_args ) ) {
							$list_args = build_query( array( $filter['id'] => $attribute_values['name'] ) );
						}

						$active_value = false;
						if ( isset( $attribute_values['slug'] ) && ! empty( $get_request['attr'] ) && array_key_exists( $filter['id'], $get_request['attr'] ) ) {
							$pieces       = explode( ';', $get_request['attr'][ $filter['id'] ] );
							$active_value = in_array( $attribute_values['slug'], $pieces, true );
						}
						?>

						<?php if ( ! empty( $count_show_attributes_value ) ) : ?>
						<li class="prodigy-filter__item-list-li" style="display:<?php echo $index > $count_show_attributes_value ? 'none' : ''; ?>" >
					<?php else : ?>
						<li class="prodigy-filter__item-list-li">
					<?php endif; ?>

						<span class="category-filter-js prodigy-filter__item-list-category-filter prodigy-filter__item-list-txt flex-1
							<?php
							if ( $active_value ) {
								echo 'filter__item-list-txt--active';
							}
							?>
						">
							<?php $url = ! empty( $attribute_values['count'] ) ? urldecode( $list_args ) : ''; ?>
						<input type="checkbox"
								class="attribute-filter-js"
								data-attribute-id="<?php echo esc_attr( $filter['id'] ); ?>"
								data-attribute-value="<?php echo esc_attr( $attribute_values['slug'] ?? $attribute_values['name'] ); ?>"
								data-filter="<?php echo ! empty( $attribute_values['count'] ) ? esc_attr( urldecode( $list_args ) ) : ''; ?>"
							<?php echo $active_value ? 'checked' : ''; ?>>
						<a class="attribute-filter-js prodigy-filter__item-list-name">
							<?php echo esc_html( $attribute_values['name'] ); ?>
						</a>
							<?php if ( $args['idWidget'] ) : ?>
								<?php if ( $attr_shortcode['attrs_content_prod_count'] === 'yes' ) : ?>
									<span class="prodigy-filter__item-list-info">
									(<?php echo esc_html( $attribute_values['count'] ); ?>)
								</span>
								<?php endif; ?>
							<?php else : ?>
								<span class="prodigy-filter__item-list-info">
									(<?php echo esc_html( $attribute_values['count'] ); ?>)
								</span>
							<?php endif; ?>
					</span>
						</li>
						<?php
						++$index;
					}

					$attributes_value_count = 0;
					if ( $active_filters ) {
						$attributes_value_count = count( $filter['values'] );
					}
					if ( $attributes_value_count > $count_show_attributes_value ) :
						?>
						<?php if ( ! empty( $count_show_attributes_value ) ) : ?>
							<?php $hidden_values = count( $filter['values'] ) - $count_show_attributes_value; ?>
						<button class="prodigy-filter__btn prodigy-main-button__filter-btn filter__btn-js"
								data-id="<?php echo esc_attr( $filter['id'] ); ?>"
								id="btn_txt_more_<?php echo esc_attr( $filter['id'] ); ?>">
							<span class="prodigy-cursor-pointer filter__btn-txt-js"><?php esc_attr_e( 'Show more', 'prodigy' ); ?></span>
							<span class="filter__btn-hidden-count"><?php echo '(+' . esc_html( $hidden_values . ')' ); ?></span>
						</button>
					<?php endif; ?>
					<?php endif; ?>
				</ul>
			</div>
			<div class="prodigy-divider-block prodigy-divider-block--light w-100"></div>
		<?php endif; ?>
	<?php endforeach; ?>
</div>
