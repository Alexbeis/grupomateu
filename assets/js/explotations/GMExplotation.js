'use strict';

import AjaxCall from "../shared/AjaxCall";
require ('../shared/datatable_extension_custom_filter');

const swal = require('sweetalert2');

(function(window, $, swal) {

    window.GMExplotation = function($wrapperForm, $wrapperTable) {

        this.$wrapperForm = $wrapperForm;
        this.$wrapperTable = $wrapperTable;
        this.$moveAnimalButton = $('.js-move-animal');

        this.ajaxCall = new AjaxCall();

        this.$wrapperForm.on(
            'click',
            this.options._selectors.save,
            this.handleExplotationSave.bind(this)
        );

        this.$moveAnimalButton.on(
            'click',
            this.handleMoveAnimal.bind(this)
        );

        this.loadDatatable()
    };

    $.extend(window.GMExplotation.prototype, {

        options: {
            _selectors: {
                form: '#expl_save_form',
                save: '.js-save-explotation',
                inputs:[
                    {
                        input:'#exp_name',
                        mandatory: true,
                        max: 50,
                        min:3,
                        error: 'Este campo ha de tener valores entre 3 y 10 caracteres '
                    },
                    {
                        input:'#exp_code',
                        mandatory: true,
                        max:10,
                        min:3,
                        error: 'Este campo ha de tener valores entre 3 y 10 caracteres '
                    },
                    {
                        input:'#exp_loca',
                        mandatory: false,
                        max: 50,
                        min:0,
                        error: 'Este campo ha de tener valores entre 3 y 10 caracteres '
                    },

                ]
            }
        },
        errors: {},

        /**
         * Load Datatable data
         */
        loadDatatable: function() {
            let datatable = this.$wrapperTable.DataTable({
                "pageLength": 10,
                "pagingType": "simple",
                'columnDefs': [{
                    'targets': 0,
                    'searchable':false,
                    'orderable':false,
                    'className': 'js-animal-selected',
                    'render': function (data, type, full, meta){
                        return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
                    }
                }],
            });

            $('#min_old, #max_old').keyup( function() {
                datatable.draw();
            });
        },

        /**
         * Handle Save Explotation
         * @param e
         */
        handleExplotationSave: function(e) {
            e.preventDefault();

            var self = this;

            this._cleanErrors();
            let canSubmit = true;
            this.options._selectors.inputs.forEach((obj) => {
                let $id = $(obj.input);
                let value = $id.val();
                if (!this._isValid(value, obj.max, obj.min)) {
                    canSubmit = false;
                    this._addError($id, obj.error)
                }
            });

            if (canSubmit) {
                this._showSpinner();
                var url = this.$wrapperForm.attr('action');
                var data = this.$wrapperForm.serialize();
                this.ajaxCall.send(url, 'POST' ,data)
                    .then(function (data) {
                        if(data.success) {
                           self._fireAlert({type:'success', title:data.message});
                        } else {
                            self._fireAlert({type:'error', title:data.message});
                        }
                        self._hideSpinner();

                }).catch(function (err) {
                    console.log(err);
                    self._hideSpinner();
                })
            }
        },

        handleMoveAnimal: function(e){
            e.preventDefault();
            console.log('Moving animals');
        },

        /**
         *
         * @param value
         * @param max
         * @param min
         * @returns {boolean}
         * @private
         */
        _isValid: function(value, max, min) {

            return value.length <= max && value.length >= min;
        },

        /**
         *
         * @param element
         * @param message
         * @private
         */
        _addError:function(element, message){
            element.closest('.form-group').addClass('has-error');
            element.next('.help-block').html(message).removeClass('hidden');
        },

        /**
         *
         * @private
         */
        _cleanErrors:function(){
            this.options._selectors.inputs.forEach((obj) => {
                let $id = $(obj.input);
                $id.closest('.form-group').removeClass('has-error');
                $id.next('.help-block').html('').addClass('hidden');
            });
        },

        /**
         *
         * @param url
         * @param data
         * @returns promise
         */
        _ajaxSave: function (url, data) {
            return $.ajax(
                {
                    url: url,
                    method:'POST',
                    data: data
                }
            );
        },

        /**
         *
         * @param options
         * @private
         */
        _fireAlert:function (options) {
            let defOptions = {
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500
            };
            swal.fire($.extend(defOptions, options));
        },

        /**
         *
         * @private
         */
        _showSpinner:function () {
            let $button = this.$wrapperForm.find(this.options._selectors.save);
            $button.find('.js-spinner > i').removeClass('hidden');
            $button.attr('disabled', true);
        },

        /**
         *
         * @private
         */
        _hideSpinner: function () {
            let $button = this.$wrapperForm.find(this.options._selectors.save);
            $button.find('.js-spinner > i').addClass('hidden');
            $button.attr('disabled', false);
        }

    });


})(window, jQuery, swal);

let ExplotationWrapperForm = $('#expl_save_form');
let ExplotationAnimalTable = $('#exp-animal-table');

if (ExplotationWrapperForm.length > 0) {
    let GM = new GMExplotation(ExplotationWrapperForm, ExplotationAnimalTable);
}