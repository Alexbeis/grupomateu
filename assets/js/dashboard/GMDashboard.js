'use strict';

import Chart from 'chart.js';

(function(window, $) {

    window.GMDashboard = function($wrapper) {
        this.$wrapper = $wrapper;

        //TODO: Bind events

        // App Init
        this.init();
    };

    $.extend(window.GMDashboard.prototype, {

        _selectors: {
            pluggins:{

            },

        },

        init: function() {
            // Load External pluggins
            this._loadAndInitExternalPluggins();
            this._loadCharts();
        },

        _loadCharts: function() {

            let ctx_razas = $('#razas-chart');
            let ctx_explotaciones = $('#explotaciones-chart');

            let myChart = new Chart(ctx_razas, {
                type: 'doughnut',
                data: {
                    labels: ['Raza1', 'Raza2', 'Raza3'],
                    datasets: [{
                        label: '# de Razas',
                        data: [12, 19, 3],
                        backgroundColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    title: {
                      display: true,
                      text: 'Razas Actuales en las explotaciones'
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                drawBorder: false,
                                display:false
                            },
                            ticks: {
                                display:false
                            }
                        }]
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });

            let myChart2 = new Chart(ctx_explotaciones, {
                type: 'doughnut',
                data: {
                    labels: ['Expl_001', 'Expl_002', 'Expl_003', 'Expl_004', 'Expl_005', 'Expl_006'],
                    datasets: [{
                        label: '# de Razas',
                        data: [12, 19, 3, 5, 9, 10],
                        backgroundColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Explotaciones'
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                drawBorder: false,
                                display: false
                            },
                            ticks: {
                                display:false
                            }
                        }]
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        },

        _loadAndInitExternalPluggins: function() {
            // Make the dashboard widgets sortable Using jquery UI
            $('.connectedSortable').sortable({
                placeholder         : 'sort-highlight',
                connectWith         : '.connectedSortable',
                handle              : '.box-header, .nav-tabs',
                forcePlaceholderSize: true,
                zIndex              : 999999
            });
            $('.connectedSortable .box-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move');

            // jQuery UI sortable for the todo list
            $('.todo-list').sortable({
                placeholder         : 'sort-highlight',
                handle              : '.handle',
                forcePlaceholderSize: true,
                zIndex              : 999999
            });

            /* The todo list plugin */
            $('.todo-list').todoList({
                onCheck  : function () {
                    window.console.log($(this), 'The element has been checked');
                },
                onUnCheck: function () {
                    window.console.log($(this), 'The element has been unchecked');
                }
            });
        }
    });

})(window, jQuery);

let BoxesWrapper = $('.js-boxes');

if (BoxesWrapper.length > 0) {
    let GM = new GMDashboard(BoxesWrapper);
}

