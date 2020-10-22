'use strict';

import PreTableCreator from "./PreTableCreator";
import AjaxCall from "../shared/AjaxCall";

const swal = require('sweetalert2');

(function(window, $, swal) {

    window.GMOutcomeRegisters = function($wrapper) {

        this.$wrapper = $wrapper;
        this.ajaxCall = new AjaxCall();
        this.infoTableCreator = new PreTableCreator('#info-annex-table');

        this.loadDatatable();

        this.loadEvents();

        this.fetchAnnexInfo();
    };

    $.extend(window.GMOutcomeRegisters.prototype, {

        options: {
            _selectors: {
                remove: '.js-remove-inc-register',
                new: '.js-create-incregister',
                inputs:['#inc_reg_explotation', '#inc_reg_procedence', '#inc_reg_intype', '#inc_reg_supplier']
            },
            text:{
                title: "Estás seguro?",
                advice: "You won't be able to revert this!",
                warning: "warning",
                deleted: "Deleted!",
                error: "Error!"
            }
        },
        errors: {},

        /**
         * Load Datatable data
         */
        loadDatatable: function() {
            this.$wrapper.DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                },
                bProcessing: true,
                serverSide: true,
                searchDelay: 1000,
                order: [[ 4, "desc" ]],
                ajax: function (data, callback, settings) {
                    let dataSource = '/admin/registros-salida/paginados/';
                    $.post(dataSource, data, function (rdata) {
                        callback({
                            "draw":data.draw,
                            "data": rdata.data,
                            "recordsTotal": rdata.recordsTotal,
                            "recordsFiltered": rdata.recordsFiltered
                        });
                    }, 'json');
                },
                pageLength: 10,
                responsive: true,
                columnDefs: [
                    { data: 'type',responsivePriority: 1, targets: 0 },
                    { data: 'destination', responsivePriority: 2, targets: 1 },
                    { data: 'transport', responsivePriority: 2, targets: 2 },
                    { data: 'animalsCount', responsivePriority: 3, targets: 3 },
                    { data: 'outDate', responsivePriority: 3, targets: 4 },
                    { data: 'createdAt', responsivePriority: -1, targets: 5 },
                    { data: 'createdBy', responsivePriority: -1, targets: 6, orderable: false},
                    { data: 'actions', responsivePriority: -1, targets: 7 , orderable : false},
                ]
            });
        },

        /**
         * Load modal events
         */
        loadEvents: function() {
            $('.js-reload-outregister').on('click', this.handleReload.bind(this));
        },

        fetchAnnexInfo: function () {
            $('.overlay').toggleClass('hidden');
            this.ajaxCall.send("/admin/marcados/por-explotacion", 'GET', )
                .then((response)=> {
                    if (response.success && response.params.length > 0) {
                        this.infoTableCreator.resetTable();
                        this.infoTableCreator.createSuccessTable(response.params);
                        $('.overlay').toggleClass('hidden');
                    }
            })
        },

        handleReload: function(e) {
            e.preventDefault();
            this.fetchAnnexInfo();
        },

        /**
         * Delete on the clicked Row from the DOM
         * @param target
         * @private
         */
        _deleteRow: function (target) {
            let $elementRow = target.closest('tr');
            $elementRow.find('.js-spinner > i').removeClass('hidden');
            $elementRow.fadeOut('normal', function() {
                $(this).remove();
            });
        },

        /**
         * Show Sweet Alert. Makes ajax request
         * @param target
         */
        showAlert: function (target) {
            let $target = $(target);
            const url = $target.attr('href');
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
                    self._ajaxDelete(url)
                        .then(function (data) {
                            if (data.success) {
                                self._fireAlert({
                                    title: self.options.text.deleted,
                                    text: data.message,
                                    type:'success',
                                    allowOutsideClick:false,
                                    onClose:() => {
                                        self._deleteRow($target);
                                    }
                                })
                            } else {
                                self._fireAlert({
                                    title: self.options.text.error,
                                    text: data.message,
                                    type: 'error',
                                    allowOutsideClick:false,
                                });


                            }
                        }).catch(function(err){
                        console.log(err);
                    })

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
        }

    });


})(window, jQuery, swal);

let RegistersTableWrapper = $('#out-register-table');

if (RegistersTableWrapper.length > 0) {
    new GMOutcomeRegisters(RegistersTableWrapper);
}