jQuery( document ).ready(
	function ($) {

		var columns_number = parseInt( $( '.categories-columns-number-js' ).val() );
		$( '.categories-slider-js' ).not( '.slick-initialized' ).slick(
			{
				mobileFirst: true,
				responsive: [
				{
					breakpoint: 767,
					settings: {
						slidesToShow: columns_number,
						slidesToScroll: columns_number,
					}
				},
				],
				prevArrow: '<button class="prodigy-related__products-nav prodigy-related__products-nav--categories  prodigy-related__products-nav--prev icon icon-arrow-left" type="button"></button>',
				nextArrow: '<button class="prodigy-related__products-nav prodigy-related__products-nav--categories  prodigy-related__products-nav--next icon icon-arrow-right" type="button"></button>'
			}
		);
	}
);
