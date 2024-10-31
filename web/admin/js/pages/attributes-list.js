(function( $ , window) {
    var prodigy_admin_attributes = {

        init: function () {
            this.get_page_content();
            this.set_sortable();
            this.set_attributes_search_parameters();
            this.mobile_cell_btn();
        },

        set_attributes_search_parameters: function () {
            var self = this;
            var search = self.prodigyGetUrlParam('search');
            if (typeof search !== 'undefined' && search !== 0) {
                $('.admin-attributes-search-js').val(self.prodigyGetUrlParam('search'));
            }

            $(document).on('click', '.admin-submit-attributes-search-js', function () {
                self.set_attributes_search_params();
            });
        },

        prodigyGetUrlParam: function(name) {
            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
            if (results==null) {
                return null;
            }

            return decodeURI(results[1]) || 0;
        },

        set_attributes_search_params: function () {
            var search_value = $('.admin-attributes-search-js').val();
            var newParams = [
                ['search', search_value]
            ];

            var newUrl = document.location.origin + '/wp-admin/edit.php' + prodigyInsertUrlParams(newParams);

            history.pushState('', '', newUrl);
            document.location.reload();
            $('.admin-attributes-search-js').val(search_value);
        },

        set_sortable: function () {
            $(document).on('click', '.sortable', function () {
                var sort_value = $(this).attr('data-sort');

                if ($('.sortable').hasClass('desc')) {
                    $(this).removeClass('desc');
                    var newParams = [
                        ['sort', sort_value + '_asc'],
                    ];
                } else {
                    $(this).removeClass('asc');
                    var newParams = [
                        ['sort', '-' + sort_value + '_desc'],
                    ];
                }

                var newUrl = document.location.origin + '/wp-admin/edit.php' + prodigyInsertUrlParams(newParams);
                history.pushState('', '', newUrl);
                document.location.reload();
            });
        },

        get_page_content: function () {
            let query = window.location.search.slice(1) + '&nonce=' + admin_data.nonce;
            $.ajax({
                type: "GET",
                url: ajaxurl + '?action=prodigy-get-attributes-content&' + query,
                cache: false,
                success: function (response) {

                    if(response.data.attributes != null && typeof response.data.attributes.data != "undefined") {
                        if (response.data.attributes.data.length === 0) {
                            $('.no-result-attributes-list-js').append('<p>No attributes found</p>');
                        }
                    }

                    if (typeof response.data.search !== "undefined")
                        $('.admin-attributes-search-js').val(response.data.search);

                    $('.main-attributes-container-js').html(response.data.template);
                    $('.attributes-pagination-js').html(response.data.pagination);
                }
            });
        },

        mobile_cell_btn: function () {
            $(document).on('click', '.prodigy-primary-cell__btn', (evt) => {
                $(evt.currentTarget)
                    .toggleClass('prodigy-primary-cell__btn--show')
                    .parent()
                    .find('.prodigy-primary-cell__mobile-content')
                    .toggleClass('prodigy-primary-cell__mobile-content--show');
            });
        }
    }

    window.prodigyAdminAttributes = prodigy_admin_attributes;
})(jQuery, window);