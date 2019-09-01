'use strict';

import Chart from 'chart.js';

export default class ChartGenerator {
    generate(element) {
        let ctx = $(element['id']);
        let myChart2 = new Chart(ctx, {
            type: element['type'],
            data: {
                labels: element['labels'],
                datasets: [{
                    data: element['totals'],
                    backgroundColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(201, 244, 189, 1)',
                        'rgba(179, 222, 255, 1)',
                    ],
                    borderColor: [
                        'rgba(255, 255, 255, 1)'
                    ],
                    borderWidth: 3
                }]
            },
            options: {
                title: {
                    display: true,
                    text: element['label']
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
}