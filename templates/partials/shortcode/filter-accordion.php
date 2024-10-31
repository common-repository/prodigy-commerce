<?php
/* Template Name: Attributes Filter shortcode */
use Prodigy\Includes\Prodigy;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Filter_Data_Mapper;
use Prodigy\Includes\Frontend\Prodigy_Layouts_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php if (isset($attr_shortcode['idWidget'])): ?>
    <input type="hidden" class="filter-widget-id" value="<?php echo $attr_shortcode['idWidget'] ?>">
<?php endif; ?>
<div class="prodigy-filter-by-title-js">
    <?php if ( (Prodigy_Layouts_Manager::is_elementor_template() || Prodigy_Layouts_Manager::is_elementor_live_preview())): ?>
        <h3 class="prodigy-filter__title"><?php esc_html_e( $heading_text, "prodigy" ); ?></h3>
    <?php endif; ?>
</div>

<div class="prodigy-filter__accordion prodigy-filter-js prodigy-filter-title-js">
        <?php $iterator = 0 ?>
        <?php foreach ( $args['filters'] as $filter ) : ?>
            <?php $iterator++; ?>
            <?php if ( ! empty( $filter['values'] ) ) : ?>
                <div class="prodigy-filter__card prodigy-filter__card-list-item mb-0">
                    <div class="position-relative"
                         data-toggle="collapse"
                         data-target="#collapse_<?php echo esc_attr( ucwords( $filter['slug'] ) ); ?>">
                        <h5 class="prodigy-filter__subtitle"><?php echo esc_html( ucwords( $filter['name'] ) ); ?></h5>
                        <button class="prodigy-filter__card-btn prodigy-icon-btn">
                            <i class="icon-arrow-down"></i>
                        </button>
                    </div>
                    <div
                            class="collapse <?php echo $args['vision_section_amount'] >= $iterator ? 'show' : '' ?>"
                            id="collapse_<?php echo esc_attr( ucwords( $filter['slug'] ) ); ?>"
                    >
                        <div class="prodigy-filter__card-body">
                            <ul class="prodigy-filter__card-list filter__item-list-js"
                                id="filter_attr_<?php echo esc_attr( $filter['id'] ); ?>"
                                data-count-show="<?php echo $args['count_show_attributes_value'] ?>">
                                <?php
                                $count = false;
                                $index = 1;
                                foreach ( $filter['values'] as $attribute_values ) :
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
	                                if ( ! empty( $get_request['attr'] ) && array_key_exists( $filter['id'], $get_request['attr'] ) ) {
		                                $pieces       = explode( ";", $get_request['attr'][ $filter['id'] ] );
		                                $active_value = in_array( $attribute_values['slug'] ?? '', $pieces, true );
	                                }
                                    ?>
                                    <?php if (!empty((int) $args['count_show_attributes_value'])): ?>
                                    <li class="prodigy-filter__card-list-item" style="display:<?php echo $index > (int) $args['count_show_attributes_value'] ? 'none' : ''?>" >
                                <?php else: ?>
                                    <li class="prodigy-filter__card-list-item">
                                <?php endif; ?>
                                    <span class="prodigy-filter__item-list-txt d-flex flex-row justify-content-start align-items-center mb-16">
							<input
                                    type="checkbox"
                                    class="attribute-filter-js"
                                    data-attribute-id="<?php echo esc_attr( $filter['id'] ); ?>"
                                    data-attribute-value="<?php echo esc_attr( $attribute_values['slug'] ?? $attribute_values['name'] ); ?>"
                                    data-attribute-name="<?php echo esc_attr( $attribute_values['name'] ); ?>"
                                    data-filter="<?php echo ! empty( $attribute_values['count'] ) ? urldecode( $list_args ) : ''; ?>"
                             <?php echo $active_value ? 'checked' : '' ?>>
                                <a class="prodigy-filter__item-list-name">
								<?php echo esc_html( $attribute_values['name'] ); ?>
							</a>
							<?php if ( $args['idWidget'] ) : ?>
                                <?php if ( $args['attrs_content_prod_count'] === 'yes' ) : ?>
                                    <span class="prodigy-filter__item-list-info">(<?php echo esc_html( $attribute_values['count'] ); ?>)</span>
                                <?php endif; ?>
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

                                if ( $attributes_value_count > $args['count_show_attributes_value'] ): ?>
                                    <?php if (!empty($args['count_show_attributes_value'])): ?>
                                        <?php $hidden_values = count($filter['values']) - (int) $args['count_show_attributes_value'] ?>
                                    <?php endif; ?>
                                    <?php if (!empty((int) $args['count_show_attributes_value'])): ?>
                                        <button class="prodigy-filter__btn prodigy-main-button__filter-btn filter__btn-js"
                                                data-id="<?php echo esc_attr( $filter['id'] ); ?>"
                                                id="btn_txt_more_<?php echo esc_attr( $filter['id'] ); ?>">
                                            <span class="prodigy-cursor-pointer filter__btn-txt-js"><?php esc_html_e( 'Show more', 'prodigy' ) ?></span>
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

