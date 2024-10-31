jQuery( document ).ready(
	function ($) {
		var columns_number = parseInt( $( '.feature-product-columns-number-js' ).val() );
		if (isNaN( columns_number )) {
			columns_number = 4;
		}

		let is_feature_products = $( '.is-featured-products-js' ).length;

		if ( ! is_feature_products) {
			var left  = 'prodigy-related__products-nav prodigy-related__products-nav--prev icon icon-arrow-left prodigy-related__products-nav--sm';
			var right = 'prodigy-related__products-nav prodigy-related__products-nav--next icon icon-arrow-right prodigy-related__products-nav--sm';
		} else {
			var left  = 'prodigy-related__products-nav prodigy-related__products-nav--prev icon icon-arrow-left';
			var right = 'prodigy-related__products-nav prodigy-related__products-nav--next icon icon-arrow-right';
		}

		$( '.related-products-js' ).not( '.slick-initialized' ).slick(
			{
				prevArrow: "<button type='button' class='" + left + "'></button>",
				nextArrow: "<button type='button' class='" + right + "'></button>",
				dots: false,
				arrows: true,
				mobileFirst: true,
				variableWidth: false,
				responsive: [
				{
					breakpoint: 767,
					settings: {
						variableWidth: false,
						slidesToShow: 3,
						slidesToScroll: 3,
					}
				},
				{
					breakpoint: 1168,
					settings: {
						slidesToShow: columns_number,
						slidesToScroll: columns_number,
						variableWidth: false,
						arrows: true,
					}
				},
				]
			}
		);
	}
);
