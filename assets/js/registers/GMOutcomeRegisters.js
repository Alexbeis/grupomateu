'use strict';

const swal = require('sweetalert2');

(function(window, $, swal) {

    window.GMOutcomeRegisters = function($wrapper) {

        this.$wrapper = $wrapper;

        this.loadDatatable();

        this.loadEvents();

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
            /*this.$modalWrapper.on('hidden.bs.modal',  () => {
                this._resetForm();
                this._cleanErrors();
            }) */
        },

        /**
         *
         * @param value
         * @returns {boolean}
         * @private
         */
        _isValid: function(value) {
            return value.length > 3;
        },

        /**
         *
         * @param element
         * @private
         */
        _addError:function(element){
            element
                .closest('.form-group')
                .addClass('has-error');
        },

        /**
         *
         * @private
         */
        _cleanErrors:function(){
            this.options._selectors.inputs.forEach((id) => {
                let $id = $(id);
                $id
                    .closest('.form-group')
                    .removeClass('has-error');
            });
        },

        _resetForm: function() {
            this.$modalWrapper
                .find('form')[0]
                .reset();
        },

        handleIncRegisterDelete: function(e) {
            e.preventDefault();
            console.log(e.target);

        },

        handleCreateNewIncomingRegister: function(e) {
            e.preventDefault();
            this._cleanErrors()
            const $target = e.target;
            const $form = $target.closest('form');
            let valid = true;

            this.options._selectors.inputs.forEach((element) => {
                if ($(element).val().length === 0) {
                    this._addError($(element));
                    valid=false;
                }
            });

            if (valid) {
                $($target).prop('disabled', true);
                $($target).find('.fa-spin').toggleClass('hidden');
                $form.submit();
            }
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
         * @param url
         * @returns promise
         */
        _ajaxDelete: function (url) {
            return $.ajax(
                {
                    url: url,
                    method:'DELETE',
                }
            );
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