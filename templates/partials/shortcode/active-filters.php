<?php
/* Template Name: Active Filters shortcode */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
	<?php if ( ! empty( $args_request ) ) : ?>
		<div class="prodigy-filter__main prodigy-filter__main-active prodigy-custom-template active-filter-js">
			<div class="prodigy-filter__main-title-wrap position-relative">
				<h3 class="prodigy-filter__title prodigy-active-filter__title"><?php echo esc_html( $heading_active_filter, 'prodigy' ); ?></h3>
				<span class ="prodigy-main-badge__md">
					<a class="prodigy-main-badge prodigy-main-badge--btn clear-params-js" role="button"><?php esc_html_e( 'Clear All', 'prodigy' ); ?></a>
				</span>
			</div>
			<?php endif; ?>
			<div class="prodigy-filter__badges">
				<?php foreach ( $args_request ?? array() as $attribute => $value ) : ?>
					<?php foreach ( $value as $key => $values ) : ?>
						<?php foreach ( $values as $attr ) : ?>
							<span class="prodigy-main-badge" data-attribute-id="<?php echo esc_attr( $key ); ?>" data-attribute-name="<?php echo esc_attr( $attr['name'] ); ?>" data-attribute-slug="<?php echo esc_attr( $attr['slug'] ); ?>">
								<span class="prodigy-main-badge__text">
								<?php if ( ! empty( $is_show_active_filter_name ) ) : ?>
									<span class="prodigy-main-badge__inner-wrap">
										<span class="prodigy-main-badge__attr"><?php echo esc_attr( $key === 'Price' ? $key . ':' : $attribute . ':' ); ?></span>
										<span class="prodigy-main-badge__val"><?php echo esc_attr( $attr['name'] ); ?></span>
									</span>
								<?php else : ?>
									<span class="prodigy-main-badge__val"><?php echo esc_attr( $attr['name'] ); ?></span>
								<?php endif; ?>
									<i class="prodigy-main-badge__close icon icon-close filter-close-js"></i>
								</span>
								<span class="prodigy-main-badge__divider"></span>
							</span>
						<?php endforeach; ?>
					<?php endforeach; ?>
				<?php endforeach; ?>
			</div>

		<?php if ( ! empty( $args_request ) ) : ?>
			</div>
		<?php endif; ?>
