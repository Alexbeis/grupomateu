'use strict';

import AjaxCall from "../shared/AjaxCall";
import EditState from "./EditState";
import Spinner from "../shared/Spinner";

require ('../shared/datatable_extension_custom_filter');

const swal = require('sweetalert2');



(function(window, $, swal) {

    window.GMExplotation = function($wrapperForm,$ownerWrapperForm ,$wrapperTable) {

        this.state = new EditState({'info':false, 'owner':false});
        this.$wrapperForm = $wrapperForm;
        this.$wrapperTable = $wrapperTable;
        this.$wrapperOwner = $ownerWrapperForm;
        this.editInfoButton = $(this.options._selectors.infoEdit);
        this.editOwnerButton = $(this.options._selectors.ownerEdit);
        this.$moveAnimalButton = $('.js-move-animal');
        this.mover = new GMMover($('#modal-movements'));

        this.ajaxCall = new AjaxCall();

        this.$wrapperForm.on(
            'click',
            this.options._selectors.save,
            this.handleExplotationInfoSave.bind(this)
        );

        this.$wrapperTable.on(
            'click',
            this.options._selectors.annex,
            this.handleAnnexAnimal.bind(this)
        );

        this.$wrapperOwner.on(
            'click',
            this.options._selectors.saveOwner,
            this.handleOwnerSave.bind(this)
        );

        this.$moveAnimalButton.on(
            'click',
            this.handleMoveAnimal.bind(this)
        );

        this.editInfoButton.on('click',
           this.handleEdit.bind(this)
        );

        this.editOwnerButton.on('click',
            this.handleEdit.bind(this)
        );

        this.loadDatatable();
        this.loadEvents();
    };

    $.extend(window.GMExplotation.prototype, {

        options: {
            _selectors: {
                form: '#expl_save_form',
                save: '.js-save-explotation',
                saveOwner: '.js-save-owner',
                annex: '.js-annex-animal',
                infoEdit:'.js-edit-info-exp',
                ownerEdit:'.js-edit-owner-exp',
                info:{
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
                            max:20,
                            min:3,
                            error: 'Este campo ha de tener valores entre 3 y 20 caracteres '
                        },
                        {
                            input:'#exp_loca',
                            mandatory: false,
                            max: 50,
                            min:0,
                            error: 'Este campo ha de tener valores entre 3 y 50 caracteres '
                        },

                    ]
                },
                owner:{
                    inputs:[
                        {
                            input:'#owner_name',
                            mandatory: true,
                            max: 50,
                            min:3,
                            error: 'Este campo ha de tener valores entre 3 y 10 caracteres '
                        },
                        {
                            input:'#owner_code',
                            mandatory: true,
                            max:20,
                            min:3,
                            error: 'Este campo ha de tener valores entre 3 y 20 caracteres '
                        },
                        {
                            input:'#owner_nif',
                            mandatory: true,
                            max: 30,
                            min:1,
                            error: 'Este campo ha de tener valores entre 1 y 30 caracteres '
                        },

                    ]
                }
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

        handleEdit(e) {

            let target = $(e.target);
            let form = target.closest('form');
            let editableElements = form.find('.editable');
            this.toggleEdition(editableElements, target.data('type'));
        },

        handleOwnerSave(e){
            e.preventDefault();

            if (!this.state.canEditFor('owner')) return;

            var self = this;
            this._cleanOwnerErrors();

            let canSubmit = true;
            this.options._selectors.owner.inputs.forEach((obj) => {
                let $id = $(obj.input);
                let value = $id.val();

                if (!this._isValid(value, obj.max, obj.min)) {
                    canSubmit = false;
                    this._addError($id, obj.error)
                }
            });

            if (canSubmit) {
                let $target = $(e.target);
                let url = this.$wrapperOwner.attr('action');
                let data = this.$wrapperOwner.serialize();

                const spinner = new Spinner($target);
                spinner.show();

                let editableElements = this.$wrapperOwner.find('.editable');
                this.ajaxCall.send(url, 'POST' ,data)
                    .then(function (data) {
                        if(data.success) {
                            self._fireAlert({type:'success', title:data.message});
                        } else {
                            self._fireAlert({type:'error', title:data.message});
                        }
                        self.toggleEdition(editableElements, 'owner');
                        spinner.backToInit();

                    }).catch(function (err) {
                    self.toggleEdition(editableElements, 'owner');

                    spinner.backToInit();
                })
            }
        },

        /**
         * Handle Save Explotation
         * @param e
         */
        handleExplotationInfoSave: function(e) {
            e.preventDefault();
            if (!this.state.canEditFor('info')) return;

            var self = this;

            this._cleanInfoErrors();
            let canSubmit = true;
            this.options._selectors.info.inputs.forEach((obj) => {
                let $id = $(obj.input);
                let value = $id.val();
                if (!this._isValid(value, obj.max, obj.min)) {
                    canSubmit = false;
                    this._addError($id, obj.error)
                }
            });

            if (canSubmit) {
                let $target = $(e.target);
                let url = this.$wrapperForm.attr('action');
                let data = this.$wrapperForm.serialize();
                const spinner = new Spinner($target);
                spinner.show();
                let editableElements = this.$wrapperForm.find('.editable');
                this.ajaxCall.send(url, 'POST' ,data)
                    .then(function (data) {
                        if(data.success) {
                            self._fireAlert({type:'success', title:data.message});
                        } else {
                            self._fireAlert({type:'error', title:data.message});
                        }
                        self.toggleEdition(editableElements, 'info');

                        spinner.backToInit();

                }).catch(function (err) {
                    self.toggleEdition(editableElements, 'info');
                    spinner.backToInit();
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
          let url = $target.data('href');

          const spinner = new Spinner($target);
          spinner.show();

          this.ajaxCall
              .send(url, 'POST', {id: id})
              .then((data) => {
                  if (this._processResponse(data, $target)) {
                      spinner.hideWithSuccess((function() {
                          this.target.replaceWith(
                              this.clonedTarget
                                  .removeClass('btn-default')
                                  .addClass('btn-warning disabled')
                          );
                      }).bind(spinner));
                  } else {
                      spinner.backToInit();
                  }
              })
              .catch((err) => {
                  spinner.backToInit();
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
        _cleanInfoErrors:function(){
            this.options._selectors.info.inputs.forEach((obj) => {
                let $id = $(obj.input);
                $id.closest('.form-group').removeClass('has-error');
                $id.next('.help-block').html('').addClass('hidden');
            });
        },

        /**
         *
         * @private
         */
        _cleanOwnerErrors:function(){
            this.options._selectors.owner.inputs.forEach((obj) => {
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

        _processResponse(data, $target) {
            if (data.success) {
                this._fireAlert({type:'success', title:data.message});
                $target
                    .addClass('btn-warning disabled')
                    .removeClass('btn-default');

                return true;

            } else {
                this._fireAlert({type:'error', title:data.message});

                return false;
            }
        },

        toggleEdition(editableElements, type) {
            let that = this;
            editableElements.each(function(index) {
                if ($(this).prop('disabled')) {
                    $(this).prop('disabled', false);
                    that.state.setStateFor(type, true);
                } else {
                    $(this).prop('disabled', true);
                    that.state.setStateFor(type, false);
                }
            });
        }
    });


})(window, jQuery, swal);

let ExplotationWrapperForm = $('#expl_save_form');
let OwnerWrapperForm = $('#owner_save_form ');
let ExplotationAnimalTable = $('#exp-animal-table');

if (ExplotationWrapperForm.length > 0) {
    new GMExplotation(ExplotationWrapperForm, OwnerWrapperForm ,ExplotationAnimalTable);
}