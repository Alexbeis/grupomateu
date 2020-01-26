'use strict';

const swal = require('sweetalert2');

(function(window, $, swal) {

    window.GMRegisters = function($wrapper) {

        this.$wrapper = $wrapper;

        this.loadDatatable()
        //this.loadEvents();

    };

    $.extend(window.GMRegisters.prototype, {

        options: {
            _selectors: {
                remove: '.js-remove-explotation',
                add: '.js-add-explotation',
                inputs:['#exp_name', '#exp_code']
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
                bProcessing: true,
                serverSide: true,
                searchDelay: 1000,
                order: [[ 3, "desc" ]],
                ajax: function (data, callback, settings) {
                    let dataSource = '/admin/registros-entrada/paginados/';
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
                    { data: 'procedence', responsivePriority: 2, targets: 1 },
                    { data: 'animalsCount', responsivePriority: 3, targets: 2 },
                    { data: 'createdAt', responsivePriority: -1, targets: 3 },
                    { data: 'createdBy', responsivePriority: -1, targets: 4, orderable: false},
                    { data: 'actions', responsivePriority: -1, targets: 5 , orderable : false},
                ]
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
            element.closest('.form-group').addClass('has-error');
        },

        /**
         *
         * @private
         */
        _cleanErrors:function(){
            this.options._selectors.inputs.forEach((id) => {
                let $id = $(id);
                $id.closest('.form-group').removeClass('has-error');
            });
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


let RegistersTableWrapper = $('#register-table');
//let ModalWrapper = $('#modal-add-explotation');

if (RegistersTableWrapper.length > 0) {
    new GMRegisters(RegistersTableWrapper);
}