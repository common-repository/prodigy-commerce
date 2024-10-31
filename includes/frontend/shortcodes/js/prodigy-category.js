(function ($) {

	'use strict';

	$( document ).ready(
		function () {
			var active_id = $( '.active-category-js' ).data( 'category-id' );
			var parent_id = $( '.parent-category-js' ).data( 'parent-id' );

			if ( typeof active_id !== 'undefined' && typeof parent_id !== 'undefined' ) {
				control_menu( active_id, parent_id );
			}

			function control_menu(category_active_id, parent_id) {

				const card_element                  = document.querySelector( '#cat_' + parent_id );
				const collapse_element              = document.querySelector( '#collapse_' + parent_id );
				const collapse_heading_element_link = document.querySelector( '#headingCollapse_' + parent_id + ' .filter__card-link' );
				const collapse_button               = document.querySelector( '#headingCollapse_' + parent_id + ' .prodigy-filter__card-btn' );

				if (category_active_id !== parent_id) {
					const sub_cut_element = document.querySelector( '#sub_cat_' + category_active_id );
					if (sub_cut_element) {
						sub_cut_element.classList.toggle( 'filter__card-list-item--active' );
						sub_cut_element.classList.add( 'font-800' );
					}
					if (collapse_element) {
						collapse_element.classList.toggle( 'show' );
					}

				}

				if (collapse_button) {
					collapse_button.setAttribute( 'aria-expanded', 'true' );
				}

				if (card_element) {
					collapse_heading_element_link.classList.replace( 'filter__card-link', 'filter__card-link--active' );
					collapse_heading_element_link.classList.add( 'font-800' );
					collapse_button.setAttribute('aria-expanded','false');
				}
			}

		}
	);

})( jQuery );
