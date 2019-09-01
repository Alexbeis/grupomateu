

import AjaxCall from "../shared/AjaxCall";
import ChartGenerator from "../shared/ChartGenerator";

(function(window, $) {

    'use strict';

    window.GMStatistics = function() {
        this.ajaxCall = new AjaxCall;
        this.chartGenerator = new ChartGenerator();
    };

    $.extend(window.GMStatistics.prototype, {

        _data:[],

        /**
         * Load Chart
         */
        loadCharts: function() {
            this._getData();
        },

        /**
         * Get Data Json
         * @private
         */
        _getData: function() {
            this.ajaxCall
                .send('animals/statistics', 'POST')
                .then((data) => {
                    if (data.success) {
                        data.params.forEach((el) => {
                            this._data.push(el);
                        });

                        this._generateCharts();
                    }
                })
        },

        /**
         * Generate Charts by given data.
         * @private
         */
        _generateCharts: function () {
            this._data.forEach((element) => {
                this.chartGenerator.generate(element)
            });
        }
    });

})(window, jQuery);


