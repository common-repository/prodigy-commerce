<?php
/* Template Name: Attributes Filter shortcode */
use Prodigy\Includes\Frontend\Shortcodes\Prodigy_Short_Code_Attributes_Filter;
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Widgets\Prodigy_Filters_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$idwidget                    = $attr_shortcode['idwidget'] ?? '';
$heading_text                = $attr_shortcode['attrs_style_heading_text'] ?? 'Filter by';
$count_show_attributes_value = $attr_shortcode['attrs_style_attr_name_limit_list'] ?? ($attr_shortcode['visible_amount'] ?? Prodigy_Filters_Widget::DEFAULT_VISIBLE_AMOUNT);
?>


<?php if ( $idwidget ) : ?>
<div class="prodigy-filter__main prodigy-custom-template">
	<div class="prodigy-shop-sidebar__btn-close-wrap">
		<h3 class="prodigy-filter__btn-close-title">Filters</h3>
		<button class="prodigy-shop-sidebar-btn" 
			id="filter-toggle-btn" 
			aria-label="Close Sidebar">
				<span class="icon icon-close"></span>
		</button>
	</div>
	<h3 class="prodigy-filter__title"><?php echo $heading_text; ?></h3>
	<?php endif; ?>
	<div class="filter-widget-container-js mt-20">
		<?php foreach ( $filters ?? [] as $filter ): ?>
			<?php if ( ! empty( $filter['values'] ) ): ?>
				<div class="prodigy-filter__item">
					<h5 class="prodigy-filter__subtitle">
						<span><?php echo esc_attr( ucwords( $filter['name'] ) ) ?></span>
					</h5>

					<?php
					$index = 1;
					?>
					<ul class="prodigy-filter__item-list filter__item-list-js"
					    id="filter_attr_<?php echo esc_attr( $filter['id'] ); ?>"
					    data-count-show="<?php echo $count_show_attributes_value; ?>">
						<?php foreach ( $filter['values'] as $attribute_values ):
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

						<?php if (!empty($count_show_attributes_value)): ?>
							<li class="prodigy-filter__item-list-li" style="display:<?php echo $index > $count_show_attributes_value ? 'none' : ''?>" >
						<?php else: ?>
							<li class="prodigy-filter__item-list-li">
						<?php endif; ?>

	                    <span class="category-filter-js prodigy-filter__item-list-txt flex-1 <?php if ( ! is_bool( $active_value ) ) {
		                    echo 'filter__item-list-txt--active';
	                    } ?>">
	                    <?php $url = !empty($attribute_values['count']) ? urldecode($list_args) : ''; ?>
                        <?php if ( is_bool( $active_value ) ): ?>
                            <input type="checkbox"><a
                                class="attribute-filter-js w-100"
                                href="<?php echo $url ?>"
                                data-attribute-name="<?php echo esc_attr( $filter['id'] )?>"
                                data-attribute-value="<?php echo esc_attr( $attribute_values['name'] ); ?>"
                            >
                                <?php echo esc_attr( $attribute_values['name'] ); ?>
                            </a>
                        <?php else: ?>
		                    <input type="checkbox" checked><span class="prodigy-filter__item-list-txt-active"><?php echo esc_attr( $attribute_values['name'] ); ?></span>
	                    <?php endif; ?>
	                    <?php if ( ! is_bool( $active_value ) ) { ?>
		                    <button class="prodigy-filter__item-list-close icon icon-close" type="button"
		                            id="filter_text_btn_<?php echo esc_attr( $filter['id'] ); ?>"
		                            data-attribute-name="<?php echo esc_attr( $filter['id'] ); ?>"
		                            data-attribute-value="<?php echo esc_attr( $attribute_values['name'] ); ?>"></button>
	                    <?php } ?>
						<?php if ( $idwidget ): ?>
							<?php if ( $attr_shortcode['attrs_content_prod_count'] === 'yes' ): ?>
								<span class="filter__item-list-info">
                                    (<?php echo esc_attr( $attribute_values['count'] ); ?>)
                                </span>
							<?php endif; ?>
						    <?php else: ?>
								<span class="filter__item-list-info">
                                   (<?php echo esc_attr( $attribute_values['count'] ); ?>)
                                </span>
							<?php endif; ?>
                    </span>
							</li>
							<?php
							$index ++;
						endforeach;
						?>
						<?php
						$attributes_value_count = 0;
						if ( $active_filters ) {
							$attributes_value_count = count( $filter['values'] );
						}
						if ( $attributes_value_count > $count_show_attributes_value ): ?>
							<?php if (!empty($count_show_attributes_value)): ?>
								<?php $hidden_values = count($filter['values']) - $count_show_attributes_value ?>
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
				<div class="prodigy-divider-block prodigy-divider-block--light w-100"></div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>

	<?php if ( $idwidget ): ?>
</div>
<?php endif; ?>
