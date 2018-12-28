'use strict';

/** Helper class for Errors **/

class Errors {

    constructor(){

        this.errors = {};

    }

    any() {
        return Object.keys(this.errors).length > 0;
    }

    has(field){

        return this.errors.hasOwnProperty(field);
    }

    get(field) {

        if(this.errors[field]) {
            return this.errors[field][0];
        }
    }

    clear(field) {
        delete this.errors[field];
    }

    record(errors) {

        this.errors = errors;
    }

    set(field, error) {
        this.errors[field] = []
        this.errors[field].push(error);
    }
};

module.exports = Errors;