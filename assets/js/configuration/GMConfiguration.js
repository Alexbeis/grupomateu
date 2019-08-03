'use strict';

const swal = require('sweetalert2');
import Race from './Race';
import ValidatorFactory from './ValidatorFactory';

(function(window, $, swal) {

    /**
     * Main Object for Configuration variables
     * @param $raceWrapper
     * @constructor
     */
    window.GMConfiguration= function($raceWrapper) {

        this.$raceWrapper = $raceWrapper;

        this.$raceWrapper.on(
            'click',
            this._options.forms.add,
            this.handleAddConfiguration.bind(this)
        );

        this.selectors = [new Race()];
        this.validatorFactory = new ValidatorFactory();

        // App Init
        this.init();
    };

    $.extend(window.GMConfiguration.prototype, {

        /**
         * Options needed
         */
        _options: {
            forms: {
                add:'.js-input-add',
                race: {
                    add: '#add_race',
                    delete: '#delete_race',
                    loadurl: 'configuration/races/get',
                    addurl: 'configuration/races/add'
                },
                in: {},
                out:{
                    add: '#add_out',
                    delete: '#delete_out',

                },
                movement:{}
            }
        },

        /**
         * Init Options and Pluggins
         */
        init: function() {
            // Load External pluggins TODO: Fix styles on select 2
            //this._loadAndInitExternalPluggins();
            this._loadOptions();
        },

        /**
         *
         * @private
         */
        _loadAndInitExternalPluggins: function() {
            $('.js-select2').select2({
                tags: "true",
                placeholder: "Select an option",
                allowClear: true
            });
        },

        /**
         *
         * @private
         */
        _loadOptions: function() {

            //let entries = Object.entries(this.selectors);
            let self = this;
            this.selectors.forEach((instance) => {
                //let url = instance.getLoadUrl();

                /*Next iteration if not exists url*/
                if (!instance.getLoadUrl()) return;

                let options = {
                    url: instance.getLoadUrl(),
                    method:'GET'
                };

                self._ajaxCall(options)
                    .then( (data) => {
                        self._addOptionsToSelect(data, $('#' + instance.getName() +'-select'));
                    }).catch((err) => {
                        console.log(err);
                })
            });

        },

        /**
         * Handle form add any configurable parameter.
         * @param e
         */
        handleAddConfiguration: function (e) {
            e.preventDefault();

            let $target = $(e.currentTarget);
            let form = $target.closest('form');
            let url = form.attr('action');
            const type = form.attr('data-validator');
            const validator = this.validatorFactory.create(type);
            if (!validator.isValid(form)) {
                this._markErrors(validator.getErrors());

                return;
            }

            form.closest('.box').find('.overlay').removeClass('hidden');

            let data = form.serialize();
            let options = {
                url:url,
                method: 'POST',
                data: data
            };

            this._ajaxCall(options)
                .then((data) => {
                    if(data.success) {
                        this._fireAlert({type:'success', title:data.message});
                        //this._addoption(data, form.find('select'));
                        // TODO: Replace by loadOptionsByTheme
                        this._loadOptions();
                    } else {
                        this._fireAlert({type:'error', title:data.message});
                    }
                }).catch( (err) => {
                    this._fireAlert({type:'error', title:'Error desconocido'});
            });

            form.closest('.box').find('.overlay').addClass('hidden');


        },

        /**
         * @returns Promise
         * @private
         * @param options
         */
        _ajaxCall: function (options) {
            
            return $.ajax(options)
        },

        /**
         * @param options
         * @private
         */
        _fireAlert:function (options) {
            let defOptions = {
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            };
            swal.fire($.extend(defOptions, options));
        },

        /**
         * @param data
         * @param $element
         * @private
         */
        _addOptionsToSelect: function (data, $element) {

            $element.children().remove();

            for (let i = 0; i < data.length; i++) {
                this._addoption(data[i], $element);
            }
        },

        /**
         * Add Single Option
         * @param data
         * @param $element
         * @private
         */
        _addoption: (data, $element) => {
            $element.append(`<option value="${data.id}">${data.name}</option>`);
        },

        /**
         * Mark errors on input elements
         * @param errors
         * @private
         */
        _markErrors: (errors) => {
            errors.forEach((error) => {
               $('#' + error.name)
                   .next()
                   .html(error.error)
                   .removeClass('hidden')
                   .parent('.form-group').addClass('has-error');
            });
        },

        /**
         * Clean marked errors
         * @private
         */
        _cleanMarkedErrors: () => {

        }
    });

})(window, jQuery, swal);

let raceWrapper = $('.js-box');

if (raceWrapper.length > 0) {
    new GMConfiguration(raceWrapper);
}

