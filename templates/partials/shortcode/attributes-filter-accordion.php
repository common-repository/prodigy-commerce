<?php
/* Template Name: Attributes Filter shortcode */
use Prodigy\Includes\Frontend\Shortcodes\Prodigy_Short_Code_Attributes_Filter;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Widgets\Prodigy_Filters_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$idwidget     = $attr_shortcode['idwidget'] ?? '';
$heading_text = $attr_shortcode['attrs_style_heading_text'] ?? 'Filter by';
$count_show_attributes_value = $attr_shortcode['attrs_style_attr_name_limit_list'] ?? ($attr_shortcode['visible_amount'] ?? Prodigy_Filters_Widget::DEFAULT_VISIBLE_AMOUNT);
$vision_section_amount = $attr_shortcode['attrs_content_expanded_sections_list'] ?? ($attr_shortcode['expanded_amount'] ?? Prodigy_Filters_Widget::DEFAULT_EXPANDED_AMOUNT);
?>


<?php if ( $idwidget ) : ?>
<div class="prodigy-filter__main prodigy-custom-template">
	<div class="prodigy-shop-sidebar__btn-close-wrap">
	    <h3 class="prodigy-filter__btn-close-title flex-grow-1">Filters</h3>
		<button class="prodigy-shop-sidebar-btn" 
			id="filter-toggle-btn" 
			aria-label="Close Sidebar">
				<span class="icon icon-close"></span>
		</button>
	</div>
	<h3 class="prodigy-filter__title"><?php echo $heading_text; ?></h3>
<?php endif; ?>

<div class="prodigy-filter__accordion">
	<?php $iterator = 0 ?>
		<?php foreach ( $filters as $filter ) : ?>
		<?php $iterator++; ?>
		<?php if ( ! empty( $filter['values'] ) ) : ?>
	<div class="prodigy-filter__card prodigy-filter__card-list-item mb-0">
		<div class="position-relative"
		    aria-expanded="<?php echo $vision_section_amount >= $iterator ? 'true' : '' ?>"
		    data-toggle="collapse"
			data-target="#collapse_<?php echo trim($filter['name']) ?>">
			<h5 class="prodigy-filter__subtitle"><?php echo esc_attr( ucwords( $filter['name'] ) ); ?></h5>
			<button class="prodigy-filter__card-btn prodigy-icon-btn">
				<i class="icon-arrow-down"></i>
			</button>
		</div>
		<div
			class="collapse <?php echo $vision_section_amount >= $iterator ? 'show' : '' ?>"
			id="collapse_<?php echo trim($filter['name']) ?>"
		>
			<div class="prodigy-filter__card-body">
				<ul class="prodigy-filter__card-list filter__item-list-js"
					id="filter_attr_<?php echo esc_attr( $filter['id'] ); ?>"
					data-count-show="<?php echo $count_show_attributes_value; ?>">
					<?php
					$count = false;
					$index = 1;
					foreach ( $filter['values'] as $attribute_values ) :
						if ( count( $filter['values'] ) < Prodigy_Short_Code_Attributes_Filter::SHOW_ATTRIBUTE_VALUE_BY_COUNT_PRODUCTS
						) {
							continue;
						}

						if ( isset( $current_object->taxonomy ) && ! empty( $current_object->taxonomy == Prodigy::get_prodigy_category_type() )
						&& count( $filter['values'] ) < Prodigy_Short_Code_Attributes_Filter::SHOW_ATTRIBUTE_VALUE_BY_COUNT_PRODUCTS
						) {
							continue;
						}

						$list_args = $filters_output[ $attribute_values['name'] ];

						if ( empty( $list_args ) ) {
							$list_args = build_query( array( $filter['id'] => $attribute_values['name'] ) );
						}

						$active_value = false;
						if ( ! empty( $get_request['attr'] ) ) {
							if ( array_key_exists( $filter['id'], $get_request['attr'] ) ) {
								$active_value = strpos( $get_request['attr'][ $filter['id'] ], $attribute_values['name'] );
							}
						}
						?>
					<?php if (!empty((int) $count_show_attributes_value)): ?>
						<li class="prodigy-filter__card-list-item" style="display:<?php echo $index > (int) $count_show_attributes_value ? 'none' : ''?>" >
					<?php else: ?>
						<li class="prodigy-filter__card-list-item">
					<?php endif; ?>
						<span class="prodigy-filter__item-list-txt d-flex flex-row justify-content-start align-items-center mb-16">
							<input
                                    type="checkbox"
                                    class="attribute-filter-js"
                                    data-attribute-name="<?php echo esc_attr( $filter['id'] ); ?>"
                                    data-attribute-value="<?php echo esc_attr( $attribute_values['name'] ); ?>"
                                    data-filter="<?php echo ! empty( $attribute_values['count'] ) ? urldecode( $list_args ) : ''; ?>"
                             <?php echo !is_bool( $active_value ) ? 'checked' : '' ?>>
                                <a class="flex-grow-1">
								<?php echo esc_attr( $attribute_values['name'] ); ?>
							</a>
							<?php if ( $idwidget ) : ?>
								<?php if ( $attr_shortcode['attrs_content_prod_count'] === 'yes' ) : ?>
									<span class="filter__item-list-info ml-4 flex-1 text-right">(<?php echo esc_attr( $attribute_values['count'] ); ?>)</span>
								<?php endif; ?>
							<?php else : ?>
								<span class="filter__item-list-info ml-4 flex-1 text-right">(<?php echo esc_attr( $attribute_values['count'] ); ?>)</span>
							<?php endif; ?>
						</span>
					</li>
						<?php
						$index++;
					endforeach;
					?>
					<?php
						$attributes_value_count = 0;
						if ( $active_filters ) {
							$attributes_value_count = count( $filter['values'] );
						}

						if ( $attributes_value_count > $count_show_attributes_value ): ?>
							<?php if (!empty($count_show_attributes_value)): ?>
								<?php $hidden_values = count($filter['values']) - (int) $count_show_attributes_value ?>
							<?php endif; ?>
							<?php if (!empty((int) $count_show_attributes_value)): ?>
								<button class="prodigy-filter__btn filter__btn-js"
							    data-id="<?php echo esc_attr( $filter['id'] ); ?>"
							    id="btn_txt_more_<?php echo esc_attr( $filter['id'] ); ?>">
									<span class="filter__btn-txt-js"><?php esc_attr_e( 'Show more', 'prodigy' ) ?></span>
									<span class="filter__btn-hidden-count"><?php echo '(+' . $hidden_values . ')' ?></span>
						        </button>
							<?php endif; ?>
						<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>
		<?php endif; ?>
	<?php endforeach; ?>
</div>

<?php if ( $idwidget ) : ?>
	</div>
<?php endif; ?>
