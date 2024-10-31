<?php
use Prodigy\Includes\Frontend\Prodigy_Layouts_Manager;
use Prodigy\Includes\Helpers\Prodigy_Template;
use Prodigy\Includes\Helpers\Prodigy_Page;
?>

<?php defined( 'ABSPATH' ) || exit; ?>

<input type="hidden" id="product_id" value="<?php echo ! empty( $product ) ? esc_attr( $product->get_remote_product_id() ) : null; ?>">
<input type="hidden" id="default_select_option" value="<?php echo ( isset( $elementor_settings ) && ! empty( $elementor_settings['add_to_cart_attribute_value_select_default_text'] ) ) ? esc_attr( $elementor_settings['add_to_cart_attribute_value_select_default_text'] ) : 'Choose an option'; ?>">
<input type="hidden" id="regular_price_state_option" value="<?php echo isset( $elementor_settings ) ? esc_attr( $elementor_settings['attributes_price_control_regular_price'] ?? '' ) : ''; ?>">
<input type="hidden" class="number_of_attributes-js" value="<?php echo isset( $variants ) ? esc_attr( count( $variants ) ) : 0; ?>">
<input type="hidden" class="is_tired_price-js" value='<?php echo esc_attr( $is_tiered_prices ); ?>'>
<input type="hidden" id="product-options-data-js" value='<?php echo esc_attr( wp_json_encode( $product_options ?? array() ) ); ?>'>
<input type="hidden" id="product-logos-data-js" value='<?php echo esc_attr( wp_json_encode( $logos ?? array() ) ); ?>' data-logos='<?php echo esc_attr( wp_json_encode( $logos ?? array() ) ); ?>'>
<input type="hidden" id="product-logo-locations-data-js" value='<?php echo esc_attr( wp_json_encode( $logo_location ?? array() ) ); ?>' data-locations='<?php echo esc_attr( wp_json_encode( $logo_locations ?? array() ) ); ?>'>
<input type="hidden" id="master-logo-locations-data-js" value='<?php echo esc_attr( wp_json_encode( $master_logos ?? array() ) ); ?>' data-locations='<?php echo esc_attr( wp_json_encode( $master_logos ?? array() ) ); ?>'>
<input type="hidden" id="variant-data-js">
<input type="hidden" data-attr="<?php echo esc_url( Prodigy_Page::prodigy_get_cart_url() ); ?>" class="pg-cart-url-js">
<input type="hidden" data-options="<?php echo esc_attr( wp_json_encode( $variant_options_intersect ) ); ?>"
		class="variants-options-intersect-js">
<div class="prodigy-custom-template">
	<div class="variants-container-js" data-variants='<?php echo esc_attr( wp_json_encode( $prepared_variants ?? array(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE ) ); ?>' data-attributes='<?php echo esc_attr( wp_json_encode( $options ?? array(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE ) ); ?>'>
		<?php if ( ! empty( $variants ) ) : ?>
			<?php if ( $product->get_display_options_type() === 'dropdown' ) : ?>
				<?php Prodigy_Template::prodigy_get_template( 'single-product/variants.php', $args ); ?>
			<?php else : ?>
				<?php Prodigy_Template::prodigy_get_template( 'single-product/swatch-variants.php', $args ); ?>
			<?php endif; ?>
		<?php endif; ?>

		<?php
		if (
				! empty( $product->get_logos() ) &&
				( Prodigy_Layouts_Manager::is_elementor_live_preview() || Prodigy_Layouts_Manager::is_elementor_template() )
		) :
			?>
			<?php
			do_action(
				'prodigy_product_logo',
				array( 'params' => $args )
			)
			?>
		<?php endif; ?>
	</div>

	<?php Prodigy_Template::prodigy_get_template( 'single-product/modals/bulk_edit.php' ); ?>
	<?php Prodigy_Template::prodigy_get_template( 'single-product/modals/tiered_price.php' ); ?>
</div>
