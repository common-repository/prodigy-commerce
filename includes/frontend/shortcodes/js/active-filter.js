(function( $ ) {
	'use strict';

	$( document ).ready(
		function() {
			let current_type_tag = prodigy_active_filter.current_type_tag;

			$(document).on('click','.filter-close-js',function(){
					let element = $( this ).closest('.prodigy-main-badge');
					remove_attr_value( element, $.trim( element.text() ) );
				}
			);

			function remove_attr_value(self, close_p) {
				let close_param = close_p;
				let attr_name   = self.attr( "data-attribute-name" );
				let new_url = '';
				if (attr_name === 'Price') {
					let url          = new URL( document.location.href );
					let params_price = new URLSearchParams( url.search.slice( 1 ) );
					params_price.delete( 'price_max' );
					params_price.delete( 'price_min' );
					new_url = "";
				} else if (attr_name === 'tag') {
					let url           = new URL( document.location.href );
					let params_search = new URLSearchParams( url.search.slice( 1 ) );
					params_search.delete( current_type_tag );

					let new_search = '';
					if (params_search.toString()) {
						new_search = '?' + params_search.toString();
					}
					new_url = document.location.origin + '/shop/' + new_search;
				} else {
					let param_values = prodigyGetUrlParam( 'attr%5B' + attr_name + '%5D' );
					if (param_values !== null) {
						let params_attr = param_values.split(';');
						let carIndex = params_attr.indexOf(close_param);
						params_attr.splice(carIndex, 1);
						new_url = setUrlParameter(document.location + '', 'attr%5B' + attr_name + '%5D', params_attr.join('%3B'));
					}
				}

				history.pushState( '', '', new_url );
			}
		}
	);

})( jQuery );
