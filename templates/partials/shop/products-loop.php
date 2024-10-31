<?php

use Prodigy\Includes\Frontend\Prodigy_Layouts_Manager;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Frontend\Shortcodes\Prodigy_Short_Code_Search;
use Prodigy\Includes\Helpers\Prodigy_Formatting;
use Prodigy\Includes\Helpers\Prodigy_Template;
use Prodigy\Includes\Prodigy;

?>

<div class="<?php echo esc_attr( $args['product_list_classname'] ); ?> prodigy-custom-template flex-grow-1">
	<div class="prodigy-loader-wrapper">
		<div class="prodigy-loader">
			<svg width="64px" height="64px" viewBox="0 0 64 64" version="1.1" xmlns="http://www.w3.org/2000/svg"
				xmlns:xlink="http://www.w3.org/1999/xlink">
				<g id="Selected" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
					<g id="Catalog-Page-With-Loader" transform="translate(-688, -418)">
						<g id="icn_loader"
							transform="translate(720, 450) rotate(-360) translate(-720, -450)translate(688, 418)">
							<path d="M16.48,50.28 L14,53.34 C16.4771768,55.4468051 19.3074278,57.0989133 22.36,58.22 L23.74,54.48 C21.0922325,53.5169929 18.6347128,52.0952873 16.48,50.28 L16.48,50.28 Z"
									id="Path" fill="#FFFFFF" fill-rule="nonzero"></path>
							<path d="M8.38,36 L4.38,36.82 C4.95041759,40.0511083 6.08073052,43.1577768 7.72,46 L11.18,44 C9.7959677,41.5131108 8.8488945,38.8071874 8.38,36 L8.38,36 Z"
									id="Path" fill="#FFFFFF" fill-rule="nonzero"></path>
							<path d="M23.64,9.52 L22.26,5.78 C19.2427153,6.91161657 16.4470946,8.56326659 14,10.66 L16.48,13.72 C18.6046017,11.9147528 21.0275012,10.4934989 23.64,9.52 L23.64,9.52 Z"
									id="Path" fill="#FFFFFF" fill-rule="nonzero"></path>
							<path d="M11.18,20 L7.72,18 C6.11189372,20.8508965 5.00260645,23.955548 4.44,27.18 L8.44,27.86 C8.89053481,25.1009094 9.8176945,22.4412469 11.18,20 L11.18,20 Z"
									id="Path" fill="#FFFFFF" fill-rule="nonzero"></path>
							<path d="M32,4 L32,8 C45.2548339,8 56,18.7451661 56,32 C56,45.2548339 45.2548339,56 32,56 L32,60 C47.4639728,60 60,47.4639728 60,32 C60,16.5360272 47.4639728,4 32,4 Z"
									id="Path" fill="#FFFFFF" fill-rule="nonzero"></path>
							<rect id="_Transparent_Rectangle_" x="0" y="0" width="64" height="64"></rect>
						</g>
					</g>
				</g>
			</svg>
		</div>
	</div>
	<input type="hidden" class="prodigy-category-slug-js"
			value="<?php echo esc_attr( $args['page_object']->slug ?? '' ); ?>">
	<input type="hidden" class="prodigy-category-type-js"
			value="<?php echo esc_attr( Prodigy::get_prodigy_category_type() ); ?>">
	<div class="shop-page-container-js">
		<div class="prodigy-search-filter flex-wrap flex-md-nowrap justify-content-end align-items-center">
			<?php if ( $args['is_show_search'] ) : ?>
				<?php echo ( Prodigy_Layouts_Manager::is_elementor_template() || Prodigy_Layouts_Manager::is_elementor_live_preview() ) ? '' : wp_kses( do_shortcode( '[prodigy_search]' ), Prodigy_Short_Code_Search::get_allowed_html() ); ?>
			<?php endif; ?>
			<div class="prodigy-custom-select-wrapper justify-content-between justify-content-md-end align-items-center">
				<?php ( Prodigy_Layouts_Manager::is_elementor_template() || Prodigy_Layouts_Manager::is_elementor_live_preview() ) ? '' : do_action( 'prodigy_shop_sortable_block' ); ?>
			</div>
		</div>
		<?php if ( ! empty( $args['products'] ) ) : ?>

		<div class="prodigy-product-list__grid mt-20 shop-resolution-js <?php echo Prodigy_Layouts_Manager::is_elementor_live_preview() ? '' : 'd-none'; ?>">
			<?php foreach ( $args['products'] as $product ) : ?>
				<?php $attributes = $product['attributes']; ?>
				<?php $local_product = Prodigy_Product_Template_Builder::get_product_meta_by_remote_id( 'prodigy_remote_product_id', (int) $product['id'] ); ?>
				<div class="prodigy-product-list__item">
					<?php if ( $args['enable_sale_badge'] && $attributes['sale-price'] !== null ) : ?>
						<div class="<?php echo esc_attr( $args['sale_classname'] ); ?>"><?php esc_html_e( 'SALE', 'prodigy' ); ?></div>
					<?php endif; ?>
					<div class="prodigy-product-list__item-container">
						<div <?php echo ( $args['image_ratio'] !== '' ) ? 'style="padding-top: ' . esc_attr( $args['image_ratio'] ) . '%"' : ''; ?>
								class="prodigy-product-list__link-wrp">
							<?php if ( isset( $local_product ) ) : ?>
								<?php $image_ratio_style = isset( $args['customizer_general_options']['prodigy_general_images'] ) ? 'prodigy-product-list__link-wrp--' . $args['customizer_general_options']['prodigy_general_images'] : ''; ?>
								<a class="prodigy-product-list__item-preview <?php echo esc_attr( $image_ratio_style ); ?> icon
									<?php echo empty( get_the_post_thumbnail_url( $local_product->post_id ) ) ? 'icon-image' : ''; ?> "
									href="<?php echo esc_url( get_permalink( $local_product->post_id ) ); ?>">
									<?php echo get_shop_product_logo_image_template( $attributes ); ?>
								</a>
								<?php if ( $args['enable_quick_view'] || is_null( $args['enable_quick_view'] ) ) : ?>
									<button class="prodigy-main-button prodigy-product-list__quick-view quick-view-js"
											data-id="<?php echo esc_attr( $local_product->post_id ); ?>">
										<?php esc_html_e( 'QUICK VIEW', 'prodigy' ); ?>
									</button>
								<?php endif; ?>
							<?php endif; ?>
						</div>

						<?php if ( $args['enable_category'] ) : ?>
							<p class="prodigy-product-list__item-category">
								<?php echo esc_attr( $attributes['categories-list'] ); ?>
							</p>
						<?php endif; ?>
						<h3 class="prodigy-product-list__item-title">
							<?php if ( isset( $local_product ) ) : ?>
								<a href="<?php echo esc_url( get_permalink( $local_product->post_id ) ); ?>">
									<?php echo esc_attr( $product['attributes']['name'] ); ?>
								</a>
							<?php endif; ?>
						</h3>
						<?php if ( $args['enable_rating'] ) : ?>
							<?php do_action( 'prodigy_product_loop_rating_stars', array( 'product' => $attributes ) ); ?>
						<?php endif; ?>

						<?php if ( \Prodigy\Includes\Prodigy_Options::get_redemption_store_status() ) : ?>
							<div class="d-flex flex-wrap">
								<?php if ( $attributes['tiered-price'] ) : ?>
									<?php if ( isset( $attributes['price-range']['min_price'], $attributes['price-range']['max_price'] ) ) : ?>
										<?php if ( $attributes['price-range']['min_price'] === $attributes['price-range']['max_price'] ) : ?>
											<div class="prodigy-product-list__item-price">
												<?php echo esc_attr( get_option( 'pg_currency_type' ) ) . Prodigy_Formatting::prodigy_price_format( $attributes['price-range']['min_price'] ); ?>
											</div>
										<?php else : ?>
											<div class="prodigy-product-list__item-price">
												<?php echo esc_attr( get_option( 'pg_currency_type' ) ) . Prodigy_Formatting::prodigy_price_format( $attributes['price-range']['min_price'] ); ?>
											</div>
											<span class="prodigy-product-list__item-price">&nbsp;-&nbsp;</span>
											<div class="prodigy-product-list__item-price">
												<?php echo esc_attr( get_option( 'pg_currency_type' ) ) . Prodigy_Formatting::prodigy_price_format( $attributes['price-range']['max_price'] ); ?>
											</div>
										<?php endif; ?>
									<?php endif; ?>


									<?php
								elseif (
									isset( $attributes['price-range']['min_price'] ) &&
									$attributes['display-price-range'] &&
									$attributes['price-range']['min_price'] === $attributes['price-range']['max_price']
								) :
									?>

									<?php if ( $attributes['sale-price'] !== null ) : ?>
									<div class="prodigy-product-list__item-price prodigy-product-list__item-price--sale">
										<?php echo esc_attr( get_option( 'pg_currency_type' ) ) . Prodigy_Formatting::prodigy_price_format( $attributes['price'] ); ?>
									</div>
									<div class="prodigy-product-list__item-price">
										<?php echo esc_attr( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $attributes['sale-price'] ) ); ?>
									</div>
								<?php else : ?>
									<div class="prodigy-product-list__item-price">
										<?php echo esc_attr( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $attributes['price'] ) ); ?>
									</div>
								<?php endif; ?>
									<?php
								elseif (
									isset( $attributes['price-range']['min_price'] ) &&
									! $attributes['display-price-range']
								) :
									?>
									<?php if ( $attributes['sale-price'] !== null ) : ?>
									<div class="prodigy-product-list__item-price prodigy-product-list__item-price--sale">
										<?php echo esc_attr( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $attributes['price'] ) ); ?>
									</div>
									<div class="prodigy-product-list__item-price">
										<?php echo esc_attr( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $attributes['sale-price'] ) ); ?>
									</div>
								<?php else : ?>
									<div class="prodigy-product-list__item-price">
										<?php echo esc_attr( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $attributes['price'] ) ); ?>
									</div>
								<?php endif; ?>
								<?php elseif ( ( $attributes['price-range']['min_price'] === $attributes['price-range']['max_price'] ) ) : ?>
									<?php if ( $attributes['sale-price'] !== null ) : ?>
										<div class="prodigy-product-list__item-price prodigy-product-list__item-price--sale">
											<?php echo esc_attr( get_option( 'pg_currency_type' ) ) . Prodigy_Formatting::prodigy_price_format( $attributes['price'] ); ?>
										</div>
										<div class="prodigy-product-list__item-price">
											<?php echo esc_attr( get_option( 'pg_currency_type' ) ) . Prodigy_Formatting::prodigy_price_format( $attributes['sale-price'] ); ?>
										</div>
									<?php else : ?>
										<div class="prodigy-product-list__item-price">
											<?php echo esc_attr( get_option( 'pg_currency_type' ) ) . Prodigy_Formatting::prodigy_price_format( $attributes['price'] ); ?>
										</div>
									<?php endif; ?>
								<?php else : ?>
									<?php if ( $attributes['display-price-range'] ) : ?>
										<div class="prodigy-product-list__item-price">
											<?php echo esc_attr( get_option( 'pg_currency_type' ) ) . Prodigy_Formatting::prodigy_price_format( $attributes['price-range']['min_price'] ); ?>
										</div>
										<span class="prodigy-product-list__item-price">&nbsp;-&nbsp;</span>
										<div class="prodigy-product-list__item-price">
											<?php echo esc_attr( get_option( 'pg_currency_type' ) ) . Prodigy_Formatting::prodigy_price_format( $attributes['price-range']['max_price'] ); ?>
										</div>
									<?php else : ?>
										<div class="prodigy-product-list__item-price">
											<?php echo esc_attr( get_option( 'pg_currency_type' ) ) . Prodigy_Formatting::prodigy_price_format( $attributes['price-range']['min_price'] ); ?>
										</div>
									<?php endif; ?>
								<?php endif; ?>
							</div>
						<?php endif; ?>

					</div>
				</div>
			<?php endforeach; ?>
			<?php
			else :
				Prodigy_Template::prodigy_get_template( 'shop/no-search-results.php' );
			endif;
			?>
		</div>
	</div>
	<div class="prodigy-pagination prodigy-pagination-shop-js">
		<?php echo Prodigy_Template::prodigy_get_template_html( 'shop/pagination.php', array( 'data' => $args['pagination'] ) ); ?>
	</div>
</div>

<div class="quick-view mfp-hide prodigy-custom-template" id="quick-view-js">
	<div id="quick-view-content-js" class="flex-grow-1 container"></div>
</div>

<?php if ( ! Prodigy_Layouts_Manager::is_elementor_live_preview() || ! Prodigy_Layouts_Manager::is_elementor_template() ) : ?>
	<script>
		jQuery('.prodigy-custom-select').styler({
			onFormStyled: function () {
				jQuery('.jq-selectbox__select-text').each(function () {
					const width = jQuery(this)
						.closest('.jq-selectbox')
						.find('select')
						.width();
				});
			}
		});
	</script>

<?php endif; ?>
