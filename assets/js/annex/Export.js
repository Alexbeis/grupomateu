'use strict';

(function(window, $) {

    window.Export = function() {
        console.log('export pdf constructor');
    };

    $.extend(window.Export.prototype, {
        options:{
            pdf: '.js-export-pdf'
        },


        handleExport(anexedIds, url) {
            if (anexedIds.length === 0) {
                return;
            }

            let qs = anexedIds.map(el => {
                return `id[]=${el}`;
            }).join('&');

            window.location.href = url + '?' + qs;
        }
    });

})(window, jQuery);
