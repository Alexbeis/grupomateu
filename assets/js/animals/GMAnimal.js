'use strict';

(function(window, $) {

    window.GMAnimal = function($wrapper) {

        this.$wrapper = $wrapper;

        this.$wrapper.on(
            'click',
            this.options._selectors.save,
            this.handleInfoSave.bind(this)
        );


        this.loadEvents();
    };

    $.extend(window.GMAnimal.prototype, {

        options: {
            _selectors: {
                form: '#animal-form',
                save: '.js-save-animal',
                inputs:[
                    {
                        input:'#group_name',
                        mandatory: true,
                        max: 50,
                        min:3,
                        error: 'Este campo ha de tener valores entre 3 y 10 caracteres '
                    },
                    {
                        input:'#group_code',
                        mandatory: true,
                        max:10,
                        min:3,
                        error: 'Este campo ha de tener valores entre 3 y 10 caracteres '
                    },
                ]
            }
        },
        errors: {},

        /**
         * Handle Save GROUP
         * @param e
         */
        handleInfoSave: function(e) {
            e.preventDefault();

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
                this.$wrapper.submit();
            }
        },

        /**
         * Load modal events
         */
        loadEvents: function() {

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

                $("html, body").animate({ scrollTop: 0 }, "slow");
                return false;
            });

            $('.tab-link-js').on('click', function (e){
                window.location.hash = e.target.hash;
            });

            const url = document.location.toString();
            if (url.match('#')) {
                $('.nav-tabs-custom a[href="#' + url.split('#')[1] + '"]').tab('show');
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

let $wrapper = $('#animal-tabs');

if ($wrapper.length > 0) {
    new GMAnimal($wrapper);
}
