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
                $('#single').select2({

                });
            });

            this.$wrapper.modal({backdrop: true});
        },

        executeMovement(e) {
           e.preventDefault();
           console.log('clicked!');
            if ($('.js-crotals-move').val() === 0 ){
                console.log('Empty!');
            }
        }
    });

})(window, jQuery);



