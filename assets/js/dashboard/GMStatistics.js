'use strict';

import Chart from 'chart.js';
import AjaxCall from "../shared/AjaxCall";

(function(window, $, Chart) {

    window.GMStatistics = function($wrapper) {
        this.$wrapper = $wrapper;
    };

    $.extend(window.GMStatistics.prototype, {

        _selectors: [],

        loadCharts: () => {

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
                        borderWidth: 3
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
                        text: 'Explotaciones con Animales'
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
        }
    });

})(window, jQuery, Chart);


