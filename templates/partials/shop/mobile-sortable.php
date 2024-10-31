
<div class="prodigy-custom-template">
	<div class="container d-lg-none">
		<div class="prodigy-product-list-options">
			<a class="prodigy-product-list-options__filter filter-js" href="#filter">
				<div class="icon icon-filter prodigy-product-list-options__filter-icon"></div>
				<span class="prodigy-product-list-options__filter-txt"><?php esc_html_e( 'FILTER', 'prodigy' ); ?></span>
			</a>
			<div class="prodigy-product-list-options__results">
				<div class="prodigy-product-list-options__results-label">
					<?php if ( ! empty( $search ) ) : ?>
						<?php esc_html_e( 'Search results for', 'prodigy' ); ?> <span
						class="prodigy-sort__results-item"><?php echo esc_attr( $search ); ?></span>
					<?php endif; ?>
					<?php echo esc_html__( 'Showing:', 'prodigy' ) . '&nbsp;'; ?>
				</div>

				<div class="prodigy-product-list-options__results-data">
					<?php if ( isset( $from, $to, $of ) ) : ?>
						<?php
						printf(
							esc_html__( '%1$s - %2$s of %3$s results', 'prodigy' ),
							esc_attr( $from ),
							esc_attr( $to ),
							esc_attr( $of )
						);
						?>
					<?php endif; ?>
				</div>
			</div>

			<div class="prodigy-dropdown dropdown prodigy-product-list-options__dropdown">
				<select class="prodigy-main-select" onchange="location = this.value;">
					<option
						value="<?php echo esc_attr( add_query_arg( 'sort', '-created_at', esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) ) ) ); ?>"
						<?php echo ( sanitize_text_field( $sort[1] ) === '-created_at' ) ? 'selected' : ''; ?>>
						<?php esc_html_e( 'Sort by newness', 'prodigy' ); ?>
					</option>
					<option
						value="<?php echo esc_attr( add_query_arg( 'sort', '-rating', esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) ) ) ); ?>"
						<?php echo ( sanitize_text_field( $sort[1] ) === '-rating' ) ? 'selected' : ''; ?>>
						<?php esc_html_e( 'Sort by average rating', 'prodigy' ); ?>
					</option>
					<option
						value="<?php echo esc_attr( add_query_arg( 'sort', 'price', esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) ) ) ); ?>"
						<?php echo ( sanitize_text_field( $sort[1] ) === 'price' ) ? 'selected' : ''; ?>>
						<?php esc_html_e( 'Sort by price: low to high', 'prodigy' ); ?>
					</option>
					<option
						value="<?php echo esc_attr( add_query_arg( 'sort', '-price', esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) ) ) ); ?>"
						<?php echo ( sanitize_text_field( $sort[1] ) === '-price' ) ? 'selected' : ''; ?>>
						<?php esc_html_e( 'Sort by price: high to low', 'prodigy' ); ?>
					</option>
				</select>
			</div>
		</div>
	</div>

</div>
