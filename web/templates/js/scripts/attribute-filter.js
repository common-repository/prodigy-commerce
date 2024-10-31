(function( $, window ) {
	'use strict';
	$( document ).ready(
		function() {

			init();

			function init() {
				filter_handler();
			}

			function filter_handler() {
				// show more/less filter values
				$( document ).on(
					'click',
					'.filter__btn-js',
					function () {
						const id_attr       = $( this ).data( 'id' )
						const list          = $( '.filter__item-list-js#filter_attr_' + id_attr )
						const listItems     = list.find( '.prodigy-filter__item-list-li, .prodigy-filter__card-list-item' )
						const btnText       = $( this ).find( '.filter__btn-txt-js' )
						const listOpenClass = 'active'
						const moreText      = 'Show more'
						const lessText      = 'Show less'
						const countShow     = list.data( 'count-show' )

						$( this ).toggleClass( listOpenClass )

						if ($( this ).hasClass( listOpenClass )) {
							btnText.text( lessText )
							listItems.show()
						} else {
							btnText.text( moreText )
							listItems.each(
								function(i) {
									if (i + 1 > countShow) {
										$( this ).hide()
									}
								}
							)
						}
					}
				);
			}

			if (window.location.search === '') {
				localStorage.removeItem( 'price-range' );
				localStorage.removeItem( 'catalog-sortable' );
			}

			$( document ).on(
				'click',
				'.catalog-page-sort-js',
				function () {
					if ( (navigator.platform.indexOf("iPhone") != -1) || (navigator.platform.indexOf("iPod") != -1)) {
						$("select.catalog-page-sort-js").remove();
					}
					$('.catalog-page-device-sort-js').addClass('prodigy-select-md--open');
				}
			);

			$( document ).on(
				'change',
				'.catalog-page-sort-js',
				function () {
					var sort = $( this ).children( "option:selected" ).val();
					if (sort !== undefined) {
						localStorage.setItem( 'catalog-sortable', sort.replace( /\?/g, '&' ) );

						var newParams = [
							[ 'sort', sort ]
						];
						var newUrl = document.location.pathname + prodigyInsertUrlParams(newParams);
						history.pushState('', '', newUrl);
						document.location.reload();
					}
				}
			);

			$(document).on(
				'change',
				'.sort-radio-js',
				function () {
					$('.sort-radio-js').each(function () {
						if ($(this).is(':checked')) {
							var sort = $(this).val();
							if (sort !== undefined) {
								localStorage.setItem('catalog-sortable', sort.replace(/\?/g, '&'));

								var newParams = [
									['sort', sort]
								];
								var newUrl = document.location.pathname + prodigyInsertUrlParams(newParams);
								history.pushState('', '', newUrl);
								document.location.reload();
							}
						}
					});
				}
			);


			$('body, .catalog-page-device-sort-close-js').click(function() {
				$('.catalog-page-device-sort-js').removeClass('prodigy-select-md--open');
			});

			$('.prodigy-select-md__wrap').click(function(event){
				event.stopPropagation();
			});

			$( document ).on(
				'click',
				'.clear-params-js',
				function (e) {
					localStorage.removeItem( 'price-range' );
					localStorage.removeItem( 'catalog-sortable' );
				}
			);

			$( document ).on(
				'click',
				'.price-filter-submit-js',
				function (e) {
					localStorage.setItem( 'price-range', window.location.search.replace( /\?/g, '&' ) );
				}
			);

			$( document ).on(
				'click',
				'.attribute-filter-js',
				function (e) {
					e.preventDefault();
					var path_redirect = $( this ).attr( 'href' );

					history.pushState( '', '', encodeURI( path_redirect ) );
					document.location.reload();
				}
			);

			const filterToggleBtnHandler = () => {
				$( '#filter-toggle-btn' ).toggleClass( 'prodigy-shop-sidebar-btn--show' );
				$( '#filter' ).toggleClass( 'prodigy-shop-sidebar--open' );
			}
			$( 'body' ).on( 'click', '#filter-toggle-btn, #filter-toggle-btn-2, #shop-sidebar-backdrop-js', filterToggleBtnHandler );

		}
	);
})( jQuery, window );
