'use strict';

(function(window, $) {

    window.ExportPdf = function() {
        console.log('export pdf constructor');
    };

    $.extend(window.ExportPdf.prototype, {
        options:{
            pdf: '.js-export-pdf'
        },


        handleExportPdf(anexedIds, url) {
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
