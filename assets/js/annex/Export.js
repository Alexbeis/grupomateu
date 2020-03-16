'use strict';
const swal = require('sweetalert2');

(function(window, $, swal) {

    window.Export = function() {
        console.log('export pdf constructor');
    };

    $.extend(window.Export.prototype, {
        options:{
            pdf: '.js-export-pdf'
        },


        handleExport(anexedIds, url) {
            if (anexedIds.length === 0) {
                this._fireAlert();
                return;
            }

            let qs = anexedIds.map(el => {
                return `id[]=${el}`;
            }).join('&');

            window.location.href = url + '?' + qs;
        },

        _fireAlert() {
            swal.fire({type:'warning', title:'Debes seleccionar al menos un anexo'});
        }
    });

})(window, jQuery, swal);
