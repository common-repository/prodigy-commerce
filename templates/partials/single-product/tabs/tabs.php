<?php

use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Frontend\Prodigy_Product_Template_Item;
use Prodigy\Includes\Support\Addons\Elementor\Widgets\Product\ElementorTabs;

defined( 'ABSPATH' ) || exit;

$product_template = new Prodigy_Product_Template_Builder( new Prodigy_Product_Template_Item() );
$product          = empty( $GLOBALS['prodigy_product'] ) && isset( $settings['idWidget'] ) ?
	$product_template->get_product( (int) $settings['default_product_id'] ) :
	$GLOBALS['prodigy_product'];


$is_show_tab = array(
	'description'            => false,
	'additional_information' => false,
	'reviews'                => false,
	'tiered_prices'          => false,
);

if ( isset( $settings ) ) {
	foreach ( $settings as $key => $option ) {
		switch ( $key ) {
			case ElementorTabs::ADDITIONAL_TAB:
				$is_show_tab['additional_information'] = 'yes';
				break;
			case ElementorTabs::CONTENT_DESCRIPTION_TAB:
				$is_show_tab['description'] = 'yes';
				break;
			case ElementorTabs::REVIEW_TAB:
				$is_show_tab['reviews'] = 'yes';
				break;
			case ElementorTabs::TIERED_PRICES_TAB:
				$is_show_tab['tiered_prices'] = 'yes';
				break;
		}
	}
} else {
	unset( $is_show_tab );
}


$customizer_product_options = get_option( 'prodigy_product_settings' );

add_filter( 'prodigy_product_tabs', 'prodigy_default_product_tabs' );
add_filter( 'max_srcset_image_width', 'max_srcset_image_width_func', 10 );

/**
 * Filter tabs and allow third parties to add their own.
 */

$params = array(
	'product'  => $product,
	'settings' => $settings ?? array(),
);

$tabs = get_active_product_tab( apply_filters( 'prodigy_product_tabs', $params ), $settings ?? array() );

if ( ! empty( $tabs ) ) : ?>
	<div class="prodigy-custom-template">
		<div class="prodigy-tabs prodigy-tabs-js row" id="prodigy-tabs">
			<div class="d-none d-md-flex flex-md-column col-lg-12 desktop-resolution-js">
				<?php if ( count( $tabs ) > 1 ) : ?>
					<ul class="prodigy-tabs__tabs-list nav nav-tabs flex-wrap tabs pg-tabs" id="product-tab"
						role="tablist">
						<?php foreach ( $tabs as $key => $tab ) : ?>
							<?php
							$is_enable_review = get_option( 'pg_product_review' );
							if ( $key === 'reviews' && ! $is_enable_review ) {
								break;
							}

							if ( isset( $settings['idWidget'] ) ) {
								$callFuncActive = isset( $tabs[ $key ]['active'] ) || isset( $tabs[ $key ][ $tab['callback'] ?? '' ] );
							} else {
								$callFuncActive = true;
							}
							?>
							<?php if ( $callFuncActive ) : ?>
								<li class="prodigy-tabs__tabs-item nav-item <?php echo esc_attr( $key ); ?>_tab <?php echo isset( $tabs[ $key ]['active'] ) ? 'active' : ''; ?>"
									id="tab-li-<?php echo esc_attr( $key ); ?>">
									<a class="prodigy-tabs__tabs-link pl-0 pr-0 nav-link <?php echo esc_attr( $key ); ?>_tab <?php echo isset( $tabs[ $key ]['active'] ) ? 'active' : ''; ?>"
										id="description-tab tab-title-<?php echo esc_attr( $key ); ?>" data-toggle="tab"
										data-href="#tab-<?php echo esc_attr( $key ); ?>" role="tab" href="#"
										aria-controls="description tab-<?php echo esc_attr( $key ); ?>"
										aria-selected="true"
										<?php if ( isset( $is_show_tab ) ) : ?>
											style="display:<?php echo $is_show_tab[ $key ] ? 'block' : 'none'; ?>" <?php endif; ?>>
										<?php
										if ( isset( $tab['title'] ) ) {
											echo apply_filters( 'prodigy_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key );
										}
										?>
									</a>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				<?php foreach ( $tabs as $key => $tab ) : ?>
					<div class="panel entry-content pg-tab" id="tab-<?php echo esc_attr( $key ); ?>" role="tablist"
						aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>"
						style="display:<?php echo isset( $tabs[ $key ]['active'] ) ? 'block' : 'none'; ?>">
						<div class="prodigy-tabs__desc" id="prodigy-tabs__desc">
							<?php

							if ( isset( $settings['idWidget'] ) ) {
								$callFuncCall = ( isset( $tab['callback'] ) && isset( $tabs[ $key ][ $tab['callback'] ] ) );
							} else {
								$callFuncCall = true;
							}

							if (
								isset( $tab['callback'] )
								&& $callFuncCall
							) {
								call_user_func( $tab['callback'], $tab['settings'] );
							}
							?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="col-12 d-md-none pl-0 pr-0 mobile-resolution-js">
				<div class="prodigy-product__accordion">
					<!-- description -->
					<?php if ( isset( $settings['general_tabs_controls_content_description'] ) ) : ?>
						<div class="prodigy-product__accordion-card mb-0">
							<div class="position-relative d-flex justify-content-between align-items-center"
								data-toggle="collapse"
								data-target="#collapse_description">
								<h5 class="prodigy-product__accordion-subtitle"><?php esc_html_e( 'Description', 'prodigy' ); ?></h5>
								<button class="prodigy-product__accordion-card-btn prodigy-icon-btn">
									<i class="icon icon-arrow-down"></i>
								</button>
							</div>
							<div class="collapse show" id="collapse_description">
								<div class="prodigy-product__accordion-card-body">
									<div class="prodigy-product__card-desc" id="prodigy-product__card-desc">
										<?php echo $product->get_remote_description(); ?>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<!-- end description -->
					<!-- additional -->
					<?php if ( isset( $settings['general_tabs_controls_content_additional_info'] ) ) : ?>
						<div class="prodigy-product__accordion-card prodigy-product__accordion-card-info mb-0">
							<div class="position-relative d-flex justify-content-between align-items-center"
								data-toggle="collapse"
								data-target="#collapse_additional">
								<h5 class="prodigy-product__accordion-subtitle"><?php esc_html_e( 'Additional Information', 'prodigy' ); ?></h5>
								<button class="prodigy-product__accordion-card-btn prodigy-icon-btn">
									<i class="icon icon-arrow-down"></i>
								</button>
							</div>
							<div class="collapse" id="collapse_additional">
								<div class="prodigy-product__accordion-card-body">

									<div class="prodigy-tabs__desc" id="prodigy-tabs__desc">
										<table class="prodigy-product__additional">
											<?php
											if ( isset( $settings ) ) {
												$settings['settings']['product'] = $GLOBALS['prodigy_product'];
												do_action( 'prodigy_product_additional_information', $settings );
											} else {
												do_action( 'prodigy_product_additional_information' );
											}
											?>
										</table>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>

					<!-- end additional -->
					<!-- review -->
					<?php if ( isset( $settings['general_tabs_controls_content_reviews'] ) ) : ?>
						<div class="prodigy-product__accordion-card prodigy-product__accordion-card-review mb-0">
							<div class="position-relative d-flex justify-content-between align-items-center"
								data-toggle="collapse"
								data-target="#collapse_reviews">
								<h5 class="prodigy-product__accordion-subtitle"><?php esc_html_e( 'Reviews', 'prodigy' ); ?></h5>
								<button class="prodigy-product__accordion-card-btn prodigy-icon-btn">
									<i class="icon icon-arrow-down"></i>
								</button>
							</div>
							<div class="collapse" id="collapse_reviews">
								<div class="prodigy-product__accordion-card-body">
									<!-- content here -->
									<div class="prodigy-tabs__desc" id="prodigy-tabs__desc">
										<?php do_action( 'prodigy_product_review_tab', $params ); ?>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>

					<!-- tiered price -->
					<?php if ( isset( $settings['general_tabs_controls_content_tiered_prices'] ) ) : ?>
						<div class="prodigy-product__accordion-card prodigy-product__accordion-card-price mb-0">
							<div class="position-relative d-flex justify-content-between align-items-center"
								data-toggle="collapse"
								data-target="#collapse_tired">
								<h5 class="prodigy-product__accordion-subtitle"><?php esc_html_e( 'QTY and Price Breakes', 'prodigy' ); ?></h5>
								<button class="prodigy-product__accordion-card-btn prodigy-icon-btn">
									<i class="icon icon-arrow-down"></i>
								</button>
							</div>
							<div class="collapse" id="collapse_tired">
								<div class="prodigy-product__accordion-card-body">
									<!-- content here -->
									<div class="prodigy-tabs__desc" id="prodigy-tabs__desc">
										<?php do_action( 'prodigy_product_tiered_tab', $params ); ?>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
