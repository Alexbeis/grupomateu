'use-strict';

import EditState from "../explotations/EditState";
import Spinner from "../shared/Spinner";

import AjaxCall from "../shared/AjaxCall";

const swal = require('sweetalert2');

(function (swal, $) {

     window.OutRegister =  function(outRegisterElement, wrapperForm) {
         this.wrapperTableElement = outRegisterElement;
         this.wrapperForm = wrapperForm;
         this.state = new EditState({'info':false});
         this.ajaxCall = new AjaxCall();
         this.wrapperForm.on(
             'click',
             '.js-save-out-register',
             this.handleSave.bind(this)
         );
         this.wrapperForm.on(
             'click',
             '.js-edit-out-register',
             this.handleEdit.bind(this)
         );
         this.loadEvents();
         this.loadDatatable();
     };

    $.extend(window.OutRegister.prototype, {

        options: {
            elements: {
                table: '#out-register-animal-table',
                deleteAnimal: '.js-remove-inc-register-animal',
                addAnimal: '.js-add-animal',
                saveRegister: '.js-save-out-register',
                spinner: '.js-spinner'
            }
        },

        loadEvents : function(){


        },

        loadDatatable: function () {
            this.wrapperTableElement.DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                },
                "columns": [
                    { "data": "crotal" },
                    { "data": "NumeroInterno" },
                    { "data": "crotalMadre" },
                    { "data": "Edad" },
                    { "data": "Edad(meses)" },
                    { "data": "Acciones" }
                ],
                "columnDefs": [
                    {
                        "targets": [ 3 ],
                        "visible": false,
                        "searchable": false
                    }
                ]
            });
        },

        handleSave : function (e) {
            e.preventDefault();
            if (!this.state.canEditFor('info')) return;

            const spinner = new Spinner($(e.target));
            spinner.show();
            this.wrapperForm.submit();
            /*this.ajaxCall
                .send(
                    '/admin/outgoing-registers/save/',
                    'POST',
                    serialisedForm
                ).then(response => {
                    if (response.success) {
                        spinner.backToInit();
                    } else {
                        spinner.backToInit();
                    }

            }).catch(err => {
                spinner.backToInit();
            });*/
        },

        handleEdit : function (e) {
            e.preventDefault();
            let editableElements = this.wrapperForm.find('.editable');
            let that = this;
            editableElements.each(function(index) {
                if ($(this).prop('disabled')) {
                    $(this).prop('disabled', false);
                    that.state.setStateFor('info', true);
                } else {
                    $(this).prop('disabled', true);
                    that.state.setStateFor('info', false);
                }
            });
        }
    });

})(swal, jQuery);

let element = $('#out-register-animal-table');
let form = $('#add-out-register-form');

if (element.length > 0) {
    new OutRegister(element, form);
}



