(function ($) {
    console.log('Customizer script loaded');

    const customColors = window.btCustomizerPalette?.colors || [];

    if (typeof $.wpColorPicker !== 'undefined') {
        wp.customize.bind('ready', function () {
            const original = $.wpColorPicker.prototype._create;

            $.wpColorPicker.prototype._create = function () {
                this.options.palettes = customColors;
                original.call(this);
            };

            $('.wp-color-picker').iris('option', 'palettes', customColors);
        });
    }

    $(document).ready(function () {
        $('.wp-picker-container').each(function () {
            const input = $(this).find('.wp-picker-input-wrap');
            if (input.length) {
                $(this).iris({
                    mode: 'hsl',
                    controls: {
                        horiz: 'h',
                        vert: 's',
                        strip: 'l',
                    },
                    palettes: customColors,
                });
            }
        });
    });
})(jQuery);
