'use strict';

const swal = require('sweetalert2');

(function(window, $, swal) {

    window.GMExplotation = function($wrapperForm,$wrapperTable ) {

        this.$wrapperForm = $wrapperForm;
        this.$wrapperTable = $wrapperTable;

        this.$wrapperForm.on(
            'click',
            this.options._selectors.save,
            this.handleExplotationSave.bind(this)
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
            this.$wrapperTable.DataTable({
                "pageLength": 10,
                "pagingType": "simple"
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
                var url = this.$wrapperForm.attr('action');
                var data = this.$wrapperForm.serialize();
                this._ajaxSave(url, data)
                    .then(function (data) {
                        if(data.success) {
                           self._fireAlert({type:'success', title:data.message});
                        } else {
                            self._fireAlert({type:'error', title:data.message});
                        }

                }).catch(function (err) {
                    console.log(err);
                })
            }
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
            let isValid = value.length <= max && value.length >= min;
            console.log(value, isValid);

            return isValid;
        },

        /**
         *
         * @param element
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

        _fireAlert:function (options) {
            let defOptions = {
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500
            };
            swal.fire($.extend(defOptions, options));
        }

    });


})(window, jQuery, swal);

let ExplotationWrapperForm = $('#expl_save_form');
let ExplotationAnimalTable = $('#exp-animal-table');

if (ExplotationWrapperForm.length > 0) {
    let GM = new GMExplotation(ExplotationWrapperForm, ExplotationAnimalTable);
}