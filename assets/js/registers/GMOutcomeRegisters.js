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
            alert: {
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                target:'.modal-content',
            },
            text:{
                validationTitle: "Validar Salida para: %s ? ",
                generationTitle: "Generar Salida para: %s ? ",
                validationAdvice: "Vas a validar una salida de crotales",
                generationAdvice: "Vas a Generar una salida de crotales",
                warning: "warning",
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
                ajax: function (data, callback) {
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
                    { data: 'destination', targets: 1 },
                    { data: 'transport', targets: 2 },
                    { data: 'animalsCount', targets: 3 },
                    { data: 'outDate', responsivePriority: 5, targets: 4 },
                    { data: 'createdAt', targets: 5 },
                    { data: 'createdBy', targets: 6, orderable: false},
                    { data: 'actions', responsivePriority: 3, targets: 7 , orderable : false},
                ]
            });
        },

        /**
         * Load modal events
         */
        loadEvents: function() {
            $('.js-reload-outregister').on('click', this.handleReload.bind(this));
            $(document).on('click', '.js-validate' ,this.handleValidation.bind(this));
            $(document).on('click', '.js-generate' ,this.handleGeneration.bind(this));
        },

        fetchAnnexInfo: function () {
            $('.overlay').toggleClass('hidden');
            this.ajaxCall.send("/admin/marcados/por-explotacion", 'GET' )
                .then((response)=> {
                    if (response.success && response.params.length > 0) {
                        this.infoTableCreator.resetTable();
                        this.infoTableCreator.createSuccessTable(response.params);
                        $('.overlay').toggleClass('hidden');
                    }
            })
        },
        handleGeneration:function(e) {
            e.preventDefault();
            const clickedRow = $(e.target).closest('tr');
            const expCode = clickedRow.attr('id');

            const options = $.extend(this.options.alert, {
                title:this.options.text.generationTitle.replace('%s', expCode),
                type: this.options.text.warning,
                onOpen:() => {
                    const content = swal.getContent();
                    const resultElement = content.querySelector('#validation-results');
                    if (resultElement) {
                        resultElement.innerHTML = '';
                    }
                }
            });

            this.showAlert(expCode, options, (expCode) => {
                $('.overlay').toggleClass('hidden');
                this.ajaxCall.send(
                    '/admin/outgoing-registers/create/',
                    'POST',
                    {expCode}
                    )
                    .then(response => {
                        if (response.success) {
                            clickedRow.fadeOut(1000, ()=>{
                                $(this).remove();
                            });
                            const routeName = `out_register_get.${window.REQUEST_LOCALE}`;
                            window.location.href= window.routing.generate(routeName, {'uuid': response.params.uuid});
                            $('.overlay').toggleClass('hidden');


                        } else {
                            console.log('There was an error:');
                            $('.overlay').toggleClass('hidden');

                        }
                    });
            });
        },

        handleValidation: function(e) {
            e.preventDefault();
            const clickedRow = $(e.target).closest('tr');
            const expCode = clickedRow.attr('id');

            const options = $.extend(this.options.alert, {
                title:this.options.text.validationTitle.replace('%s', expCode),
                type: this.options.text.warning,
                onOpen:() => {
                    const content = swal.getContent();
                    const resultElement = content.querySelector('#validation-results');
                    if (resultElement) {
                        resultElement.innerHTML = '';
                    }
                }
            });

            this.showAlert(expCode, options,(expcode) => {
                $('.overlay').toggleClass('hidden');
                this.ajaxCall
                    .send(
                        '/admin/outgoing-registers/validate/',
                      'GET',
                        {expcode}
                        )
                    .then(response => {
                        if (response.success) {

                            const options = $.extend(this.options.alert, {
                                title:'<strong>Crotales Validados</strong>',
                                html: '<div id="validation-results"></div>',
                                text: this.options.text.validationAdvice,
                                type: response.params.length ? this.options.text.warning : 'success',
                                width:'600px',
                                onOpen: () => {
                                    const content = swal.getContent();
                                    const resultElement = content.querySelector('#validation-results');
                                    if(response.params.length){
                                        response.params.forEach(element => {
                                            let div = document.createElement('div');
                                            div.innerHTML= `<strong>${element}</strong>`;

                                            resultElement.appendChild(div);
                                        });
                                    } else {
                                        let div = document.createElement('div');
                                        div.innerHTML= `<strong>Preparados para salir!</strong>`;
                                        resultElement.appendChild(div);
                                    }
                                },
                                onClose:() => {
                                    const content = swal.getContent();
                                    const resultElement = content.querySelector('#validation-results');
                                    if (resultElement) {
                                        resultElement.innerHTML = '';
                                    }
                                }
                            });

                            this.showAlert(expCode, options)

                        } else {
                          console.log('There was an error:');
                        }

                        $('.overlay').toggleClass('hidden');

                }).catch(err => {
                    console.log(err);
                  $('.overlay').toggleClass('hidden');
                });
          });

        },

        handleReload: function(e) {
            e.preventDefault();
            this.fetchAnnexInfo();
        },

        /**
         * Show Sweet Alert. Makes ajax request
         * @param expCode
         * @param options
         * @param callback
         */
        showAlert: function (expCode, options, callback) {

            swal.fire(options).then((result) => {

                if (result.value && typeof callback === 'function') {
                    callback(expCode);
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