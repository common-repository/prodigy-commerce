<?php
use Prodigy\Includes\Support\Customizer\Prodigy_Customizer;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$has_sidebar = $prodigy_shop_sidebar === Prodigy_Customizer::PRODIGY_SHOW_FILTER_BUTTON;
?>
<div class="col-lg-3 prodigy-shop-sidebar-wrap pl-0 <?php echo $has_sidebar ? 'prodigy-shop-sidebar-wrap--none' : ''; ?>">
	<div class="prodigy-shop-sidebar prodigy-shop-sidebar--lg-none prodigy-filter <?php echo $has_sidebar ? 'prodigy-shop-sidebar--lg-aside' : ''; ?>" id="filter">
		<div class="prodigy-shop-sidebar__btn-close-wrap">
			<h3 class="prodigy-filter__btn-close-title"><?php esc_html_e( 'Filters', 'prodigy' ); ?></h3>
			<button class="prodigy-shop-sidebar-btn"
					id="filter-toggle-btn"
					aria-label="Close Sidebar">
				<span class="icon icon-close"></span>
			</button>
		</div>
		<?php dynamic_sidebar( 'prodigy_shop_sidebar' ); ?>
	</div>
	<div id="shop-sidebar-backdrop-js" class="prodigy-shop-sidebar-backdrop"></div>
</div>
