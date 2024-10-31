(function ($) {

    let list_filters = $('.js-list-attributes-widget-filter');

    $(document).on('click', '.button-link-delete.widget-control-remove', function (e) {

        let id_widget = $(this).closest('div.widget').attr('id');
        let myRe = /filters_prodigy_widget/g;
        let info = myRe.test(id_widget);

        if (info === true) {
            list_filters.val(null).trigger('change');
            list_filters.select2('destroy');
            list_filters.off('select2:select');
        }
    });

    $(document).on('click', '.widgets-chooser-add', function (e) {

        let id_widget = $(this).parent().parent().parent().attr('id');
        let myRe = /filters_prodigy_widget/g;
        let info = myRe.test(id_widget);

        if (info === true) {
            list_filters.select2(
                {
                    width: '100%'
                }
            );
        }
    });

})(jQuery);
