'use strict';

const swal = require('sweetalert2');

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
            let entries = Object.entries(this._options.forms);
            let self = this;
            entries.forEach(function (object) {
                let url = object[1].loadurl;

                /*Next iteration if not exists url*/
                if (!url) return;

                let options = {
                    url: url,
                    method:'GET'
                };
                self._ajaxCall(options)
                    .then( (data) => {
                        self._addOptionsToSelect(data, $('#' + object[0]+'-select'));
                    }).catch((err) => {
                        console.log(err);
                })
            });
        },

        /**
         *
         * @param e
         */
        handleAddConfiguration: function (e) {
            e.preventDefault();

            let $target = $(e.currentTarget);
            let form = $target.closest('form');
            let url = form.attr('action');
            let data = form.serialize();
            let options = {
                url:url,
                method: 'POST',
                data: data
            }
            this._ajaxCall(options)
                .then((data) => {
                    if(data.success) {
                        this._fireAlert({type:'success', title:data.message});
                    } else {
                        this._fireAlert({type:'error', title:data.message});
                    }
                }).catch( (err) => {
                    this._fireAlert({type:'error', title:'Error desconocido'});
            });


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

            for (let i = 0; i < data.length; i++) {
                this._addoption(data[i], $element);
            }
        },
        _addoption: function (data, $element) {
            $element.append(`<option value="${data.id}">${data.name}</option>`);
        }
    });

})(window, jQuery, swal);

let raceWrapper = $('.js-box-race');

if (raceWrapper.length > 0) {
    new GMConfiguration(raceWrapper);
}

