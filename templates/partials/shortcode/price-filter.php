<?php
/* Template Name: Price Filter shortcode */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$idwidget     = $attr_shortcode['idWidget'] ?? '';
$heading_text = $args['heading_price_filter'] ?? 'Price Filter';

?>

<?php if ( $idwidget ) : ?>
<div class="prodigy-filter__main prodigy-filter__main-price prodigy-custom-template">
	<h3 class="prodigy-filter__title prodigy-filter-title-js"><?php echo esc_attr( $heading_text ); ?></h3>
<?php endif; ?>

<div class="price-filter-container-js prodigy-filter__main prodigy-filter__main-price prodigy-filter__price-filter-container">
	<div class="prodigy-filter__item">
		<div class="prodigy-filter__range">
			<input class="js-range-slider" type="text" name="my_range" value="" data-type="double" data-min="<?php echo esc_attr( $min ); ?>" data-max="<?php echo esc_attr( $max ); ?>" data-from="<?php echo esc_attr( $min ); ?>" data-to="<?php echo esc_attr( $max ); ?>">
		</div>
		<form>
			<div class="d-flex justify-content-between mb-16">
				<label class="d-flex flex-column w-100 mr-16">
					<span class="prodigy-filter__field-label"><?php esc_html_e( 'From', 'prodigy' ); ?></span>
					<input class="prodigy-filter__field-input prodigy-main-input min-js" />
				</label>
				<label class="d-flex flex-column w-100">
					<span class="prodigy-filter__field-label"><?php esc_html_e( 'To', 'prodigy' ); ?></span>
					<input class="prodigy-filter__field-input prodigy-main-input max-js" />
				</label>
			</div>
		</form>
		<div class="prodigy-filter__item-price">
			<button data-taxonomy="<?php echo esc_attr( $taxonomy ); ?>" data-category-type="<?php echo esc_attr( $current_type_category ); ?>" class="prodigy-main-button w-100 justify-content-center mt-16 price-filter-submit-js">
				<?php esc_html_e( 'Apply Price', 'prodigy' ); ?>
			</button>
		</div>
	</div>
</div>

<?php if ( $idwidget ) : ?>
	</div>
<?php endif; ?>
