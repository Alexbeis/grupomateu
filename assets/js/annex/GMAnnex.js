'use strict';

const swal = require('sweetalert2');
import AjaxCall from "../shared/AjaxCall";

// Routing
const routes = require('../../../public/js/fos_js_routes.json');
import Routing from '../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
Routing.setRoutingData(routes);


(function(window, $, swal, Routing) {

    window.GMAnnex = function($annexWrapper) {

        this.$wrapper = $annexWrapper;
        this.$pdfButton = $('.js-export-pdf');
        this.$csvButton = $('.js-export-csv');
        this.$bulkButton = $('.js-bulk-unmark');
        this.ajaxCall = new AjaxCall();
        this.export = new Export();

        this.$wrapper.on(
            'click',
            this.options._selectors.remove,
            this.handleAnnexDelete.bind(this)
        );

        this.$pdfButton.on(
            'click',
            this.getAnnexedAndHandleExportPdf.bind(this)
        );

        this.$csvButton.on(
            'click',
            this.getAnnexedAndHandleExportCsv.bind(this)
        );

        this.$bulkButton.on(
            'click',
            this.bulkAnnexRemoveByExplotation.bind(this)
        );

        this.loadDatatable();
        this.loadEvents();
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
                   language: {
                       "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                   },
                   columnDefs: [
                       {
                           targets: 0,
                           searchable: false,
                           orderable: false,
                           className: 'dt-body-center'

                       }
                   ],
                   pageLength: 10,
                   responsive: true
               });
        },

        /**
         * Load modal events
         */
        loadEvents() {

            $('.select-all').on('click', function(e){

                let table = $(e.target).closest('table');
                let rows = table.DataTable().rows().nodes();

                rows.each((row, i)=>{
                    $(row).toggleClass('selected');
                });
            });

            $('.annex-table').on('click', 'tbody tr', function (e) {
                //Avoid mark table header and table footer.
                 if (!(this).closest('tfoot') && !(this).closest('thead')) {
                     $(this).toggleClass('selected');
                 }
            });

        },

        bulkAnnexRemoveByExplotation(e) {
            e.preventDefault();
            let $target = $(e.target);
            let url = $target.attr('href');
            let expCode = $target.data('exp');

            swal.fire({
                title: this.options.text.title,
                text: this.options.text.advice,
                type: this.options.text.warning,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Desvincular Todos'
            }).then((result) => {
                if (result.value) {
                    this.ajaxCall
                        .send(
                            Routing.generate('annex_bulk_delete.'+ window.REQUEST_LOCALE),
                            'DELETE',
                            {'exp_code': expCode}
                            )
                        .then((response)=> {
                           if (response.success) {
                               swal.fire(
                                   'Ok!',
                                   response.message,
                                   'success'
                               );

                               $target.closest('.section-box').fadeOut('slow',() => {
                                   $(this).remove();
                               })
                           } else {
                               swal.fire(
                                   'Error',
                                   response.message,
                                   'warning'
                               )
                           }
                        }).catch(err => {

                    });
                }
            });

        },

        /**
         *
         * @param e
         */
        getAnnexedAndHandleExportPdf(e) {
            e.preventDefault();
            let url = $(e.target).attr('href');
            let tableId = $(e.target).data('exp');

            this.export
                .handleExport(
                    this._extractAnexedIds(tableId),
                    url
                );
        },

        getAnnexedAndHandleExportCsv(e) {
            e.preventDefault();
            const target =  $(e.target);
            const url = target.attr('href');
            const tableId = target.data('exp');

            this.export
                .handleExport(
                    this._extractAnexedIds(tableId),
                    url
                );
        },

        /**
         *
         * @returns {Array}
         * @private
         */
        _extractAnexedIds(tableId) {

            let elementsChecked = [];
            $('#' + tableId).DataTable().$('.selected').each((i, element) => {
                elementsChecked.push(
                    $(element)
                        .closest('tr')
                        .attr('id')
                        .split('_')[1]
                );
            });

            return elementsChecked;
        },

        handleAnnexDelete(e) {
            e.preventDefault();
            e.stopPropagation();
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
                title: this.options.text.title,
                text: this.options.text.advice,
                type: this.options.text.warning,
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


})(window, jQuery, swal, Routing);

let AnnexTableWrappers = $('.annex-table');

if (AnnexTableWrappers.length > 0) {
    new GMAnnex(AnnexTableWrappers);
}