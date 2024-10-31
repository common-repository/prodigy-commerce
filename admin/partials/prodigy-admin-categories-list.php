<?php defined( 'ABSPATH' ) || exit; ?>
<?php
/**
 * @param array $current_category
 * @param array $categories
 *
 * @return void
 */
function print_list( array $current_category, array $categories ) {
	$edit_url = esc_url( PRODIGY_PROTOCOL_DOMAIN . esc_attr( get_option( 'pg_url_domain_hosted_system' ) ) . '.' . PRODIGY_CHECKOUT_DOMAIN . '/products/categories/' . esc_attr( $current_category['id'] ) );
	if ( empty( $current_category['depth'] ) ) {
		$page = '<tr class="prodigy-products-list-item"><td class="prodigy-products-list-item__category prodigy-primary-cell">' .
				'<h3 class="prodigy-products-list-item__title  min-height-auto mb-4">' . esc_attr( $current_category['name'] ) . '</h3>' .
				'<button class="prodigy-primary-cell__btn" aria-label="' . __( 'Details', 'prodigy' ) . '"><span class="icon icon-arrow-down"></span></button>' .
				'<div class="prodigy-products-list-item__links d-flex"><a class="d-block prodigy-products-list-item__link" target="_blank" href="' . $edit_url . '">' . __( 'Edit on Prodigy', 'prodigy' ) . '</a></div>' .
				'<div class="prodigy-primary-cell__mobile-content"><table>' .
				'<tr><td class="pl-0 pt-4 pb-4 pr-16">' . __( 'Product', 'prodigy' ) . '</td><td class="pt-4 pb-4 pl-4">' . esc_attr( $current_category['products-count'] ) . '</td></tr><tr>';

		$page .= '<td class="pl-0 pt-4 pb-4 pr-16">';
		if ( $current_category['is_synced'] ) {
			$page .= '<span class="prodigy-syncstatus__synced d-inline-block"></span>';
		} else {
			$page .= '<span class="prodigy-syncstatus__not-synced d-inline-block"></span></td>';
		}

		$page .= '<td class="pt-4 pb-4 pl-4">';
		if ( $current_category['is_synced'] ) {
			$page .= '<td class="pt-4 pb-4 pl-4"><span class="prodigy-syncstatus__synced-txt d-inline-block">' . __( 'Synced', 'prodigy' ) . '</span>';
		} else {
			$page .= '<span class="prodigy-syncstatus__not-synced-txt d-inline-block">' . __( 'Not Synced', 'prodigy' ) . '</span>';
		}
		$page .= '</td>';
		$page .= '</tr><tr><td class="pl-0 pt-4 pb-4 pr-16">Date</td><td class="pt-4 pb-4 pl-4">' . esc_html( gmdate( 'Y-m-d H:i', strtotime( esc_attr( $current_category['created-at'] ) ) ) ) . '</td></tr>' .
				 '</table></div>' .
				 '</td><td class="prodigy-hidden-cell">';

		if ( $current_category['is_synced'] ) {
			$page .= '<p class="prodigy-syncstatus__synced-wrap d-flex justify-content-start align-items-center">' .
					 '<span class="prodigy-syncstatus__synced d-inline-block"></span><span class="pl-16">' . __( 'Synced', 'prodigy' ) . '</span></p>';
		} else {
			$page .= '<p class="prodigy-syncstatus__not-synced-wrap d-flex justify-content-start flex-nowrap align-items-center">' .
					 '<span class="prodigy-syncstatus__not-synced d-inline-block pr-4"></span><span class="pl-4">' . __( 'Not Synced', 'prodigy' ) . '</span></p>';
		}

		$page .= '</td><td class="prodigy-hidden-cell"></div>' . esc_attr( $current_category['id'] ) . '</td><td class="prodigy-hidden-cell">' . esc_attr( $current_category['products-count'] ) . '</td><td class="prodigy-hidden-cell">' . esc_html( gmdate( 'Y-m-d H:i', strtotime( esc_attr( $current_category['created-at'] ) ) ) ) . '</td></tr>';
	} else {
		$page  = '';
		$page .= '<tr class="prodigy-products-list-item">';
		$page .= '<td style="--nestingLevel:' . esc_attr( $current_category['depth'] ) . '" class="prodigy-products-list-item__category prodigy-primary-cell">';
		for ( $i = 0; $i <= $current_category['depth'] - 1; $i++ ) {
			$page .= '<div style = "--order:' . $i . '" class="prodigy-products-list-item__category-divider"></div>';
		}

		$page .= '<h3 class="prodigy-products-list-item__title  min-height-auto mb-4">' . esc_attr( $current_category['name'] ) . '</h3>' .
				 '<button class="prodigy-primary-cell__btn" aria-label="' . __( 'Details', 'prodigy' ) . '"><span class="icon icon-arrow-down"></span></button>' .
				 '<div class="prodigy-products-list-item__links d-flex"><a class="d-block prodigy-products-list-item__link" target="_blank" href="' . esc_url( $edit_url ) . '">' . __( 'Edit on Prodigy', 'prodigy' ) . '</a></div>' .
				 '<div class="prodigy-primary-cell__mobile-content"><table>' .
				 '<tr><td class="pl-0 pt-4 pb-4 pr-16">' . __( 'Product', 'prodigy' ) . '</td><td class="pt-4 pb-4 pl-4">' . esc_attr( $current_category['products-count'] ) . '</td></tr>' .
				 '<tr><td class="pl-0 pt-4 pb-4 pr-16">';
		if ( $current_category['is_synced'] ) {
			$page .= '<span class="prodigy-syncstatus__synced d-inline-block"></span>';
		} else {
			$page .= '<span class="prodigy-syncstatus__not-synced d-inline-block"></span></td>';
		}

		if ( $current_category['is_synced'] ) {
			$page .= '<td class="pt-4 pb-4 pl-4"><span class="prodigy-syncstatus__synced-txt d-inline-block">' . __( 'Synced', 'prodigy' ) . '</span>';
		} else {
			$page .= '<span class="prodigy-syncstatus__not-synced-txt d-inline-block">' . __( 'Not Synced', 'prodigy' ) . '</span>';
		}

		$page .= '</td><td class="pt-4 pb-4 pl-4"></td></tr>' .
				 '<tr><td class="pl-0 pt-4 pb-4 pr-16">' . __( 'Date', 'prodigy' ) . '</td><td class="pt-4 pb-4 pl-4">' . esc_html( gmdate( 'Y-m-d H:i', strtotime( esc_attr( $current_category['created-at'] ) ) ) ) . '</td></tr>' .
				 '</table></div>' .
				 '</td><td class="prodigy-hidden-cell">';
		if ( $current_category['is_synced'] ) {
			$page .= '<p class="prodigy-syncstatus__synced-wrap d-flex justify-content-start align-items-center">' .
					 '<span class="prodigy-syncstatus__synced d-inline-block"></span><span class="pl-16">' . __( 'Synced', 'prodigy' ) . '</span></p>';
		} else {
			$page .= '<p class="prodigy-syncstatus__not-synced-wrap d-flex justify-content-start flex-nowrap align-items-center">' .
					 '<span class="prodigy-syncstatus__not-synced d-inline-block pr-4"></span><span class="pl-4">' . __( 'Not Synced', 'prodigy' ) . '</span></p>';
		}
		$page .= '</td><td class="prodigy-hidden-cell"></div>' . esc_attr( $current_category['id'] ) . '</td><td class="prodigy-hidden-cell">' . esc_attr( $current_category['products-count'] ) . '</td><td class="prodigy-hidden-cell">' . esc_html( gmdate( 'Y-m-d H:i', strtotime( esc_attr( $current_category['created-at'] ) ) ) ) . '</td></tr>';
	}

	echo $page;

	foreach ( $categories as $category ) {
		print_list( $category['category'], $category['children'] );
	}
}

?>
	<div class="main-categories-container-js prodigy-admin-custom-template prodigy-admin-custom-template__main-categories">
		<div class="prodigy-products-list">
			<div class="prodigy-products-list-header">
				<h1 class="prodigy-products-list-header__title">
					<?php esc_html_e( 'Categories', 'prodigy' ); ?>
					<span class="in-grey-blue-500 opacity-05"><?php echo esc_attr( ! empty( $count ) ? $count : 0 ); ?></span>
				</h1>
				<div class="prodigy-products-list__sort d-flex flex-column flex-md-row justify-content-md-between align-items-md-end align-items-start">
					<div class="d-flex flex-wrap align-self-md-end align-self-start">
						<a class="prodigy-products-list-item__link d-flex align-items-center"
						   target="_blank"
						   href="<?php echo esc_url( PRODIGY_PROTOCOL_DOMAIN . get_option( 'pg_url_domain_hosted_system' ) . '.' . PRODIGY_CHECKOUT_DOMAIN . '/products/categories/' ); ?>"
						>
							<span class="icon icon-external font-18 mr-4"></span>
							<?php esc_html_e( 'View the Categories on Prodigy', 'prodigy' ); ?>
						</a>
					</div>
					<div class="prodigy-products-list-header__search mt-12">
						<input type="search" class="admin-categories-search-js" value="<?php echo esc_attr( $search ?? '' ); ?>"
							   placeholder="Search by Title">
						<input type="submit" class="button admin-submit-categories-search-js" value="Search">
					</div>
				</div>
			</div>
		</div>
		<table class="posts striped table-view-list widefat wp-list-table">
			<thead>
			<tr>
				<th class="prodigy-manage-column sortable desc prodigy-primary-cell pl-20">
					<span class="prodigy-primary-cell__txt-mobile ml-12">
						<?php esc_html_e( 'Items', 'prodigy' ); ?>
					</span>
					<span class="prodigy-primary-cell__txt">
						<span><?php esc_html_e( 'Title', 'prodigy' ); ?></span>
					</span>
				</th>
				<th class="prodigy-manage-column prodigy-syncstatus-cell prodigy-hidden-cell">
					<span>
						<?php esc_html_e( 'Sync Status', 'prodigy' ); ?>
					</span>
				</th>
				<th class="prodigy-manage-column prodigy-hidden-cell">
					<span>
						<?php esc_html_e( 'ID', 'prodigy' ); ?>
					</span>
				</th>
				<th class="prodigy-manage-column prodigy-hidden-cell">
					<span>
						<?php esc_html_e( 'Products', 'prodigy' ); ?>
					</span>
				</th>
				<th class="prodigy-hidden-cell">
					<?php esc_html_e( 'Created Date', 'prodigy' ); ?>
				</th>
			</tr>
			</thead>
			<tbody>
			<?php if ( isset( $categories['prepared'] ) ) : ?>
				<?php foreach ( $categories['prepared'] as $key => $category ) : ?>
					<?php
					print_list( $category['category'], $category['children'] );
					?>
				<?php endforeach; ?>
			<?php endif; ?>
			</tbody>
		</table>
		<div class=""></div>
	</div>
<div class="no-result-categories-list-js"></div>

<?php if ( isset( $empty_view ) ) : ?>
	<script>
		window.prodigyAdminCategories.init();
	</script>
<?php endif; ?>
