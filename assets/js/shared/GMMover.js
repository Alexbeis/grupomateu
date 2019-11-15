'use strict';

(function(window, $) {

    window.GMMover = function($wrapper) {

        this.$wrapper = $wrapper;
        this.$wrapper.on(
            'click',
            '.js-generate-movement',
            this.executeMovement.bind(this)
        );

    };

    $.extend(window.GMMover.prototype, {

        /**
         * Handle Movement
         * @param e
         */
        handleMove() {
            this._launchModal();
        },

        _launchModal() {

            $('body').on('shown.bs.modal', '.modal', function() {
                $(this).find('select').each(function() {
                    var dropdownParent = $(document.body);
                    if ($(this).parents('.modal.in:first').length !== 0)
                        dropdownParent = $(this).parents('.modal.in:first');
                    $(this).select2({
                        placeholder: "Selecciona uno o varios animales",
                        allowClear: true
                    });
                });
                $('#single').select2();
            });

            this.$wrapper.modal({backdrop: true});
        },

        executeMovement(e) {
            e.preventDefault();
            this._cleanErrors();

            const form = $('#move-animals-form');
            let isValid = true;

            if ($('.js-crotals-move').val().length === 0) {
                this._addError($('#multiple'));
                isValid = false;
            }

            if ($('.js-expl-to').val().length === 0) {
                this._addError($('#single'));
                isValid = false;
            }

            if (isValid) {
                form.submit();
            }
        },
        /**
         *
         * @param element
         * @private
         */
        _addError(element){
            element
                .closest('.form-group')
                .addClass('has-error');
            element
                .siblings('.help-block')
                .removeClass('hidden');
        },

        /**
         *
         * @private
         */
        _cleanErrors(){
            $('select').each((i, obj) => {
                $(obj)
                    .closest('.form-group')
                    .removeClass('has-error');
                $(obj)
                    .siblings('.help-block')
                    .addClass('hidden');
            });
        },
    });

})(window, jQuery);



