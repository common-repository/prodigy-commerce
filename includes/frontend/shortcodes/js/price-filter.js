(function( $, window ) {
	'use strict';
	$( document ).ready(
		function() {
			var to          = 1000;
			var from        = 0;
			let from_change = 0;
			let to_change   = 0;

			var slider_widget = {
				init: function (min, max, query_min_price, query_max_price) {

					if (min === undefined || min === null) {
						min = params.min
					}
					if (max === undefined || max === null) {
						max = params.max
					}

					const min_price = min;
					const max_price = max;

					const button_apply        = $( '.price-filter-submit-js' );
					let taxonomy              = button_apply.data( 'taxonomy' );
					let current_type_category = button_apply.data( 'category-type' );

					button_apply.hide();
					var slider = $( ".js-range-slider" );

					slider.ionRangeSlider(
						{
							from: min,
							to: max,
							hide_min_max: true,
							hide_from_to: true,

							onStart: function (data) {
								if (getUrlParam( 'price_min' ) !== null ) {
									$( '.min-js' ).val( getUrlParam( 'price_min' ) );
								} else {
									$( '.min-js' ).val( min );
								}
								if (getUrlParam( 'price_max' ) !== null) {
									$( '.max-js' ).val( getUrlParam( 'price_max' ) );
								} else {
									$( '.max-js' ).val( max );
								}
							},

							onChange: function (data) {
								button_apply.show();

								from_change = data.from;
								$( '.min-js' ).val( data.from );

								to_change = data.to;
								$( '.max-js' ).val( data.to );
							}
						}
					);

					var input_min       = $( ".min-js" );
					var input_max       = $( ".max-js" );
					var slider_instance = slider.data( "ionRangeSlider" );

					input_min.on(
						"change",
						function () {
							button_apply.show();

							var input = parseInt( $( this ).val() );
							if (input > min_price && input < max_price) {
								 min = input;
							} else {
									 $( this ).val( min_price );
							}

							slider_instance.update(
								{
									from: $( this ).val(),
								}
							);
						}
					);

					input_max.on(
						"change",
						function () {
							button_apply.show();
							var input = parseInt( $( this ).val() );
							if (input > min_price && input < max_price) {
								 max = input;
							} else {
									 $( this ).val( max_price );
							}

							slider_instance.update(
								{
									to: $( this ).val(),
								}
							);
						}
					);

					button_apply.click(
						function () {
							if ( query_min_price !== 0 ) {
								from = query_min_price;
							}
							if ( query_max_price !== 0 ) {
								to = query_max_price;
							}

							if ( min ) {
								from = min;
							}
							if ( max ) {
								to = max;
							}

							if ( from_change ) {
								from = from_change;
							}
							if ( to_change ) {
								to = to_change;
							}

							var newParams = [
							[ 'price_min', from ],
							[ 'price_max', to ],
							];

							let path_redirect = '';
							if (params.is_shop_page === 'false') {
								path_redirect = document.location.origin + '/' + params.shop_page;
							} else {
								if (taxonomy === current_type_category) {
									path_redirect = document.location.pathname;
								} else {
									path_redirect = document.location.origin + '/shop';
								}
							}

							var newUrl = path_redirect + prodigyInsertUrlParams( newParams );
							newUrl = removeParam( 'search', newUrl );
							history.pushState( '', '', newUrl );
						}
					);
				},
			};

			function removeParam(key, sourceURL) {
				var rtn     = sourceURL.split( "?" )[0],
				param,
				params_arr  = [],
				queryString = (sourceURL.indexOf( "?" ) !== -1) ? sourceURL.split( "?" )[1] : "";
				if (queryString !== "") {
					params_arr = queryString.split( "&" );
					for (var i = params_arr.length - 1; i >= 0; i -= 1) {
						param = params_arr[i].split( "=" )[0];
						if (param === key) {
							params_arr.splice( i, 1 );
						}
					}
					if (params_arr.length) {
						rtn = rtn + "?" + params_arr.join( "&" );
					}
				}
				return rtn;
			}

			if ($( '.price-filter-container-js' ).length !== 0) {
				slider_widget.init( getUrlParam( 'price_min' ), getUrlParam( 'price_max' ) );
			}
			window.slider_widget = slider_widget;

			function set_price_range_analytic_event(min_price, max_price) {
				gtag(
					'event',
					'set_price_filter',
					{
						"event_category": 'prodigy_product_catalog',
						'event_label': 'change_price_filter',
						'value': min_price
					}
				);
			}

			function getUrlParam( name ) {
				var results = new RegExp( '[\?&]' + name + '=([^&#]*)' ).exec( window.location.href );
				if (results == null) {
					return null;
				}

				return decodeURI( results[1] ) || 0;
			}
		}
	);
})( jQuery, window );

jQuery(
	function ($) {
		window.slider_widget.init();
	}
);
