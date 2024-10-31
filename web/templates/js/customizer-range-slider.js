/**
 * Script run inside a Customizer control sidebar
 */
(function($) {
    wp.customize.bind('ready', function() {
        rangeSlider();
    });

    var rangeSlider = function() {
        var sliderEl = $('.range-slider'),
            rangeEl = $('.range-slider__range'),
            valueEl = $('.range-slider__value');

        sliderEl.each(function() {
            valueEl.each(function() {
                var value = $(this).prev().attr('value');
                $(this).val(value);
            });

            valueEl.on('input', function() {
                let currentVal = parseInt(this.value);
                const maxValue = 2000;
                if (currentVal > maxValue) {
                    currentVal = maxValue;
                    $(this).val(currentVal);
                    this.value = currentVal;
                }

                $(this).prev().val(currentVal);
                $(this).prev().attr('value', currentVal);
                $(this).prev().trigger('change');
            })

            rangeEl.on('input', function() {
                $(this).next().val(this.value);
            });
        });
    };

})(jQuery);