'use strict';

import RaceValidator from './validators/RaceValidator';

export default class ValidatorFactory {

    create(type) {
        switch (type) {
            case 'race':
                return new RaceValidator();
                break;
            default:
                console.log('No more validators');
        }
    }
}