'use strict';

import RaceValidator from './validators/RaceValidator';
import InTypesValidator from './validators/InTypesValidator';

export default class ValidatorFactory {

    create(type) {
        switch (type) {
            case 'race':
                return new RaceValidator();
                break;
            case 'intype':
                return new InTypesValidator();
                break;
            default:
                console.log('No more validators');
        }
    }
}