'use strict';

export default class Race {

    constructor() {
        this.name = 'race';
        this.add = '#add_race';
        this.delete = '#delete_race';
        this.editurl = 'edit'
        this.loadurl =  'get';
        this.addurl = 'configuration/races/add';
    }

    getName() {
        return this.name;
    }
    getAdd() {
        return this.add;
    }
    getDelete(){
        return this.delete;
    }

    getLoadUrl() {
        return this.loadurl;
    }

    getAddUrl() {
        return this.addurl;
    }
}
