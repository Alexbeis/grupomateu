'use strict';

const swal = require('sweetalert2');

(function(window, $, swal) {

    window.GMExplotations = function($wrapper) {

        this.$wrapper = $wrapper;

        this.$wrapper.on(
            'click',
            '.js-remove-explotation',
            this.handleExplotationDelete.bind(this)
        );

        this.loadDatatable();

    };

    $.extend(window.GMExplotations.prototype, {

        options: {
            _selectors: {
            },
            text:{
                title: "Estás seguro?",
                advice: "You won't be able to revert this!",
                warning: "warning",
                deleted: "Deleted!",
                error: "Error!"
            }
        },

        loadDatatable: function() {
            this.$wrapper.DataTable({
                "pageLength": 10
            });
        },

        /**
         * Handle explotation Row on the table
         * @param e
         */
        handleExplotationDelete: function (e) {
            e.preventDefault();
            let target = e.currentTarget;
            this.showAlert(target);
        },

        /**
         * Delete on the clicked Row from the DOM
         * @param target
         * @private
         */
        _deleteRow: function (target) {
           let $elementRow = target.closest('tr');
            $elementRow.find('.js-spinner > i').removeClass('hidden');
            $elementRow.fadeOut('normal', function() {
                $(this).remove();
            });
        },

        /**
         * Show Sweet Alert. Makes ajax request
         * @param target
         */
        showAlert: function (target) {
            let $target = $(target);
            const url = $target.attr('href');
            const self = this;

            swal.fire({
                title: self.options.text.title,
                text: self.options.text.advice,
                type: self.options.text.warning,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Bórrala'
            }).then((result) => {
                if (result.value) {
                    self._ajaxDelete(url)
                    .then(function (data) {
                        if (data.success) {
                            self._fireAlert({
                                title: self.options.text.deleted,
                                text: data.message,
                                type:'success',
                                allowOutsideClick:false,
                                onClose:() => {
                                    self._deleteRow($target);
                                }
                            })
                        } else {
                            self._fireAlert({
                                title: self.options.text.error,
                                text: data.message,
                                type: 'error',
                                allowOutsideClick:false,
                                });


                        }
                    }).catch(function(err){
                        console.log(err);
                    })

                }
            })
        },
        _ajaxDelete: function (url) {
            return $.ajax(
                {
                    url: url,
                    method:'DELETE',
                }
            );
        },
        _fireAlert:function (options) {
            swal.fire(options);
        }

    });


})(window, jQuery, swal);


let ExplotationsWrapper = $('#explotations-table');

if (ExplotationsWrapper.length > 0) {
    let GM = new GMExplotations(ExplotationsWrapper);
}