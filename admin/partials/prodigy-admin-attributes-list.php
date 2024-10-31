<?php defined( 'ABSPATH' ) || exit; ?>

<div class="main-attributes-container-js prodigy-admin-custom-template">
	<div class="prodigy-products-list">
		<div class="prodigy-products-list-header">
			<h1 class="prodigy-products-list-header__title">
				<?php esc_html_e( 'Attributes', 'prodigy' ); ?>
				<span class="in-grey-blue-500 opacity-05"><?php echo ! empty( $count ) ? esc_attr( $count ) : 0; ?></span></h1>
			<div class="prodigy-products-list__sort d-flex flex-column flex-md-row justify-content-md-between align-items-md-end align-items-start">
				<div class="d-flex flex-wrap align-self-md-end align-self-start">
					<a
							class="prodigy-products-list-item__link d-flex align-items-center"
							href="<?php echo esc_url( PRODIGY_PROTOCOL_DOMAIN . get_option( 'pg_url_domain_hosted_system' ) . '.' . PRODIGY_CHECKOUT_DOMAIN ); ?>/products/attributes"
							target="_blank"
					>
						<span class="icon icon-external font-18 mr-4"></span>
						<?php esc_html_e( 'View the Attributes on Prodigy', 'prodigy' ); ?>
					</a>
				</div>
				<div class="prodigy-products-list-header__search mt-12">
					<input type="search" class="admin-attributes-search-js" value="<?php echo esc_attr( $search ?? '' ); ?>"
						placeholder="<?php esc_attr_e( 'Search by Name', 'prodigy' ); ?>">
					<input type="submit" class="button admin-submit-attributes-search-js" value="<?php esc_attr_e( 'Search', 'prodigy' ); ?>">
				</div>
			</div>
		</div>
		<table class="posts striped table-view-list widefat wp-list-table">
			<thead>
			<tr>
				<th class="prodigy-manage-column prodigy-hidden-cell">
						<span>
							<?php esc_html_e( 'ID', 'prodigy' ); ?>
						</span>
				</th>
				<th class="prodigy-manage-column prodigy-syncstatus-cell prodigy-hidden-cell">
						<span>
							<?php esc_html_e( 'Sync Status', 'prodigy' ); ?>
						</span>
				</th>
				<th class="prodigy-manage-column sortable <?php echo ! empty( $sort ) ? esc_attr( $sort ) : ''; ?> prodigy-primary-cell pl-20"
					data-sort="name">
					<span class="prodigy-primary-cell__txt-mobile">
						<?php esc_html_e( 'Name', 'prodigy' ); ?>
					</span>
					<a class="prodigy-primary-cell__txt pl-0">
						<span><?php esc_html_e( 'Name', 'prodigy' ); ?></span>
						<span class="sorting-indicator"></span>
					</a>
				</th>
				<th class="prodigy-manage-column prodigy-hidden-cell">
					<span>
						<?php esc_html_e( 'Attribute Values', 'prodigy' ); ?>
					</span>
				</th>
				<th class="prodigy-manage-column sortable <?php echo ! empty( $count ) ? esc_attr( $count ) : 0; ?> prodigy-hidden-cell">
					<span><?php esc_html_e( 'Products', 'prodigy' ); ?></span>
				</th>
			</tr>
			</thead>
			<tbody>

			<?php if ( isset( $attributes['data'] ) ) : ?>
				<?php foreach ( $attributes['data'] as $attribute ) : ?>
					<tr class="prodigy-products-list-item">
						<td class="prodigy-hidden-cell"><?php echo esc_attr( $attribute['id'] ); ?></td>
						<td class="prodigy-hidden-cell">
							<?php if ( $attribute['is_synced'] ) : ?>
								<div class="d-flex flex-nowrap justify-content-start align-items-center">
									<span class="prodigy-syncstatus__synced d-inline-block pr-16"></span>
									<span class="prodigy-syncstatus__synced-txt">
										<?php esc_html_e( 'Synced', 'prodigy' ); ?>
									</span>
								</div>
							<?php else : ?>
								<div class="d-flex flex-nowrap justify-content-start align-items-center">
									<span class="prodigy-syncstatus__not-synced d-inline-block pr-16"></span>
									<span class="prodigy-syncstatus__not-synced-txt">
										<?php esc_html_e( 'Not Synced', 'prodigy' ); ?>
									</span>
								</div>
							<?php endif; ?>
						</td>
						<td class="prodigy-primary-cell pl-20">
							<h3 class="prodigy-products-list-item__title  min-height-auto mb-4"><?php echo esc_attr( $attribute['attributes']['name'] ); ?></h3>
							<button class="prodigy-primary-cell__btn" aria-label="<?php esc_attr_e( 'Details', 'prodigy' ); ?>">
								<span class="icon icon-arrow-down"></span>
							</button>
							<div class="prodigy-products-list-item__links d-flex">
								<a
									class="d-block prodigy-products-list-item__link"
									target="_blank"
									href="<?php echo esc_url( PRODIGY_PROTOCOL_DOMAIN . get_option( 'pg_url_domain_hosted_system' ) . '.' . PRODIGY_CHECKOUT_DOMAIN ); ?>/products/attributes/<?php echo esc_attr( $attribute['id'] ); ?>"
								>
									<?php esc_html_e( 'Edit on Prodigy', 'prodigy' ); ?>
								</a>
							</div>
							<div class="prodigy-primary-cell__mobile-content">
								<table>
									<tr>
										<td class="pl-0 pt-4 pb-4 pr-16">
											<?php esc_html_e( 'Values', 'prodigy' ); ?>
										</td>
										<td class="pt-4 pb-4 pl-4"><?php echo esc_attr( implode( ', ', $attribute['attributes']['option-values'] ) ); ?></td>
									</tr>
									<tr>
										<?php if ( $attribute['is_synced'] ) : ?>
											<div class="d-flex flex-nowrap justify-content-start align-items-center">
												<span class="prodigy-syncstatus__synced d-inline-block pr-16"></span>
												<span class="prodigy-syncstatus__synced-txt">
													<?php esc_html_e( 'Synced', 'prodigy' ); ?>
												</span>
											</div>
										<?php else : ?>
											<div class="d-flex flex-nowrap justify-content-start align-items-center">
												<span class="prodigy-syncstatus__not-synced d-inline-block pr-16"></span>
												<span class="prodigy-syncstatus__not-synced-txt">
													<?php esc_html_e( 'Not Synced', 'prodigy' ); ?>
												</span>
											</div>
										<?php endif; ?>
									</tr>
									<tr>
										<td class="pl-0 pt-4 pb-4 pr-16">
											<?php esc_html_e( 'Products', 'prodigy' ); ?>
										</td>
										<td class="pt-4 pb-4 pl-4"><?php echo esc_attr( $attribute['attributes']['products-quantity'] ); ?></td>
									</tr>
								</table>
							</div>
						</td>
						<td class="prodigy-hidden-cell"><?php echo esc_attr( implode( ', ', $attribute['attributes']['option-values'] ) ); ?></td>
						<td class="prodigy-hidden-cell"><?php echo esc_attr( $attribute['attributes']['products-quantity'] ); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>

			</tbody>
		</table>
		<div class="attributes-pagination-js d-flex justify-content-center mt-12"></div>
		<div class=""></div>
	</div>
</div>
<div class="no-result-attributes-list-js"></div>

<?php if ( isset( $empty_view ) ) : ?>
	<script>
		window.prodigyAdminAttributes.init();
	</script>
<?php endif; ?>
