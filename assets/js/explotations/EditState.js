const EditState = function () {
     this.state = {
        'info':false,
        'owner':false
    }
};

EditState.prototype.canEditFor = function (type) {
    if (this.state.hasOwnProperty(type)) {
        return this.state[type];
    }
};

EditState.prototype.setStateFor = function (type, value) {
    if (this.state.hasOwnProperty(type)) {
         this.state[type] = value;
    }
};

export default EditState;