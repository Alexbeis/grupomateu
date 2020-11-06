/**
 * Spinner Functionality: Pass the target where you want to overlap.
 * @param target
 * @constructor
 */
const Spinner = function (target) {
    this.target = target;
    this.clonedTarget = this.target.clone();
    this.spinner = $('<span class="js-spinner">&nbsp;<i class="fa fa-spinner fa-spin"></i></span>');
}

Spinner.prototype.show = function (cb) {
    if (typeof cb === 'function') {
        cb();
    } else {
        this.target
            .find('span')
            .replaceWith(this.spinner);
        this.target
            .addClass('disabled');
    }
};

Spinner.prototype.hideWithSuccess = function(cb) {
    if (typeof cb === 'function') {
        cb();
    }
};

Spinner.prototype.backToInit = function () {
    this.target.replaceWith(this.clonedTarget);
};

export default Spinner;