(function () {
    'use-strict';

    const Supression = (function () {

        let elementModal = null;

        /**
         * Add event listeners to element
         * @type {{add: add}}
         */
        const Listener = {
            add: function (element, event, callback) {
                element.addEventListener(event, callback)
            }
        };

        const loadEvents = () => {
            Listener.add(
                document.querySelector('.js-generate-supression'),
                'click',
                (e) => handleGenerateSupression(e)
            );

            /**
             * jQuery needed :(
             */
            $('#modal-supression').on('hidden.bs.modal', cleanErrors);
        };

        const handleGenerateSupression = (e) => {
            e.preventDefault();

            showOrHideSpinner(e.target);
            setElementAsDisabled(e.target);
            cleanErrors();

            let isValid = true;
            let form = null;
            let $target = e.target;

            for ( ; $target && $target !== document; $target = $target.parentNode ) {
                if ($target.tagName ==='FORM') {
                    form = $target;
                    break;
                }
            }

            elementModal.querySelectorAll('.required').forEach((el) => {
               if (el.value.length === 0) {
                   el.parentElement.classList.add('has-error');
                   showOrHideSpinner(e.target);
                   setElementAsEnabled(e.target);
                   isValid = false;
               }
            });

            if (form && isValid) {
                form.submit();
            }
        };

        const showOrHideSpinner = function (el) {

            let $spinner = el.querySelector('.js-spinner');
            console.log($spinner);
            $spinner.childNodes.forEach((element) => {
                if (element.tagName === 'I') {
                    element
                        .classList
                        .toggle('hidden');
                }
            })
        };

        const setElementAsDisabled = function ($element) {
            $element.classList.add('disabled');
        };

        const setElementAsEnabled = function ($element) {
            $element.classList.remove('disabled');
        };

        const cleanErrors = function () {

            elementModal.querySelectorAll('.required').forEach((el) => {
                el.parentElement.classList.remove('has-error');
            });
        };

        return {
            init: (element) => {
                console.log('Hello from Supression');
                elementModal = element;
                loadEvents();
            }
        }
    })();

    let elementModal = document.querySelector('#modal-supression');

    if (elementModal) {
        Supression.init(elementModal);
    }
})();