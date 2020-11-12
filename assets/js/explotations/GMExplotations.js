'use strict';

import AjaxCall from "../shared/AjaxCall";
import Spinner from "../shared/Spinner";

const swal = require('sweetalert2');

(function(window, $, swal) {

    window.GMExplotations = function($wrapper, $modalWrapper) {

        this.$wrapper = $wrapper;

        this.$modalWrapper = $modalWrapper;

        this.ajaxCall = new AjaxCall();

        this.$wrapper.on(
            'click',
            this.options._selectors.remove,
            this.handleExplotationDelete.bind(this)
        );

        this.$modalWrapper.on(
            'click',
            this.options._selectors.add,
            this.handleExplotationAdd.bind(this)
        );

        this.loadDatatable()
        this.loadEvents();

    };

    $.extend(window.GMExplotations.prototype, {

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
                "pageLength": 10
            });
        },

        /**
         * Load modal events
         */
        loadEvents: function() {
            $('#modal-add-explotation').on('hidden.bs.modal',  () => {
                this._cleanErrors();
            })
        },

        /**
         * Handle explotation Row on the table
         * @param e
         */
        handleExplotationDelete: function (e) {
            e.preventDefault();
            let target = e.currentTarget;
            this.showAlert(target);
        },

        /**
         * Handle Add Explotation from modal
         * @param e
         */
        handleExplotationAdd: function(e) {
            e.preventDefault();
            let spinner = new Spinner($(e.target));
            spinner.show();
            this._cleanErrors();
            let canSubmit = true;
            let $form = $(e.currentTarget).closest('#add-exp-form');
            this.options._selectors.inputs.forEach((id) => {
                let $id = $(id);
                let value = $id.val();
                if (!this._isValid(value)) {
                    canSubmit = false;
                    this._addError($id)
                }
            });

            if (canSubmit) {
                $form.submit();
            } else {
                spinner.backToInit();
            }
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
                    this.ajaxCall.send(url, 'DELETE')
                    .then(function (data) {
                        if (data.success) {
                            self._fireAlert({
                                title: self.options.text.deleted,
                                text: data.message,
                                type:'success',
                                allowOutsideClick:false,
                                onClose:() => {
                                    self._deleteRow($target);
                                    self.$wrapper.DataTable().draw();
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


let ExplotationsWrapper = $('#explotations-table');
let ModalWrapper = $('#modal-add-explotation');

if (ExplotationsWrapper.length > 0 && ModalWrapper.length > 0) {
    let GM = new GMExplotations(ExplotationsWrapper, ModalWrapper);
}