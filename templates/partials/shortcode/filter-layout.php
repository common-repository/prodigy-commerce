<?php

use Prodigy\Includes\Frontend\Prodigy_Layouts_Manager;
use Prodigy\Includes\Helpers\Prodigy_Template;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php
if (
	Prodigy_Layouts_Manager::is_elementor_template() ||
	Prodigy_Layouts_Manager::is_elementor_live_preview()
) :
	?>
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
	<input type="hidden" class="elementor-show-active-filter-js"
			value="<?php echo esc_attr( $args['attr_shortcode']['attrs_content_active_filters'] ?? '' ); ?>">

	<?php if ( $args['elementor_filter_mode'] ) : ?>
		<input type="hidden" class="elementor-show-attributes-filter-js"
				value="<?php echo esc_attr( $args['elementor_filter_mode'] ); ?>">
		<button id="filter-toggle-btn-2" class="prodigy-filter__sm-btn prodigy-main-button__filter__sm-btn prodigy-filter__sm-btn-js"
				style="display: <?php echo $args['elementor_filter_mode'] ? 'flex' : 'none'; ?>">
			<span class="icon icon-filter"></span>
			<?php esc_html_e( 'Filter', 'prodigy' ); ?>
		</button>
	<?php endif; ?>

<?php endif; ?>

<?php
if ( isset( $args['idWidget'] ) ) :
	?>

	<?php
	if (
	$args['elementor_filter_mode'] &&
	( Prodigy_Layouts_Manager::is_elementor_template() || Prodigy_Layouts_Manager::is_elementor_live_preview() )
	) :
		?>
<div class="col-lg-3 prodigy-shop-sidebar-wrap pl-0 prodigy-shop-sidebar-wrap--none">
	<div class="prodigy-shop-sidebar prodigy-shop-sidebar--lg-none prodigy-filter prodigy-shop-sidebar--lg-aside"
		id="filter">
		<?php endif; ?>

		<div class="prodigy-custom-template prodigy-filter__accordion-header prodigy-filter__accordion-header-js"
			style="display: <?php echo $args['elementor_filter_mode'] ? 'none' : 'block'; ?>">
			<?php if ( $args['elementor_filter_mode'] ) : ?>
				<div class="prodigy-shop-sidebar__btn-close-wrap">
					<h3 class="prodigy-filter__btn-close-title flex-grow-1"><?php esc_html_e( 'Filters', 'prodigy' ); ?></h3>
					<button class="prodigy-shop-sidebar-btn" id="filter-toggle-btn-elementor-js"
							aria-label="Close Sidebar">
						<span class="icon icon-close"></span>
					</button>
				</div>
			<?php endif; ?>
			<?php
			if (
				! empty( $args['attr_shortcode']['attrs_content_active_filters'] ) &&
				( Prodigy_Layouts_Manager::is_elementor_template() || Prodigy_Layouts_Manager::is_elementor_live_preview() )
			) {
				do_action( 'prodigy_shortcode_template_active_filters', $args );
			}
			?>
			<?php endif; ?>

			<?php if ( isset( $args['display'] ) && 'accordion' === $args['display'] ) : ?>
				<?php Prodigy_Template::prodigy_get_template( 'shortcode/filter-accordion.php', $args ); ?>
			<?php else : ?>
				<?php Prodigy_Template::prodigy_get_template( 'shortcode/filter-list.php', $args ); ?>
			<?php endif; ?>

			<?php
			if (
				! empty( $args['attr_shortcode']['attrs_content_price_filter'] ) &&
				( Prodigy_Layouts_Manager::is_elementor_template() || Prodigy_Layouts_Manager::is_elementor_live_preview() )
			) {
				do_action( 'prodigy_shortcode_template_price_filter', $args );
			}
			?>

			<?php
			if (
			$args['elementor_filter_mode'] &&
			( Prodigy_Layouts_Manager::is_elementor_template() || Prodigy_Layouts_Manager::is_elementor_live_preview() )
			) :
				?>
		</div>

	<?php endif; ?>
	</div>
	<div id="shop-sidebar-backdrop-elementor-js" class="prodigy-shop-sidebar-backdrop"></div>
	<?php if ( $args['elementor_filter_mode'] ) : ?>
</div>
<?php endif; ?>
