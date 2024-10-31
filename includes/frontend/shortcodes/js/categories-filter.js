(function( $ ) {
	'use strict';

	var shop_page_url = typeof options !== 'undefined' ? options.shop_page_url : '';
	$( document ).ready(
		function() {
			init();

			function init() {
				// get_catalog_content();
			}

			function get_catalog_content() {
				var category = window.location.pathname.split( '/' )[2];

				var sidebar_skeleton = '<div class="filter-skeleton">\n' +
				'                <div class="filter-skeleton__item filter-skeleton__item--lg"></div>\n' +
				'                <div class="filter-skeleton__item filter-skeleton__item--lg"></div>\n' +
				'                <div class="filter-skeleton__item filter-skeleton__item--sm"></div>\n' +
				'                <div class="filter-skeleton__item filter-skeleton__item--sm"></div>\n' +
				'            </div>';

				$( '.filter__browse' ).html( sidebar_skeleton );

				$.ajax(
					{
						type: "POST",
						url: ajaxurl,
						data: {
							action: 'prodigy-get-categories-content-shortcode',
							category: category
						},
						cache: false,
						error: function () {
							$( '.filter__browse' ).html( sidebar_skeleton );
						},
						success: function(response) {
							$( '.filter__browse' ).html( response.data.categories );
						}
					}
				);
			}

			const filterToggleBtnHandler = () => {
				$( '#filter-toggle-btn' ).toggleClass( 'prodigy-shop-sidebar-btn--show' );
				$( '#filter' ).toggleClass( 'prodigy-shop-sidebar--open' );
			}
			$( 'body' ).on( 'click', '#filter-toggle-btn, #filter-toggle-btn-2, #shop-sidebar-backdrop-js', filterToggleBtnHandler );
		}
	);
})( jQuery );
