(function ($) {
    console.log('Customizer script loaded');

    // Custom color palette for Bricks and Customizer
    const customColors = [
        '#ffffff',
        '#1e1e1e',
        '#999999',
        '#444444',
        '#f8f8f8',
        '#666666',
        '#133337',
        '#008080',
        '#808080',
        '#101010'
    ];

    // Ensure wpColorPicker is available
    if (typeof $.wpColorPicker !== 'undefined') {
        // Wait until the Customizer is ready
        wp.customize.bind('ready', function () {
            // Overriding wpColorPicker to set custom color palettes
            const original = $.wpColorPicker.prototype._create;

            $.wpColorPicker.prototype._create = function () {
                this.options.palettes = customColors;
                original.call(this);
            };

            // Update color pickers in the Customizer preview
            $('.wp-color-picker').iris('option', 'palettes', customColors);
        });
    } else {
        console.error("wpColorPicker is not defined!");
    }

    // Initialize custom color presets for the Customizer panels
    jQuery(document).ready(function ($) {
        $('.wp-picker-container').each(function () {
            var input = $(this).find('.wp-picker-input-wrap');
            if (input.length) {
                // Override Iris color picker with custom color presets
                $(this).iris({
                    mode: 'hsl',
                    controls: {
                        horiz: 'h', // Hue
                        vert: 's',  // Saturation
                        strip: 'l'  // Lightness
                    },
                    palettes: customColors // Use the same custom colors defined above
                });
            }
        });
    });

})(jQuery);
