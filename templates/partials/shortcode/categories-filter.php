<?php
/* Template Name: Left Categories Filters shortcode */

use Prodigy\Includes\Content\Prodigy_Product_Attributes;
use Prodigy\Includes\Prodigy;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$idwidget = $attr_shortcode['idwidget'] ?? '';
if ( ! empty( $idwidget ) ) {
	$settings = get_option( $attr_shortcode['idwidget'] );
}

$heading_text = $settings['prg_browse_style_heading_text'] ?? 'Browse';
?>

<?php if ( isset( $idwidget ) && ! empty( $idwidget ) ) : ?>
	<div class="prodigy-filter__main prodigy-custom-template">
		<h3 class="prodigy-filter__title"><?php echo esc_html( $heading_text ); ?></h3>
<?php endif; ?>

<div class="filter__browse">
	<div class="prodigy-filter__accordion" id="accordion">
		<?php
		if ( ! empty( $categories ) ) :
			usort(
				$categories,
				function ( $a, $b ) {
					return $a['position'] - $b['position'];
				}
			);

			foreach ( $categories as $category ) :
				if ( $category['name'] === 'DefaultCategory' ) {
					continue;
				}

				$category_term = Prodigy_Product_Attributes::get_term_id_by_meta_key( 'prodigy_hosted_category_relation', (int) $category['id'] );
				$url           = esc_url( get_category_link( $category_term->term_id ?? '', Prodigy::get_prodigy_category_type() ) );
				?>

				<div class="prodigy-filter__card prodigy-filter__card-list-item mb-0" id="cat_<?php echo esc_attr( $category['id'] ); ?>">
					<input type="hidden" class="active-category-js" data-category-id="<?php echo esc_attr( $args['active_id'] ) ?? ''; ?>">
					<input type="hidden" class="parent-category-js" data-parent-id="<?php echo esc_attr( $args['parent_id'] ) ?? ''; ?>">
					<div class="prodigy-filter__card-header"
						id="headingCollapse_<?php echo esc_attr( $category['id'] ); ?>">
								<span>
									<a class="filter__card-link filter__card-link-category-id filter-category-id-js"
										data-category="<?php echo esc_attr( $category['id'] ); ?>"
										href="<?php echo esc_url( $url ); ?>"
										style="font-weight: <?php echo $active_category === $category['name'] ? 'bold' : ''; ?>"
									>
										<?php echo esc_html( $category['name'] ); ?>
									</a>
									<?php if ( $request_count ) : ?>
										<?php if ( $idwidget ) : ?>
											<?php if ( $attr_shortcode['show_product_count'] === 'yes' ) : ?>
												<span class="filter__card-count">(<?php echo esc_html( $category['count'] ); ?>)</span>
											<?php endif; ?>
										<?php else : ?>
											<span class="filter__card-count">(<?php echo esc_html( $category['count'] ); ?>)</span>
										<?php endif; ?>
									<?php endif; ?>
								</span>
						<?php if ( ! empty( $subcategories[ $category['id'] ] ) ) : ?>
							<button
									class="prodigy-filter__card-btn prodigy-icon-btn"
									data-toggle="collapse"
									data-target="#collapse_<?php echo esc_attr( $category['id'] ); ?>"
									aria-label="Expand"
									aria-expanded="false"
									aria-controls="collapse_<?php echo esc_attr( $category['name'] ); ?>"
							>
								<i class="icon-arrow-down"></i>
							</button>
						<?php endif; ?>
					</div>
					<div
							class="collapse"
							id="collapse_<?php echo esc_attr( $category['id'] ); ?>"
							aria-labelledby="headingCollapse_<?php echo esc_attr( $category['id'] ); ?>"
							data-parent="#accordion"
					>
						<div class="prodigy-filter__card-body">
							<?php echo $subcategories[ $category['id'] ]; ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>

<?php if ( isset( $idwidget ) && ! empty( $idwidget ) ) : ?>
	</div>
<?php endif; ?>

<script src="<?php echo esc_url( plugin_dir_url( PRODIGY_PLUGIN_PATH . '/includes/frontend/shortcodes/js/prodigy-category.js' ) ) . 'prodigy-category.js'; ?>"></script>
