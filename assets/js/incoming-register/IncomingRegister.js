const swal = require('sweetalert2');

(function (swal) {

    'use-strict';

    const incRegister = ( function(){

        const options = {
          elements: {
              table: '#inc-register-animal-table',
              deleteAnimal: '.js-remove-inc-register-animal',
              addAnimal: '.js-add-animal',
              addRegister: '.js-add-incregister',
              spinner: '.js-spinner'
          }
        };

        const showOrHideSpinner = function (el) {
            let $spinner = el.querySelector(options.elements.spinner);
            console.log($spinner);
            $spinner.childNodes.forEach((element) => {
                if (element.tagName === 'I') {
                    element
                        .classList
                        .toggle('hidden');
                }
            })
        };

        const loadDatatable = function(element){

            $(element).DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                },
                "columns": [
                    { "data": "crotal" },
                    { "data": "NumeroInterno" },
                    { "data": "crotalMadre" },
                    { "data": "PesoEntrada" },
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
        };
        const handleAddAnimal = function (e) {
            e.preventDefault();
            const $target = e.target;
            const $form = $target.parentElement;
            let valid = true;

            setElementAsDisabled($target);
            showOrHideSpinner($target);

            for (let element of $form.elements) {
                if (element.type === 'hidden') continue;
                if (element.id==='scanner' && element.value === '') {
                    valid = false;
                    showOrHideSpinner($target);
                    setElementAsEnabled($target)
                }
            }

            if (valid) $form.submit();
        };

        const handleSave = function (e) {
            const $target = e.target;
            showOrHideSpinner($target);
            setElementAsDisabled($target);
        };

        const handleIncRegisterDelete = (e) => {
            e.preventDefault();

            if (e.target.tagName === 'A') {
                $target = e.target;
            } else {
                $target = e.target.parentElement;
            }

            showOrHideSpinner($target);
            setElementAsDisabled($target);

            fetch($target.href, {
                method:'DELETE',
                body: JSON.stringify({animalId: $target.dataset.id, incRegister: $target.dataset.increg })
            }).then((response) => {
               return response.json();
            }).then((data) => {
                showOrHideSpinner($target);
                if (data.success) {
                    deleteRow($target);
                    swal.fire({type:'success', title:'Crotal eliminado con éxito', timer:3000});
                }

            }).catch((err) => {

            });
        };

        const setElementAsDisabled = function ($element) {
            $element.classList.add('disabled');
        };

        const setElementAsEnabled = function ($element) {
            $element.classList.remove('disabled');
        };

        const deleteRow = function ($target) {
            for ( ; $target && $target !== document; $target = $target.parentNode ) {
                if ($target.tagName ==='TR') {
                    console.log('found!');
                    console.log($target);
                    let table = $(options.elements.table).DataTable();
                    table
                        .row($target)
                        .remove()
                        .draw();
                    break;
                }
            }
        };

        /**
         *
         * @param e
         */
        const loadEvents = function (e) {

            /**
             * On Click events to delete animal from current incoming register
             */
            document
                .querySelectorAll(options.elements.deleteAnimal)
                .forEach((element) => {
                    Listener.add(
                        element,
                        'click',
                        (e) => handleIncRegisterDelete(e)
                    )
                }
            );

            /**
             * CLick event for save register
             */
            Listener.add(
                document.querySelector(options.elements.addRegister),
                'click',
                (e) => handleSave(e)
            );

            /**
             * Click event add animal from code bar
             */
            Listener.add(
                document.querySelector(options.elements.addAnimal),
                'click',
                (e) => handleAddAnimal(e)
            )
        };

        /**
         * Add event listeners to element
         * @type {{add: add}}
         */
        const Listener = {
            add: function (element, event, callback) {
                element.addEventListener(event, callback)
            }
        };

        return {
            init : function(element){
                console.log('init...');
                loadDatatable(element);
                loadEvents();

            },
            getOptions:function () {
                return options;
            }
        }
    })();

    let element = document.querySelector(incRegister.getOptions().elements.table);
    if (element) {
        incRegister.init(element);
    }

})(swal);




