'use strict';

export default class InType {

    constructor() {
        this.name = 'intype';
        this.add = '#add_intype';
        this.delete = '#delete_intype';
        this.loadurl =  'configuration/in_types/get';
        this.addurl = 'configuration/in_types/add';
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
