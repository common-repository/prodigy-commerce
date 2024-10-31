<?php

use Prodigy\Includes\Frontend\Prodigy_Product_Template_Builder;
use Prodigy\Includes\Helpers\Prodigy_Formatting;
?>
<?php defined( 'ABSPATH' ) || exit; ?>
<div class="main-products-container-js prodigy-admin-custom-template">
	<div class="prodigy-products-list">
		<div class="prodigy-products-list-header">
			<h1 class="prodigy-products-list-header__title">
				<?php esc_html_e( 'Products', 'prodigy' ); ?>
				<span class="in-grey-blue-500 opacity-05"><?php echo ! empty( $count ) ? esc_attr( $count ) : 0; ?></span>
			</h1>
			<div class="prodigy-products-list__sort d-flex flex-column flex-md-row justify-content-md-between align-items-md-end align-items-start">
				<div class="d-flex flex-wrap align-self-md-end align-self-start">
					<!-- add disabled to button to change the loading view -->
					<button
							class="prodigy-products-list-item__link prodigy-products-list-item__link--sync d-flex align-items-center sync-process-js"
					>
						<span class="icon icon-sync font-18 mr-4"></span>
						<span class="icon icon-rotate font-18 mr-4"></span>
						<?php esc_html_e( 'Sync with Prodigy', 'prodigy' ); ?>
						<span
							id="products-list-item-link-popup"
							tabIndex="0"
							role="button"
							aria-label="<?php esc_attr_e( 'More information', 'prodigy' ); ?>"
							class="icon icon-info font-18 ml-4 prodigy-tooltip"
						>
						<span class="prodigy-tooltip__message">
							<?php esc_html_e( 'Synchronize all the data related to the Products, Categories and Attributes', 'prodigy' ); ?>
						</span>
					</span>
					</button>
					<a
							class="prodigy-products-list-item__link d-flex align-items-center"
							href="<?php echo esc_url( PRODIGY_PROTOCOL_DOMAIN . get_option( 'pg_url_domain_hosted_system' ) . '.' . PRODIGY_CHECKOUT_DOMAIN ); ?>/products"
							target="_blank"
					>
						<span class="icon icon-external font-18 mr-4"></span>
						<?php esc_html_e( 'View Products on Prodigy', 'prodigy' ); ?>
					</a>
				</div>
				<div class="prodigy-products-list-header__search mt-12">
					<input type="search" class="admin-product-search-js"
						value="<?php echo esc_attr( $search ?? '' ); ?>"
						placeholder="<?php esc_attr_e( 'Search by Title', 'prodigy' ); ?>">
					<input type="submit" class="button admin-submit-product-search-js" value="<?php esc_attr_e( 'Search', 'prodigy' ); ?>">
				</div>
			</div>
		</div>
		<table class="posts striped table-view-list widefat wp-list-table">
			<thead>
			<tr>
				<th class="prodigy-products-list-item__image-head">
						<span class="visually-hidden">
							<?php esc_html_e( 'Image', 'prodigy' ); ?>
						</span>
				</th>
				<th class="prodigy-manage-column sortable <?php echo ! empty( $sort ) ? esc_attr( $sort ) : ''; ?> prodigy-primary-cell"
					data-sort="name">
					<span class="prodigy-primary-cell__txt-mobile ml-12">
						<?php esc_html_e( 'Items', 'prodigy' ); ?>
					</span>
					<a class="prodigy-primary-cell__txt" href="#">
						<span>
							<?php esc_html_e( 'Title', 'prodigy' ); ?>
						</span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th class="prodigy-manage-column prodigy-syncstatus-cell prodigy-hidden-cell">
					<span>
						<?php esc_html_e( 'Sync Status', 'prodigy' ); ?>
					</span>
				</th>
				<th class="prodigy-manage-column prodigy-hidden-cell">
					<span>
						<?php esc_html_e( 'SKU', 'prodigy' ); ?>
					</span>
				</th>
				<th class="prodigy-manage-column sortable <?php echo ! empty( $sort ) ? esc_attr( $sort ) : ''; ?> prodigy-hidden-cell"
					data-sort="id">
					<a href="#">
						<span>
							<?php esc_html_e( 'ID', 'prodigy' ); ?>
						</span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th class="prodigy-manage-column sortable <?php echo ! empty( $sort ) ? esc_attr( $sort ) : ''; ?> prodigy-hidden-cell"
					data-sort="price">
					<a href="#">
						<span>
							<?php esc_html_e( 'Price', 'prodigy' ); ?>
						</span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th class="prodigy-hidden-cell">
					<?php esc_html_e( 'Categories', 'prodigy' ); ?>
				</th>
				<th class="prodigy-manage-column sortable <?php echo ! empty( $sort ) ? esc_attr( $sort ) : ''; ?> prodigy-hidden-cell"
					data-sort="created_at">
					<a href="#">
						<span>
							<?php esc_html_e( 'Created Date', 'prodigy' ); ?>
						</span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
			</tr>
			</thead>
			<tbody>

			<?php if ( isset( $products ) && is_array( $products ) ) : ?>
				<?php foreach ( $products as $product ) : ?>
					<?php
					$attributes = $product->attributes;

					$is_range = false;
					if ( (float) $attributes->{'price-range'}->min_price !== (float) $attributes->{'price-range'}->max_price ) {
						$is_range = true;
					}
					?>
					<?php $local_product = Prodigy_Product_Template_Builder::get_product_meta_by_remote_id( 'prodigy_remote_product_id', (int) $product->id ); ?>
					<tr class="prodigy-products-list-item">
						<td>
							<?php $product_id = $local_product->post_id ?? ''; ?>
							<a
									href="<?php echo esc_url( get_permalink( $product_id ) ); ?>"
									class="prodigy-products-list-item__image"
							<?php echo ! empty( $attributes->{'image-url'} ) ? 'style="background-size: cover; background-image: url(' . esc_url( $attributes->{'image-url'} ) . ')' : ''; ?>
							"
							></a>

							<button type="button" class="toggle-row">
								<span class="screen-reader-text">
									<?php esc_html_e( 'Show more details', 'prodigy' ); ?>
								</span>
							</button>
						</td>
						<td class="prodigy-primary-cell">
							<h3 class="prodigy-products-list-item__title "><?php echo esc_attr( $attributes->name ); ?></h3>
							<button class="prodigy-primary-cell__btn" aria-label="<?php esc_attr_e( 'Details', 'prodigy' ); ?>">
								<span class="icon icon-arrow-down"></span>
							</button>
							<div class="prodigy-products-list-item__links">
								<?php if ( isset( $local_product->post_id ) ) : ?>
									<a
										class="d-block prodigy-products-list-item__link"
										href="<?php echo esc_url( get_permalink( $local_product->post_id ) ); ?>"
										target="_blank"
									>
										<?php esc_html_e( 'View Details', 'prodigy' ); ?>
									</a>
								<?php endif; ?>

								<a
										class="d-block prodigy-products-list-item__link"
										target="_blank"
										href="<?php echo esc_url( PRODIGY_PROTOCOL_DOMAIN . get_option( 'pg_url_domain_hosted_system' ) . '.' . PRODIGY_CHECKOUT_DOMAIN ); ?>/products/<?php echo esc_attr( $product->id ); ?>"
								>
									<?php esc_html_e( 'Edit on Prodigy', 'prodigy' ); ?>
								</a>
							</div>
							<div class="prodigy-primary-cell__mobile-content">
								<div class="prodigy-products-list-item__links flex-wrap d-flex">
									<a class="d-block prodigy-products-list-item__link prodigy-products-list-item__link--show-separator" href="">
										<?php esc_html_e( 'View Details', 'prodigy' ); ?>
									</a>
									<a
										class="d-block prodigy-products-list-item__link prodigy-products-list-item__link--show-separator"
										href="<?php echo esc_url( PRODIGY_PROTOCOL_DOMAIN . get_option( 'pg_url_domain_hosted_system' ) . '.' . PRODIGY_CHECKOUT_DOMAIN ); ?>/products/<?php echo esc_attr( $product->id ); ?>"
									>
										<?php esc_html_e( 'Edit on Prodigy', 'prodigy' ); ?>
									</a>
								</div>
								<table>
									<tr>
										<td class="pl-0 pt-4 pb-4 pr-16">
											<?php if ( isset( $local_product->post_id ) ) : ?>
												<span class="prodigy-syncstatus__synced d-inline-block"></span>
											<?php else : ?>
												<span class="prodigy-syncstatus__not-synced d-inline-block"></span>
											<?php endif; ?>
										</td>
										<td class="pt-4 pb-4 pl-4">
											<?php if ( isset( $local_product->post_id ) ) : ?>
												<span class="prodigy-syncstatus__synced-txt d-inline-block">
													<?php esc_html_e( 'Synced', 'prodigy' ); ?>
												</span>
											<?php else : ?>
												<span class="prodigy-syncstatus__not-synced-txt d-inline-block">
													<?php esc_html_e( 'Not Synced', 'prodigy' ); ?>
												</span>
											<?php endif; ?>
										</td>
									</tr>
									<tr>
										<td class="pl-0 pt-4 pb-4 pr-16">
											<?php esc_html_e( 'ID', 'prodigy' ); ?>
										</td>
										<td class="pt-4 pb-4 pl-4"><?php echo esc_attr( $product->id ); ?></td>
									</tr>
									<tr>
										<?php if ( $is_range ) : ?>
											<td class="pl-0 pt-4 pb-4 pr-16">
												<?php esc_html_e( 'Price', 'prodigy' ); ?>
											</td>
											<td class="pt-4 pb-4 pl-4">
												$<?php echo esc_attr( $attributes->{'price-range'}->min_price ); ?> -
												$<?php echo esc_url( $attributes->{'price-range'}->max_price ); ?>
											</td>
										<?php else : ?>
											<?php if ( isset( $attributes->{'sale-price'} ) ) : ?>
												<td class="pt-4 pb-4 pl-4">
													$<?php echo number_format( (float) esc_attr( $attributes->{'sale-price'} ), 2, '.', '' ); ?></td>
												<td class="pt-4 pb-4 pl-4">
													$<?php echo number_format( (float) esc_attr( $attributes->{'price'} ), 2, '.', '' ); ?></td>
											<?php else : ?>
												<td class="pt-4 pb-4 pl-4">
													$<?php echo number_format( (float) esc_attr( $attributes->{'price'} ), 2, '.', '' ); ?></td>
											<?php endif; ?>
										<?php endif; ?>
									</tr>

									<tr>
										<td class="pl-0 pt-4 pb-4 pr-16">
											<?php esc_html_e( 'Categories', 'prodigy' ); ?>
										</td>
										<td class="pt-4 pb-4 pl-4"><?php echo esc_attr( $attributes->{'categories-list'} ); ?></td>
									</tr>
									<tr>
										<td class="pl-0 pt-4 pb-4 pr-16">
											<?php esc_html_e( 'Created Date', 'prodigy' ); ?>
										</td>
										<td class="pt-4 pb-4 pl-4"><?php echo esc_html( gmdate( 'Y-m-d H:i', strtotime( esc_attr( $attributes->{'created-at'} ) ) ) ); ?></td>
									</tr>
								</table>
							</div>
						</td>
						<td class="prodigy-hidden-cell">
							<?php if ( isset( $local_product->post_id ) ) : ?>
								<p class="prodigy-syncstatus__synced-wrap d-flex justify-content-start align-items-center">
									<span class="prodigy-syncstatus__synced d-inline-block"></span>
									<span class="pl-16">
										<?php esc_html_e( 'Synced', 'prodigy' ); ?>
									</span>
								</p>
							<?php else : ?>
								<p class="prodigy-syncstatus__not-synced-wrap d-flex justify-content-start flex-nowrap align-items-center">
									<span class="prodigy-syncstatus__not-synced d-inline-block pr-4"></span>
									<span class="pl-4">
										<?php esc_html_e( 'Not Synced', 'prodigy' ); ?>
									</span>
								</p>
							<?php endif; ?>
						</td>
						<td class="prodigy-hidden-cell"><?php echo esc_attr( $attributes->sku ); ?></td>
						<td class="prodigy-hidden-cell"><?php echo esc_attr( $product->id ); ?></td>
						<td class="prodigy-hidden-cell">
                            <?php if ( $attributes->{'tiered-price'} && $attributes->price == 0.00 ): ?>

                                <?php if ( isset( $attributes->{'price-range'}->min_price, $attributes->{'price-range'}->max_price ) ): ?>
									<?php if ( $attributes->{'price-range'}->min_price === $attributes->{'price-range'}->max_price ): ?>
                                        <span><?php esc_attr_e( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $attributes->{'price-range'}->min_price ) ); ?></span>
									<?php else: ?>
                                        <?php esc_html_e( 'From', 'prodigy' ); ?>
                                        <span><?php esc_attr_e( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $attributes->{'price-range'}->min_price ) ); ?></span>
                                        <?php esc_html_e( 'to', 'prodigy' ); ?>
                                        <span><?php esc_attr_e( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $attributes->{'price-range'}->max_price ) ); ?></span>
									<?php endif; ?>
								<?php endif; ?>

							<?php else: ?>
                                <?php if ( $is_range ) : ?>
                                        <p class="prodigy-products-list-item__price">
                                            $<?php echo number_format( (float) esc_attr( $attributes->{'price-range'}->min_price ), 2, '.', '' ); ?>
                                            -
                                            $<?php echo number_format( (float) esc_attr( $attributes->{'price-range'}->max_price ), 2, '.', '' ); ?></p>
                                <?php else : ?>
                                    <?php if ( isset( $attributes->{'sale-price'} ) ) : ?>
                                            $<?php echo number_format( (float) esc_attr( $attributes->{'sale-price'} ), 2, '.', '' ); ?></p>
                                        <p class="prodigy-products-list-item__price prodigy-products-list-item__price--old">
                                            $<?php echo number_format( (float) esc_attr( $attributes->price ), 2, '.', '' ); ?></p>
                                    <?php else : ?>
                                        <p class="prodigy-products-list-item__price">
                                            $<?php echo number_format( (float) esc_attr( $attributes->price ), 2, '.', '' ); ?></p>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
						</td>
						<td class="prodigy-hidden-cell">
							<span><?php echo esc_attr( $attributes->{'categories-list'} ); ?></span>
						</td>
						<td class="prodigy-hidden-cell"><?php echo esc_html( gmdate( 'Y-m-d H:i', strtotime( esc_attr( $attributes->{'created-at'} ) ) ) ); ?></td>
					</tr>

				<?php endforeach; ?>
			<?php else : ?>

			<?php endif; ?>
			</tbody>
		</table>
		<div class="products-pagination-js d-flex justify-content-center mt-12"></div>
	</div>
</div>
<div class="not-result-products-list-js"></div>

<?php if ( isset( $empty_view ) ) : ?>
	<script>
		window.prodigyAdminProducts.init();
	</script>
<?php endif; ?>
