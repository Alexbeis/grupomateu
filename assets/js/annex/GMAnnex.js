'use strict';

const swal = require('sweetalert2');
import AjaxCall from "../shared/AjaxCall";

(function(window, $, swal) {

    window.GMAnnex = function($annexWrapper) {

        this.$wrapper = $annexWrapper;

        this.ajaxCall = new AjaxCall();

        this.$wrapper.on(
            'click',
            this.options._selectors.remove,
            this.handleAnnexDelete.bind(this)
        );

        this.loadDatatable();
        this.table = null;
    };

    $.extend(window.GMAnnex.prototype, {

        options: {
            _selectors: {
                remove: '.js-remove-annex',
            },
            text:{
                title: "Estás seguro?",
                advice: "Ésta acción és irreversible!",
                warning: "warning",
                deleted: "Borrada!",
                error: "Error!"
            }
        },
        errors: {},

        /**
         * Load Datatable data
         */
        loadDatatable() {
            this.$wrapper.dataTable({
                pageLength: 10,
                responsive: true,
            });
        },

        /**
         * Load modal events
         */
        loadEvents() {
            //$('#modal-add-explotation').on('hidden.bs.modal',  () => {
            //    this._cleanErrors();
            //})
        },

        handleAnnexDelete(e) {
            e.preventDefault();
            let $target = $(e.currentTarget);
            this._showAlert($target);
        },

        /**
         * Delete on the clicked Row from the DOM
         * @private
         * @param id
         */
        _deleteRow(id) {
            this.$wrapper
                .DataTable()
                .row(id)
                .remove()
                .draw();
        },

        /**
         * Show Sweet Alert. Makes ajax request
         * @param $target
         * @private
         */
        _showAlert($target) {

            this._showSpinner($target);

            let id = $target.data('id');
            let url = $target.attr('href');

            swal.fire({
                title: self.options.text.title,
                text: self.options.text.advice,
                type: self.options.text.warning,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Bórrala'
            }).then((result) => {
                this._makeDeleteCall(result, url, id, $target)
            });
        },

        /**
         *
         * @param options
         * @private
         */
        _fireAlert(options) {
            swal.fire(options);
        },

        /**
         *
         * @private
         */
        _showSpinner($target) {
            $target
                .find('.js-spinner > i')
                .removeClass('hidden');
            $target
                .addClass('disabled');
        },

        /**
         *
         * @private
         */
        _hideSpinner($target) {
            $target
                .find('.js-spinner > i')
                .addClass('hidden');
            $target
                .removeClass('disabled');
        },

        /**
         * @param result
         * @param url
         * @param id
         * @param $target
         * @private
         */
        _makeDeleteCall(result, url, id, $target) {
            let rowId = $target.closest('tr').attr('id');

            if (result.value) {
                this.ajaxCall
                    .send(url, 'DELETE', {id: id})
                    .then((data) => {
                        this._processResponse(data, rowId);
                        this._hideSpinner($target);
                    })
                    .catch((err) => {
                        this._hideSpinner($target);
                    });

            } else if (result.dismiss) {
                this._hideSpinner($target);
            }
        },

        /**
         * @param data
         * @param rowId
         * @private
         */
        _processResponse(data, rowId) {
            if (data.success) {
                this._fireAlert({type:'success', title:data.message});
                this._deleteRow('#'+ rowId);

            } else {
                this._fireAlert({type:'error', title:data.message});
            }
        }
    });


})(window, jQuery, swal);

let AnnexTableWrapper = $('#annex-table');

if (AnnexTableWrapper.length > 0) {
    new GMAnnex(AnnexTableWrapper);
}