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
        loadDatatable: function() {
            this.$wrapper.dataTable({
                pageLength: 10,
                responsive: true,
            });
        },

        /**
         * Load modal events
         */
        loadEvents: function() {
            //$('#modal-add-explotation').on('hidden.bs.modal',  () => {
            //    this._cleanErrors();
            //})
        },

        handleAnnexDelete: function(e) {
            e.preventDefault();
            let $target = $(e.currentTarget);
            this._showAlert($target);
        },

        /**
         * Delete on the clicked Row from the DOM
         * @private
         * @param id
         */
        _deleteRow: function (id) {
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
        _showAlert: function ($target) {

            this._showSpinner($target);

            let id = $target.data('id');
            let rowId = $target.closest('tr').attr('id');
            let url = $target.attr('href');
            const self = this;

            swal.fire({
                title: self.options.text.title,
                text: self.options.text.advice,
                type: self.options.text.warning,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Bórrala'
            }).then((result) => {
                if (result.value) {
                    this.ajaxCall
                        .send(url, 'DELETE', {id: id})
                        .then((data) => {
                            if (data.success) {
                                this._fireAlert({type:'success', title:data.message});
                                this._deleteRow('#'+ rowId);

                            } else {
                                this._fireAlert({type:'error', title:data.message});
                            }
                            this._hideSpinner($target);
                        })
                        .catch((err) => {
                            this._hideSpinner($target);
                        });

                } else if (result.dismiss) {
                    this._hideSpinner($target);
                }
            })
        },

        /**
         *
         * @param options
         * @private
         */
        _fireAlert:function (options) {
            swal.fire(options);
        },

        /**
         *
         * @private
         */
        _showSpinner:function ($target) {
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
        _hideSpinner: function ($target) {
            $target
                .find('.js-spinner > i')
                .addClass('hidden');
            $target
                .removeClass('disabled');
        }

    });


})(window, jQuery, swal);

let AnnexTableWrapper = $('#annex-table');

if (AnnexTableWrapper.length > 0) {
    new GMAnnex(AnnexTableWrapper);
}