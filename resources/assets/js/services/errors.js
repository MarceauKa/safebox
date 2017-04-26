export class Errors
{
    constructor(errors = {}) {
        this.errors = errors;
    }

    record(errors) {
        this.errors = errors;
    }

    has(key) {
        return this.errors.hasOwnProperty(key);
    }

    get(key) {
        if (this.has(key)) {
            return this.errors[key][0];
        }
    }

    reset() {
        this.errors = {};
    }

    count() {
        return Object.keys(this.errors).length;
    }
}