'use strict';

import AjaxCall from "../shared/AjaxCall";

const swal = require('sweetalert2');
import Race from './Race';
import ValidatorFactory from './ValidatorFactory';

(function(window, $, swal) {

    /**
     * Main Object for Configuration variables
     * @param $raceWrapper
     * @param $tableWrapper
     * @constructor
     */
    window.GMConfiguration= function($raceWrapper, $tableWrapper) {

        this.$raceWrapper = $raceWrapper;
        this.$tableWrapper = $tableWrapper;

        this.$raceWrapper.on(
            'click',
            this._options.forms.add,
            this.handleAddConfiguration.bind(this)
        );


        // Bind on document because table is replaced full
        $(document).on(
            'click',
            this._options.forms.delete,
            this.handleDeleteConfiguration.bind(this)
        );
        this.ajaxCall = new AjaxCall();
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
                delete: '.js-input-delete',
            }
        },

        /**
         * Init Options and Pluggins
         */
        init: function() {
            // Load External pluggins TODO: Fix styles on select 2
            console.log('Loading options...');
        },

        /**
         *
         * @private
         */
        _loadTable: function() {
            //let entries = Object.entries(this.selectors);
            let self = this;
            this.selectors.forEach((instance) => {
                //let url = instance.getLoadUrl();

                /*Next iteration if not exists url*/
                if (!instance.getLoadUrl()) return;

                self.ajaxCall.send(instance.getLoadUrl(), 'GET')
                    .then( (data) => {
                        self.$tableWrapper.replaceWith(data);
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
            this._cleanMarkedErrors();

            let $target = $(e.currentTarget);
            let form = $target.closest('form');
            let url = form.attr('action');
            const type = form.attr('data-validator');
            let validator = this.validatorFactory.create(type);
            if (!validator) return false;
            if (!validator.isValid(form)) {
                this._markErrors(validator.getErrors());
                return;
            }

            form.closest('.box').find('.overlay').removeClass('hidden');

            let data = form.serialize();

            this.ajaxCall.send(url, 'POST', data)
                .then((data) => {
                    if(data.success) {
                        this._cleanInputs();
                        this._fireAlert({type:'success', title:data.message});
                        this._loadTable();

                    } else {
                        this._fireAlert({type:'error', title:data.message});
                    }
                }).catch( (err) => {
                    this._fireAlert({type:'error', title:'Error desconocido'});
            });

            form.closest('.box').find('.overlay').addClass('hidden');
        },

        /**
         *
         */
        handleDeleteConfiguration: function(e) {
            e.preventDefault();
            let $target = $(e.currentTarget);
            let url = $target.attr('href');

            this.ajaxCall.send(url,'POST')
                .then((data) => {
                    if(data.success) {
                        this._fireAlert({type:'success', title:data.message, onClose: () => {
                            let $elementRow = $target.closest('tr');
                            $elementRow.fadeOut('normal', function() {
                                $(this).remove();
                                });
                            }});
                    } else {
                        this._fireAlert({type:'error', title:data.message});
                    }

            }).catch((err) => {
                console.log(err);
                this._fireAlert({type:'error', title:'Error desconocido'});
            });

        },

        /**
         * @param options
         * @private
         */
        _fireAlert: (options) => {
            let defOptions = {
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            };
            swal.fire($.extend(defOptions, options));
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
                   .parent('.form-group')
                   .addClass('has-error');
            });
        },

        /**
         * Clean marked errors
         * @private
         */
        _cleanMarkedErrors: () => {
            $('.has-error').each((index, el) => {
                $(el).removeClass('has-error')
                    .find('.help-block')
                    .addClass('hidden');
            })
        },

        /**
         *
         * @private
         */
        _cleanInputs: function() {
            this.$raceWrapper
                .find('input')
                .val('');
        }
    });

})(window, jQuery, swal);

let raceWrapper = $('.js-box');
let tableWrapper = $('.js-table-conf');

if (raceWrapper.length > 0) {
    new GMConfiguration(raceWrapper, tableWrapper);
}

