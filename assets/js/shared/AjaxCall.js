'use strict';

export default class AjaxCall {

    send(url, method, data = null) {
        return $.ajax({
            url: url,
            method: method,
            data: data
        });
    }
}