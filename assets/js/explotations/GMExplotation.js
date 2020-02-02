'use strict';

import AjaxCall from "../shared/AjaxCall";

require ('../shared/datatable_extension_custom_filter');

const swal = require('sweetalert2');



(function(window, $, swal) {

    window.GMExplotation = function($wrapperForm, $wrapperTable) {

        this.$wrapperForm = $wrapperForm;
        this.$wrapperTable = $wrapperTable;
        this.$moveAnimalButton = $('.js-move-animal');
        this.mover = new GMMover($('#modal-movements'));

        this.ajaxCall = new AjaxCall();

        this.$wrapperForm.on(
            'click',
            this.options._selectors.save,
            this.handleExplotationSave.bind(this)
        );

        this.$wrapperTable.on(
            'click',
            this.options._selectors.annex,
            this.handleAnnexAnimal.bind(this)
        );

        this.$moveAnimalButton.on(
            'click',
            this.handleMoveAnimal.bind(this)
        );

        this.loadDatatable();
        this.loadEvents();
    };

    $.extend(window.GMExplotation.prototype, {

        options: {
            _selectors: {
                form: '#expl_save_form',
                save: '.js-save-explotation',
                annex: '.js-annex-animal',
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
            this.$wrapperTable.dataTable({
                "pageLength": 10,
                "pagingType": "simple",
                'columnDefs': [{
                    'targets': 0,
                    'searchable':true,
                    'orderable':true,
                    'className': 'js-animal-selected'
                }],
            });
        },

        /**
         * Tooltip and datatables events
         */
        loadEvents() {
            $('#min_old, #max_old').keyup( () => {
                this.$wrapperTable.DataTable().draw();
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
            this.mover.handleMove();
        },

        handleAnnexAnimal: function(e) {
          e.preventDefault();
          let $target = $(e.currentTarget);
          let id = $target.data('id');
          let url = $target.attr('href');
          const $spinner = $target.find('.js-spinner > i');
          $spinner.removeClass('hidden');
          this.ajaxCall
              .send(url, 'POST', {id: id})
              .then((data) => {
                  this._processResponse(data, $target);
                  $spinner.addClass('hidden');
              })
              .catch((err) => {
                  $spinner.addClass('hidden');
            });

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
            element
                .closest('.form-group')
                .addClass('has-error');
            element
                .next('.help-block')
                .html(message)
                .removeClass('hidden');
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
        },

        _processResponse(data, $target) {
            if (data.success) {
                this._fireAlert({type:'success', title:data.message});
                $target
                    .addClass('btn-warning disabled')
                    .removeClass('btn-default')
                    .text('Anexado');

            } else {
                this._fireAlert({type:'error', title:data.message});
            }
        }
    });


})(window, jQuery, swal);

let ExplotationWrapperForm = $('#expl_save_form');
let ExplotationAnimalTable = $('#exp-animal-table');

if (ExplotationWrapperForm.length > 0) {
    new GMExplotation(ExplotationWrapperForm, ExplotationAnimalTable);
}