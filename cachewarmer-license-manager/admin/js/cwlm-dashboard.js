/**
 * CacheWarmer License Manager – Dashboard Charts (Chart.js)
 */
(function ($) {
    'use strict';

    $(document).ready(function () {
        // Tier Distribution (Donut)
        var tierCtx = document.getElementById('cwlm-chart-tiers');
        if (tierCtx && typeof Chart !== 'undefined') {
            new Chart(tierCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Free', 'Professional', 'Enterprise', 'Development'],
                    datasets: [{
                        data: window.cwlmChartData?.tiers || [0, 0, 0, 0],
                        backgroundColor: ['#6c757d', '#007bff', '#28a745', '#6f42c1'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        }

        // Platform Distribution (Bar)
        var platformCtx = document.getElementById('cwlm-chart-platforms');
        if (platformCtx && typeof Chart !== 'undefined') {
            new Chart(platformCtx, {
                type: 'bar',
                data: {
                    labels: ['Node.js', 'Docker', 'WordPress', 'Drupal'],
                    datasets: [{
                        label: 'Installationen',
                        data: window.cwlmChartData?.platforms || [0, 0, 0, 0],
                        backgroundColor: ['#339933', '#2496ED', '#21759B', '#0678BE'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 } }
                    }
                }
            });
        }

        // Activations Over Time (Line)
        var timeCtx = document.getElementById('cwlm-chart-timeline');
        if (timeCtx && typeof Chart !== 'undefined') {
            new Chart(timeCtx, {
                type: 'line',
                data: {
                    labels: window.cwlmChartData?.timeline?.labels || [],
                    datasets: [{
                        label: 'Neue Aktivierungen',
                        data: window.cwlmChartData?.timeline?.data || [],
                        borderColor: '#667eea',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        fill: true,
                        tension: 0.3,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 } }
                    }
                }
            });
        }
    });
})(jQuery);
