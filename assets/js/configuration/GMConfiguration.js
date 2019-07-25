'use strict';

(function(window, $) {

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

        _options: {
            forms: {
                race: {
                    add: '#add_race',
                    delete: '#delete_race',
                    loadurl: 'configuration/races/get'
                },
                in: {},
                out:{},
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
            const self = this;
            entries.forEach(function (object) {
                let url = object[1].loadurl;

                /*Next iteration if not exists url*/
                if (!url) return;

                self._ajaxCall(url)
                    .then(function (data) {
                        self._addOptionsToSelect(data, $('#' + object[0]+'-select'));
                    }).catch(function (err) {
                    console.log(err);
                })
            })
        },

        /**
         *
         * @param e
         */
        handleAddConfiguration: function (e) {
            e.preventDefault();
        },

        /**
         *
         * @param url
         * @returns Promise
         * @private
         */
        _ajaxCall: function (url) {
            
            return $.ajax({
                    url: url,
                    method:'GET'
                })
        },

        /**
         *
         * @param data
         * @param $element
         * @private
         */
        _addOptionsToSelect: function (data, $element) {

            for (let i = 0; i < data.length; i++) {
                $element.append('<option value="' + data[i].id +'">' + data[i].name + '</option>');
            }
        }
    });

})(window, jQuery);

let raceWrapper = $('.js-box-race');

if (raceWrapper.length > 0) {
    new GMConfiguration(raceWrapper);
}

