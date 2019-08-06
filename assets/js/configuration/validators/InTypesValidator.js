'use strict';

export default class RaceValidator {

    constructor() {
        this.inputs = [
            {name:'intype_code_input', min:0, max:15},
            {name:'intype_name_input', min: 3, max:25}
        ];
        this.errors = [];
    }

    /**
     * Main Validator Method
     * @param form
     * @returns {boolean}
     */
    isValid(form) {
        let $inputs = $(form).find('input');
        if (!$inputs.length) return false;

        $inputs.each((index, element) => {
            let $element = $(element);
            let $id = $element.attr('id');

            // Matching by Id
            let match = this.inputs.filter((input) => {
                return $id === input.name;
            });

            if ($element.val() < match[0].min || $element.val() > match[0].max) {
                this.errors.push(
                    {
                        name: match[0].name,
                        error: `Debe tener entre ${match[0].min} y ${match[0].max} caracteres.`
                    }
                );
            }
        });

        return !this.hasErrors();
    }

    /**
     * Check if errors is not empty
     * @returns {boolean}
     */
    hasErrors() {
        return this.errors.length !== 0;
    }

    /**
     * Get Errors
     * @returns {Array}
     */
    getErrors() {
        if (this.hasErrors()) {
            return this.errors;
        }
    }
}