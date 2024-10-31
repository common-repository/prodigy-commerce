(function( $ , window) {
    var prodigy_admin_categories = {

        init: function () {
            this.get_categories_page_content();
            this.set_categories_search_parameters();
            this.mobile_cell_btn();
        },

        set_categories_search_parameters: function () {
            var self = this;
            var search = this.prodigyGetUrlParam('search');
            if (typeof search !== 'undefined' && search !== 0) {
                $('.admin-categories-search-js').val(this.prodigyGetUrlParam('search'));
            }

            $(document).on('click', '.admin-submit-categories-search-js', function () {
                self.set_categories_search_params();
            });
        },

        prodigyGetUrlParam: function (name) {
            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
            if (results == null) {
                return null;
            }

            return decodeURI(results[1]) || 0;
        },

        set_categories_search_params: function() {
            var search_value = $('.admin-categories-search-js').val();

            var newParams = [
                ['search', search_value]
            ];

            var newUrl = document.location.origin + '/wp-admin/edit.php' + prodigyInsertUrlParams(newParams);

            history.pushState('', '', newUrl);

            document.location.reload();
            $('.admin-categories-search-js').val(search_value);
        },

        get_categories_page_content: function() {
            var query = window.location.search.slice(1);
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: 'prodigy-get-categories-content',
                    query: query,
                    nonce: admin_data.nonce,
                },
                cache: false,
                success: function (response) {
                    if(response.data.data != null && typeof response.data.data != "undefined") {
                        if (response.data.data.length === 0) {
                            $('.no-result-categories-list-js').append('<p>No categories found</p>');
                        }
                    }

                    if (typeof response.data.search !== "undefined") {
                        $('.admin-categories-search-js').val(response.data.search);
                    }

                    $('.main-categories-container-js').html(response.data.categories);
                }
            });
        },

        mobile_cell_btn: function() {
            $(document).on('click', '.prodigy-primary-cell__btn', (evt) => {
                $(evt.currentTarget)
                    .toggleClass('prodigy-primary-cell__btn--show')
                    .parent()
                    .find('.prodigy-primary-cell__mobile-content')
                    .toggleClass('prodigy-primary-cell__mobile-content--show');
            });
        }
    }
    window.prodigyAdminCategories = prodigy_admin_categories;
})(jQuery, window);