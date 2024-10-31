<?php
use Prodigy\Includes\Helpers\Prodigy_Formatting;
?>
<input type="hidden" id="single-product-price-js" value="<?php echo ! empty( $main_price['sale-price'] ) ? $main_price['sale-price'] : $main_price['price']; ?>">
<?php if ( ! $is_tiered_prices ) : ?>
	<?php if ( ! empty( $product->get_variant_options() ) ) : ?>
		<?php
		if (
				isset( $main_price['range']['min_price'] ) &&
				$product->get_range_setting() &&
				$main_price['range']['min_price'] === $main_price['range']['max_price']
		) :
			?>
			<div class="prodigy-product__main-price">
				<span><?php echo esc_html( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $main_price['range']['min_price'] ) ); ?></span>
			</div>
			<?php
		elseif ( isset( $main_price['range']['min_price'] ) && ! $product->get_range_setting() ) :
			?>
			<div class="prodigy-product__main-price">
				<?php if ( isset( $main_price['sale-price'] ) ) : ?>
					<div class="prodigy-product__main-price">
						<span class="prodigy-product-list__item-price--sale"><?php echo esc_html( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $main_price['price'] ) ); ?></span>
						<span class="prodigy-product-list__item-price-js"><?php echo esc_html( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $main_price['sale-price'] ) ); ?></span>
					</div>
				<?php else : ?>
					<div class="prodigy-product-list__item-price">
						<?php echo esc_html( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $main_price['price'] ) ); ?>
					</div>
				<?php endif; ?>
			</div>
			<?php
		elseif (
				isset( $main_price['range']['min_price'] ) &&
				$product->get_range_setting() &&
				$main_price['range']['min_price'] !== $main_price['range']['max_price']
		) :
			?>
			<span class="prodigy-product__main-price main-price-currency-js" style="display: none">$</span><span class="prodigy-product__main-price main-price-js">
				<?php esc_html_e( 'From', 'prodigy' ); ?>
				<span><?php echo esc_html( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $main_price['range']['min_price'] ) ); ?></span>
				<?php esc_html_e( 'to', 'prodigy' ); ?>
				<span><?php echo esc_html( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $main_price['range']['max_price'] ) ); ?></span>
			</span>
		<?php elseif ( isset( $main_price['range'] ) && $main_price['range']['min_price'] == $main_price['range']['max_price'] ) : ?>
			<?php if ( isset( $main_price['sale-price'] ) ) : ?>
				<div class="prodigy-product__main-price">
					<span class="prodigy-product-list__item-price--sale"><?php echo esc_html( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $main_price['price'] ) ); ?></span>
					<span class="prodigy-product-list__item-price-js"><?php echo esc_html( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $main_price['sale-price'] ) ); ?></span>
				</div>
			<?php else : ?>
				<div class="prodigy-product-list__item-price">
					<?php echo esc_html( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $main_price['price'] ) ); ?>
				</div>
			<?php endif; ?>
		<?php elseif ( isset( $main_price['range'] ) ) : ?>
			<div class="prodigy-product__main-price">
				<span><?php echo esc_html( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $main_price['range']['min_price'] ) ); ?></span>
			</div>
		<?php endif; ?>
	<?php else : ?>
		<div class="prodigy-product__main-price">
			<?php if ( ! empty( $main_price['sale-price'] ) && ! empty( $main_price['price'] ) ) : ?>
				<div class="prodigy-product__main-price">
					<span class="prodigy-product-list__item-price--sale"><?php echo esc_html( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $main_price['price'] ) ); ?></span>
					<span class="prodigy-product-list__item-price-js"><?php echo esc_html( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $main_price['sale-price'] ) ); ?></span>
				</div>
			<?php else : ?>
				<div class="prodigy-product__main-price">
					<span><?php echo esc_html( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $main_price['price'] ) ); ?></span>
				</div>
			<?php endif; ?>
		</div>
	<?php endif; ?>
<?php else : ?>
	<div class="prodigy-product__main-price">
		<?php if ( isset( $tiered_price_range['min_price'], $tiered_price_range['max_price'] ) ) : ?>
			<?php if ( $tiered_price_range['min_price'] === $tiered_price_range['max_price'] ) : ?>
				<span><?php echo esc_html( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $tiered_price_range['min_price'] ) ); ?></span>
			<?php else : ?>
				<span class="prodigy-product__main-price" style="display: none">$</span><span class="prodigy-product__main-price main-price-js">
					<?php esc_html_e( 'From', 'prodigy' ); ?>
					<span><?php echo esc_html( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $tiered_price_range['min_price'] ) ); ?></span>
					<?php esc_html_e( 'to', 'prodigy' ); ?>
					<span><?php echo esc_html( get_option( 'pg_currency_type' ) . Prodigy_Formatting::prodigy_price_format( $tiered_price_range['max_price'] ) ); ?></span>
				</span>
			<?php endif; ?>
		<?php endif; ?>
	</div>
<?php endif; ?>
