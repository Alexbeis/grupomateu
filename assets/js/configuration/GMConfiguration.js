'use strict';

(function(window, $) {

    window.GMConfiguration= function(wrapper) {

        this.$wrapper = $wrapper;

        //TODO: Bind events

        // App Init
        this.init();
    };

    $.extend(window.GMConfiguration.prototype, {

        _selectors: {
            pluggins:{

            },

        },

        init: function() {
            // Load External pluggins
            this._loadAndInitExternalPluggins();
        },

        _loadAndInitExternalPluggins: function() {
            $("#js-example-basic-single").select2({
                tags: "true",
                placeholder: "Select an option",
                allowClear: true
            });
        }
    });

})(window, jQuery);

let BoxesWrapper = $('#js-example-basic-single');

if (BoxesWrapper.length > 0) {
    let GM = new GMConfiguration(BoxesWrapper);
}

