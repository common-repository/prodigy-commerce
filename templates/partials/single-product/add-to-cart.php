<?php

use Prodigy\Includes\Content\Prodigy_Product_Parser;
use Prodigy\Includes\Frontend\Mappers\Prodigy_Main_Data_Mapper;
use Prodigy\Includes\Frontend\Prodigy_Layouts_Manager;
use Prodigy\Includes\Helpers\Prodigy_Formatting;
use Prodigy\Includes\Helpers\Prodigy_Page;
use Prodigy\Includes\Prodigy_Elementor_Template_Loader;
use Prodigy\Includes\Prodigy_Options;
?>

<div id="subscriptions_block">
	<?php if ( ! empty( $subscriptions ) && empty( $product->get_remote_variants() ) ) : ?>
		<?php if ( isset( $elementor_settings ) ) : ?>
			<?php
			do_action(
				'prodigy_get_product_subscriptions',
				array(
					'subscriptions' => $subscriptions,
					'settings'      => $elementor_settings,
				)
			);
			?>
		<?php else : ?>
			<?php do_action( 'prodigy_get_product_subscriptions', array( 'subscriptions' => $subscriptions ) ); ?>
		<?php endif; ?>
	<?php endif; ?>
</div>

<?php if ( ! empty( $personalizations ) ) : ?>
	<input type="hidden" id="personalization-price-modifier-js"
			value="<?php echo esc_attr( $personalizations['modifier-type'] ); ?>">
	<input type="hidden" id="personalization-price-value-js"
			value="<?php echo esc_attr( $personalizations['modifier-value'] ); ?>">
	<div class="prodigy-personalization__container prodigy-custom-template">
		<?php if ( isset( $personalizations['personalization_id'] ) ) : ?>
			<h4 class="prodigy-personalization__title">
				<span>
					<?php esc_html_e( 'Product Personalization', 'prodigy' ); ?>
						<?php if ( Prodigy_Options::get_redemption_store_status() ) : ?>
							<?php if ( isset( $personalizations['modifier-type'] ) && ( (float) $personalizations['modifier-value'] > 0 ) ) : ?>
								<?php if ( $personalizations['modifier-type'] === Prodigy_Product_Parser::PERSONALIZATION_TYPE_FLAT ) : ?>
								(+<?php echo Prodigy_Product_Parser::$personalization_type_mapper[ esc_attr( $personalizations['modifier-type'] ) ] . Prodigy_Formatting::prodigy_price_format( esc_attr( $personalizations['modifier-value'] ) ) . ')'; ?>
							<?php else : ?>
								(+<?php echo esc_attr( $personalizations['modifier-value'] ) . Prodigy_Product_Parser::$personalization_type_mapper[ esc_attr( $personalizations['modifier-type'] ) ] . ')'; ?>
							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
				</span>
			</h4>
		<?php endif; ?>

		<?php foreach ( $personalizations as $field ) : ?>
			<div class="prodigy-personalization__field">
				<?php if ( isset( $field['attributes']['label'] ) ) : ?>
					<label class="prodigy-personalization__label prodigy-personalization__label-js">
					<span class="prodigy-personalization__field-name">
						<?php esc_html_e( $field['attributes']['label'], 'prodigy' ); ?>
					</span>
						<span class="prodigy-personalization__is-required">
						<?php esc_html_e( 'is Required', 'prodigy' ); ?>
					</span>
						<input
								type="text"
								class="prodigy-main-input prodigy-personalization__input prodigy-personalization__input-js"
								name="<?php echo esc_attr( $field['attributes']['label'] ); ?>"
								maxlength="<?php echo esc_attr( $field['attributes']['max-length'] ); ?>"
								placeholder="<?php esc_attr_e( 'Enter', 'prodigy' ); ?>"
								value="<?php echo esc_attr( $field['attributes']['default-text'] ); ?>"
								data-required="<?php echo esc_attr( $field['attributes']['required'] ); ?>"
								data-id="<?php echo esc_attr( $personalization_id ?? 0 ); ?>"
								data-field-id="<?php echo esc_attr( $field['id'] ); ?>"
							<?php echo esc_attr( $field['attributes']['default-text'] ) ? 'disabled' : ''; ?> />
					</label>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

<!-- total -->
<div class="prodigy-bulk__total-wrap bulk-total-block-js" style="display: none">
	<div class="prodigy-bulk__total-qty">
		<span class="prodigy-bulk__total-qty-txt"><?php esc_html_e( 'qty', 'prodigy' ); ?>:</span>
		<span class="prodigy-bulk__total-qty-price prodigy-bulk-total-qty-js">0</span>
	</div>
	<?php if ( $is_redemption_store ) : ?>
		<div class="prodigy-bulk__subtotal-save">
			<span class="prodigy-bulk__subtotal-save-txt"><?php esc_html_e( 'subtotal', 'prodigy' ); ?>:</span>
			<span class="prodigy-bulk__subtotal-save-price">
					<span class="bulk-total-price-js">$0.00</span>
					<br class="d-sm-none d-md-block d-lg-none">
					<span class="prodigy-bulk__subtotal-save-price-msg"></span>
				</span>
		</div>
	<?php endif; ?>
</div>
<div class="prodigy-product__values prodigy-custom-template flex-nowrap">
	<div class="flex-sm-nowrap aline-items-baseline prodigy-counter-wrap prodigy-counter-wrap-js">
		<div class="prodigy-counter flex-1 prodigy-counter-js">
			<button
					class="prodigy-main-button prodigy-main-button--counter prodigy-main-button--counter-minus icon icon-minus icon icon-minus counter-btn-minus-js"
					type="button"></button>
			<input class="prodigy-counter__total prodigy-main-input prodigy-main-input__total-count counter-count-js"
					value="1" maxlength="5">
			<button
					class="prodigy-main-button prodigy-main-button--counter prodigy-main-button--counter-plus icon icon-plus counter-btn-plus-js"
					type="button"></button>
		</div>
		<input type="hidden" class="cart-redirect-js"
				data-cart-redirect="<?php echo esc_attr( get_option( 'pg_add_cart_behaviour' ) ); ?>">
	</div>


	<!-- for added button add class prodigy-product__values-submit--added -->
	<div class="d-flex flex-row flex-nowrap align-items-center prodigy-product__values-btn-block">
		<?php if ( $is_show_view_cart_button ) : ?>
			<a class="prodigy-main-button prodigy-main-button--outline justify-content-center prodigy-cart__view-cart-link view-cart-js order-last"
				style="display: none" href="<?php echo esc_url( Prodigy_Page::prodigy_get_cart_url() ); ?>">
				<?php esc_html_e( 'View Cart', 'prodigy' ); ?>
			</a>
		<?php endif; ?>
		<?php if ( Prodigy_Elementor_Template_Loader::is_live_mode( $elementor_settings ?? null ) && $is_show_view_cart_button && ! Prodigy_Layouts_Manager::is_elementor_template() ) : ?>
			<a class="prodigy-main-button prodigy-main-button--outline justify-content-center prodigy-cart__view-cart-link view-cart-js order-last"
				href="<?php echo esc_url( Prodigy_Page::prodigy_get_cart_url() ); ?>">
				<?php esc_html_e( 'View Cart', 'prodigy' ); ?>
			</a>
		<?php endif; ?>
		<button type="button"
				class="prodigy-product__values-submit prodigy-main-button prodigy-main-button__add-to-cart add-to-cart-js">
			<span class="prodigy-product__values-active"><?php esc_html_e( 'Add to cart', 'prodigy' ); ?></span>
			<span class="prodigy-loader">
				<svg width="20px" height="20px" viewBox="0 0 64 64" version="1.1" xmlns="http://www.w3.org/2000/svg"
				>
					<g id="Selected" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<g id="Catalog-Page-With-Loader" transform="translate(-688, -418)">
							<g id="icn_loader"
								transform="translate(720, 450) rotate(-360) translate(-720, -450)translate(688, 418)">
								<path class="prodigy-custom-fill"
										d="M16.48,50.28 L14,53.34 C16.4771768,55.4468051 19.3074278,57.0989133 22.36,58.22 L23.74,54.48 C21.0922325,53.5169929 18.6347128,52.0952873 16.48,50.28 L16.48,50.28 Z"
										id="Path" fill="#2a3658" fill-rule="nonzero"></path>
								<path class="prodigy-custom-fill"
										d="M8.38,36 L4.38,36.82 C4.95041759,40.0511083 6.08073052,43.1577768 7.72,46 L11.18,44 C9.7959677,41.5131108 8.8488945,38.8071874 8.38,36 L8.38,36 Z"
										id="Path" fill="#2a3658" fill-rule="nonzero"></path>
								<path class="prodigy-custom-fill"
										d="M23.64,9.52 L22.26,5.78 C19.2427153,6.91161657 16.4470946,8.56326659 14,10.66 L16.48,13.72 C18.6046017,11.9147528 21.0275012,10.4934989 23.64,9.52 L23.64,9.52 Z"
										id="Path" fill="#2a3658" fill-rule="nonzero"></path>
								<path class="prodigy-custom-fill"
										d="M11.18,20 L7.72,18 C6.11189372,20.8508965 5.00260645,23.955548 4.44,27.18 L8.44,27.86 C8.89053481,25.1009094 9.8176945,22.4412469 11.18,20 L11.18,20 Z"
										id="Path" fill="#2a3658" fill-rule="nonzero"></path>
								<path class="prodigy-custom-fill"
										d="M32,4 L32,8 C45.2548339,8 56,18.7451661 56,32 C56,45.2548339 45.2548339,56 32,56 L32,60 C47.4639728,60 60,47.4639728 60,32 C60,16.5360272 47.4639728,4 32,4 Z"
										id="Path" fill="#2a3658" fill-rule="nonzero"></path>
								<rect id="_Transparent_Rectangle_" x="0" y="0" width="64" height="64"></rect>
							</g>
						</g>
					</g>
				</svg>
			</span>
			<span class="prodigy-product__values-disabled"><?php esc_html_e( 'Loading...', 'prodigy' ); ?></span>
		</button>
	</div>
</div>
<div class="prodigy-cart-dropdown__alert prodigy-cart-dropdown__alert-added widget-cart-add-item-message-js"
	style="display:none;">
	<?php if ( $confirm_icon_type === 'icon' ) : ?>
		<?php if ( ! empty( $confirm_icon_class ) ) : ?>
			<i class="<?php echo esc_attr( $confirm_icon_class ); ?> font-24"></i>
		<?php endif; ?>
	<?php elseif ( $confirm_icon_type === 'svg' ) : ?>
		<img class="<?php echo esc_attr( $confirm_svg_class ); ?>"
			src="<?php echo esc_url( $elementor_settings['product_subscription_confirmation_message_icon']['value']['url'] ); ?>"
			alt="">
	<?php endif; ?>
	<span class="prodigy-cart-dropdown__alert-txt">
		<?php echo esc_attr( $add_to_cart_message ); ?>
	</span>
</div>
<div class="prodigy-cart-dropdown__alert prodigy-cart-dropdown__alert-error widget-cart-message-error-js"
	style="display:none;">
	<i class="icon icon-error"></i>
	<span class="prodigy-cart-dropdown__alert-txt"></span>
</div>
<div style="display: none"
	class="prodigy-deficiency-message-js prodigy-cart-dropdown__alert prodigy-cart-dropdown__alert--info">
	<i class="icon icon-error"></i>
	<span class="prodigy-cart-dropdown__alert-txt"><?php esc_html_e( 'The selected quantity is not available.', 'prodigy' ); ?>
		<?php esc_html_e( 'There are currently ', 'prodigy' ); ?><span
				class="prodigy-inventory-count-js"></span><?php esc_html_e( ' in stock.', 'prodigy' ); ?>
	</span>
</div>
<div class="prodigy-custom-template">
	<div class="prodigy-product__prop-wrap">
		<?php if ( Prodigy_Layouts_Manager::is_elementor_live_preview() && $is_elementor_show_price === 'yes' ) : ?>
			<?php if ( \Prodigy\Includes\Prodigy_Options::get_redemption_store_status() ) : ?>
				<div class="prodigy-product__prop-text">
					<?php esc_html_e( 'Price', 'prodigy' ); ?>: &nbsp;
					<span
							class="prodigy-product__prop-txt-price prodigy-product__prop-txt-price-default product-default-info-js product-default-info-price-js"
							data-string="<?php echo esc_attr( $additional_data_string ); ?>"><?php echo esc_html( $additional_data_string ); ?></span>
				</div>
				<div class="prodigy-product__price-wrapper">
					<span class="prodigy-product__price sale-price-container sale-price-container-js" style="">
						<?php echo esc_attr( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( ! empty( $main_price['sale-price'] ) ? $main_price['sale-price'] : $main_price['price'] ) ); ?>
					</span>
				</div>
			<?php endif; ?>
		<?php elseif ( ! Prodigy_Layouts_Manager::is_elementor_template() && ! Prodigy_Layouts_Manager::is_elementor_live_preview() ) : ?>
			<?php if ( \Prodigy\Includes\Prodigy_Options::get_redemption_store_status() ) : ?>
				<div class="prodigy-product__prop-text">
					<?php esc_html_e( 'Price', 'prodigy' ); ?>: &nbsp;<span
							class="prodigy-product__prop-txt-price prodigy-product__prop-txt-price-default product-default-info-js product-default-info-price-js"
							data-string="<?php echo esc_attr( $additional_data_string ); ?>"><?php echo esc_html( $additional_data_string ); ?></span>
				</div>
				<div
						class="<?php echo esc_attr( apply_filters( 'prodigy_product_price_class', 'prodigy-product__price-wrapper' ) ); ?>">
					<?php if ( empty( $subscriptions ) ) : ?>
						<span class="prodigy-product__price prodigy-product__price--line-through regular-price-container"
								style="display: none">
							<span class="prodigy-product__price-currency price-currency-js"></span><span
									class="regular-price"></span>
						</span>
						<span class="prodigy-product__price sale-price-container sale-price-container-js"
								style="display: none">
							<span class="prodigy-product__price-currency price-currency-js"></span><span
									class="sale-price"></span>
						</span>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<?php
		elseif (
			( Prodigy_Layouts_Manager::is_elementor_template() || Prodigy_Layouts_Manager::is_elementor_live_preview() ) &&
			$is_elementor_show_price === 'yes'
		) :
			?>
			<?php if ( \Prodigy\Includes\Prodigy_Options::get_redemption_store_status() ) : ?>
			<div class="prodigy-product__prop-text">
				<?php esc_html_e( 'Price', 'prodigy' ); ?>: &nbsp;<span
						class="prodigy-product__prop-txt-price prodigy-product__prop-txt-price-default product-default-info-js product-default-info-price-js"
						data-string="<?php echo esc_attr( $additional_data_string ); ?>"><?php echo esc_html( $additional_data_string ); ?></span>
			</div>
			<div
					class="<?php echo esc_attr( apply_filters( 'prodigy_product_price_class', 'prodigy-product__price-wrapper' ) ); ?>">
				<?php if ( empty( $subscriptions ) ) : ?>
					<span class="prodigy-product__price prodigy-product__price--line-through regular-price-container"
							style="display: none">
							<span class="prodigy-product__price-currency price-currency-js"></span><span
								class="regular-price"></span>
						</span>
					<span class="prodigy-product__price sale-price-container sale-price-container-js"
							style="display: none">
							<span class="prodigy-product__price-currency price-currency-js"></span><span
								class="sale-price"></span>
						</span>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<?php endif; ?>
	</div>

	<?php if ( Prodigy_Layouts_Manager::is_elementor_live_preview() && $is_elementor_show_availability === 'yes' ) : ?>
		<div class="prodigy-product__prop-wrap">
			<div class="prodigy-product__prop-text">
				<?php esc_html_e( 'Availability', 'prodigy' ); ?>: &nbsp;<span
						class="prodigy-product__prop-txt-aval product-default-info-js"><?php echo esc_html( Prodigy_Main_Data_Mapper::mapping_sort_params( $stock_status ) ); ?></span>
			</div>
			<div class="prodigy-product__stock prodigy-product-stock-js" style="display: none"></div>
		</div>

	<?php elseif ( ! Prodigy_Layouts_Manager::is_elementor_template() && ! Prodigy_Layouts_Manager::is_elementor_live_preview() ) : ?>
		<div class="prodigy-product__prop-wrap">
			<div class="prodigy-product__prop-text">
				<?php esc_html_e( 'Availability', 'prodigy' ); ?>: &nbsp;<span
						class="prodigy-product__prop-txt-aval product-default-info-js"><?php echo esc_html( $additional_data_string ); ?></span>
			</div>
			<div class="prodigy-product__stock prodigy-product-stock-js" style="display: none"></div>
		</div>
		<?php
	elseif (
		( Prodigy_Layouts_Manager::is_elementor_template() || Prodigy_Layouts_Manager::is_elementor_live_preview() ) &&
		$is_elementor_show_availability === 'yes'
	) :
		?>
		<div class="prodigy-product__prop-wrap">
			<div class="prodigy-product__prop-text">
				<?php esc_html_e( 'Availability', 'prodigy' ); ?>: &nbsp;
				<span class="prodigy-product__prop-txt-aval prodigy-product__prop-default-info product-default-info-js">
					<?php echo esc_html( $additional_data_string ); ?>
				</span>
			</div>
			<div class="prodigy-product__stock prodigy-product-stock-js" style="display: none"></div>
		</div>
	<?php endif; ?>
</div>
