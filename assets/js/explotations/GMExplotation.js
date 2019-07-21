'use strict';

(function(window, $) {

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
                inputs:['#exp_name', '#exp_code', "#exp_loca"]
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

            this._cleanErrors();
            let canSubmit = true;
            this.options._selectors.inputs.forEach((id) => {
                let $id = $(id);
                let value = $id.val();
                if (!this._isValid(value)) {
                    canSubmit = false;
                    this._addError($id)
                }
            });

            if (canSubmit) {
                this.$wrapperForm.submit();
            }
        },
        /**
         *
         * @param value
         * @returns {boolean}
         * @private
         */
        _isValid: function(value) {
            return value.length > 3;
        },

        /**
         *
         * @param element
         * @private
         */
        _addError:function(element){
            element.closest('.form-group').addClass('has-error');
        },

        /**
         *
         * @private
         */
        _cleanErrors:function(){
            this.options._selectors.inputs.forEach((id) => {
                let $id = $(id);
                $id.closest('.form-group').removeClass('has-error');
            });
        },

    });


})(window, jQuery);

let ExplotationWrapperForm = $('#expl_save_form');
let ExplotationAnimalTable = $('#exp-animal-table');

if (ExplotationWrapperForm.length > 0) {
    let GM = new GMExplotation(ExplotationWrapperForm, ExplotationAnimalTable);
}