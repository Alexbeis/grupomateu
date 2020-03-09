'use strict';

const swal = require('sweetalert2');
import AjaxCall from "../shared/AjaxCall";

(function(window, $, swal) {

    window.GMAnnex = function($annexWrapper) {

        this.$wrapper = $annexWrapper;
        this.$pdfButton = $('.js-export-pdf');
        this.ajaxCall = new AjaxCall();
        this.exportPdf = new ExportPdf();

        this.$wrapper.on(
            'click',
            this.options._selectors.remove,
            this.handleAnnexDelete.bind(this)
        );

        this.$pdfButton.on(
            'click',
            this.getAnnexedAndHandleExportPdf.bind(this)
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
                columnDefs: [{
                    targets: 0,
                    searchable: false,
                    orderable: false,
                    className: 'dt-body-center',
                    render: function (data, type, full, meta){
                        return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
                    }
                }],
                pageLength: 10,
                responsive: true
            });
        },

        /**
         * Load modal events
         */
        loadEvents() {
            let that = this;
            $('#select-all').on('click', function(){
                // Get all rows with search applied
                let rows = that.$wrapper.DataTable().rows({ 'search': 'applied' }).nodes();
                // Check/uncheck checkboxes for all rows in the table
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
            });
        },
        /**
         *
         * @param e
         */
        getAnnexedAndHandleExportPdf(e) {
            e.preventDefault();
            let url = $(e.target).attr('href');

            this.exportPdf
                .handleExportPdf(
                    this._extractAnexedIds(),
                    url
                );
        },

        /**
         *
         * @returns {Array}
         * @private
         */
        _extractAnexedIds() {

            let elementsChecked = [];
            this.$wrapper.DataTable().$('input[type="checkbox"]').each((i, element) => {

                if(!$.contains(document, this)){
                    if (!element.checked){
                        return;
                    }
                    elementsChecked.push(
                        $(element)
                            .closest('tr')
                            .attr('id')
                            .split('_')[1]
                    );
                }

            });

            return elementsChecked;
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


})(window, jQuery, swal);

let AnnexTableWrapper = $('#annex-table');

if (AnnexTableWrapper.length > 0) {
    new GMAnnex(AnnexTableWrapper);
}