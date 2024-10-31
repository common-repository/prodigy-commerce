(function( $ ) {
    'use strict';

    var shop_page_url = settings.shop_page_url;
    $(document).ready(function() {
        let catalog_containers = [
            'filter__browse',
            'filter-widget-container-js',
            'prodigy-pagination',
            'catalog-sort-js',
            'price-filter-container-js'
        ];

        init();
        function init() {
            set_search_parameters();
            set_dropdown_sortable();
            search_handler();
            update_container_width();
            slow_search();
            hiding_search_widget();
            hiding_empty_search_space();
            set_number_of_columns_by_screen_resolution();
        }

        function set_number_of_columns_by_screen_resolution() {
            let windowWidth = screen.width;
            let default_number_of_columns = settings.customizer_product_columns;
            let number_of_columns = 1;

            if (windowWidth >= 1440) {
                number_of_columns = default_number_of_columns;
            } else if (windowWidth >= 1024) {
                number_of_columns = (default_number_of_columns >= 4) ? 4 : default_number_of_columns;
            } else if (windowWidth >= 768) {
                number_of_columns = (default_number_of_columns >= 3) ? 3 : default_number_of_columns;
            } else if (windowWidth >= 375) {
                number_of_columns = (default_number_of_columns >= 2) ? 2 : default_number_of_columns;
            }

            $('.shop-resolution-js').addClass('prodigy-product-list__grid-' + number_of_columns);
        }

        function hiding_empty_search_space() {
            let search = $('.catalog-page-sort-js');
            let sorting = $('.prodigy-search__input-js');
            if ( search.length === 0 && sorting.length === 0 ) {
                $('.prodigy-search-filter').remove();
            }
        }

        function hiding_search_widget() {
            $('.prodigy-filter__main').each(function (index, element) {
                let badge = $(element).find('.prodigy-filter__badges');
                let container_attribute = badge.find('.prodigy-main-badge');
                let active_filter = container_attribute.data('attribute-name');
                if (badge.length !== 0 && typeof active_filter === 'undefined') {
                    element.remove();
                }
            });
        }

        function slow_search() {
            if ( prodigyGetUrlParam('search') ) {
                $("html,body").animate({ scrollTop: 0 }, "slow");
            }
        }

        function update_container_width() {
            const mainContainer = $('.prodigy-catalog');
            let mainRow = mainContainer.children().first();
            let sideBar = mainRow.find('.prodigy-shop-sidebar-wrap');
            let prodContainer = mainRow.find('.prodigy-product-list');

            if (sideBar.length === 0) {
                prodContainer.removeClass('col-lg-9');
                prodContainer.addClass('col-12 pl-0');
            } else if (sideBar.length !== 0) {
                prodContainer.removeClass('col-12 pl-0');
                prodContainer.addClass('col-lg-9');
            }
        }

        function search_handler() {
            const searchBtn = $('.prodigy-search__icon-js');
            const searchWidgetBtn = $('.prodigy-search__icon-widget-js');
            const closeSearchBtn = $('.prodigy-search__close-icon');
            const searchInput = $('.prodigy-search__input-js');

            searchWidgetBtn.on('click', (e) => {
                let input = $(e.target).closest('form').find('.prodigy-search__input-js, .prodigy-search__input-mobile-js');
                if (!input.length) {
                    return;
                }
                set_search_params(input.val());
            });

            searchBtn.on('click', () => {
                localStorage.removeItem('price-range');
                localStorage.removeItem('catalog-sortable');

                /**
                 * for prodigy theme
                 */
                searchInput.toggleClass('prodigy-search__input-is-open');
                searchInput.focus();

                if (searchInput.hasClass('prodigy-search__input-is-open') && searchInput.val().length > 0) {
                    setTimeout(function () {
                        closeSearchBtn.removeClass('d-none');
                    }, 200);
                } else {
                    closeSearchBtn.addClass('d-none');
                }

            });

            if (typeof searchInput.val() !== 'undefined' && searchInput.val().length > 0) {
                searchInput.addClass('prodigy-search__input-is-open');
                closeSearchBtn.removeClass('d-none');
            }

            searchInput.on('keyup', function () {
                if (searchInput.val().length > 0) {
                    closeSearchBtn.removeClass('d-none');
                } else {
                    closeSearchBtn.addClass('d-none');
                }
            });

            closeSearchBtn.on('click', function () {
                searchInput.val('');
                $(this).addClass('d-none');
                var clean_uri = location.protocol + "//" + location.host + '/' + shop_page_url;
                window.history.replaceState({}, document.title, clean_uri);
                document.location.reload();
            });
        }

        function set_search_parameters() {
            var search  = prodigyGetUrlParam('search');
            if ( typeof search !== 'undefined' && search !== 0 ) {
                $('.prodigy-search__input-js').val(prodigyGetUrlParam('search'));
            }

            $(document).on('keypress', '.prodigy-search__input-js, .prodigy-search__input-mobile-js', function(e) {
                let target = $(e.currentTarget);
                if (e.which === 13 && target.val() && typeof target.val() !== 'undefined') {
                    e.preventDefault();
                    set_search_params(target.val());
                }
            });
        }

        function set_search_params(search_value) {

            var newParams = [
                [ 'search', search_value ]
            ];

            var clean_uri = location.protocol + "//" + location.host + '/' + shop_page_url;
            window.history.replaceState({}, document.title, clean_uri);

            var newUrl = document.location.pathname + prodigyInsertUrlParams(newParams);

            history.pushState('', '', newUrl);
            document.location.reload();
        }

        function set_dropdown_sortable() {
            var selText = '';
            var sort_param = prodigyGetUrlParam('sort');
            var dropdown_container = $(".prodigy-dropdown__menu a");

            switch (sort_param) {
                case 'created_at':
                    selText = 'Sort by newness';
                    break;
                case 'rating':
                    selText = 'Sort by average rating';
                    break;
                case 'price':
                    selText = 'Sort by price';
                    break;
                default:
                    selText = 'Sort by newness';
                    break;
            }

            dropdown_container.parents('.btn-group').find('.prodigy-dropdown__btn').html(selText+' <span class="caret"></span>');

            dropdown_container.click(function(e) {
                selText = $(this).text();
                $(this).parents('.btn-group').find('.prodigy-dropdown__btn').html(selText+' <span class="caret"></span>');
            });
        }
        const filterToggleBtnHandler = () => {
            $('.prodigy-shop-sidebar').toggleClass('prodigy-shop-sidebar--open');
            $('body').toggleClass('prodigy-overflow-y-hidden');
            if(!$('.prodigy-shop-sidebar').hasClass('.prodigy-shop-sidebar--open')){
                $('#shop-sidebar-backdrop-js').remove();
            }
            $('<div id="shop-sidebar-backdrop-js" class="prodigy-shop-sidebar-backdrop"></div>').insertAfter('.prodigy-shop-sidebar--open');
        }

        $('body').on('click', '#filter-toggle-btn, #filter-toggle-btn-2, #shop-sidebar-backdrop-js',filterToggleBtnHandler);  
    });
}) (jQuery);
