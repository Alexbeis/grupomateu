'use strict';

(function(window, $) {

    window.GMHistory = function($wrapper) {

        this.$wrapper = $wrapper;

        this.$wrapper.on(
            'click',
            this.options._selectors.save,
            this.handleHistorySave.bind(this)
        );


        this.loadEvents();
    };

    $.extend(window.GMHistory.prototype, {

        options: {
            _selectors: {
                form: '#history-form',
                save: '.js-save-history',
                inputs:[
                    {
                        input:'#history-area',
                        mandatory: true,
                        max: 500,
                        min:3,
                        error: 'Este campo ha de tener valores entre 3 y 500 caracteres '
                    },
                ]
            }
        },
        errors: {},

        /**
         * Handle Save GROUP
         * @param e
         */
        handleHistorySave: function(e) {
            e.preventDefault();
            let $form = this.$wrapper.find('form');
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
            console.log(canSubmit);
            if (canSubmit) {
                $form.submit();
            }
        },

        /**
         * Load modal events
         */
        loadEvents() {
            let url = document.location.toString();
            if (url.match('#')) {
                $('.nav-tabs-custom a[href="#' + url.split('#')[1] + '"]').tab('show');
            }

            $('.nav-tabs-custom a').on('show.bs.tab', function (e) {
                window.location.hash = e.target.hash;
                window.scrollTo(0, 0);
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
                $id
                    .closest('.form-group')
                    .removeClass('has-error');
                $id
                    .next('.help-block')
                    .html('')
                    .addClass('hidden');
            });
        },

        /**
         *
         * @private
         */
        _showSpinner:function () {
            let $button = this.$wrapper.find(this.options._selectors.save);
            $button
                .find('.js-spinner > i')
                .removeClass('hidden')
                .attr('disabled', true);
        },

        /**
         *
         * @private
         */
        _hideSpinner: function () {
            let $button = this.$wrapper.find(this.options._selectors.save);
            $button
                .find('.js-spinner > i')
                .addClass('hidden')
                .attr('disabled', false);
        }
    });

})(window, jQuery);

let $wrapper = $('#animal-history-tab');

if ($wrapper.length > 0) {
    new GMHistory($wrapper);
}
