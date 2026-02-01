document.addEventListener('DOMContentLoaded', function () {
    // Section 2: Revenue Chart - Line chart of total revenue over time

    const revenueCtx = document.getElementById('ordersChart').getContext('2d');

    // Parse revenueByDate data from Blade template
    const revenueByDateRaw = JSON.parse(document.getElementById('revenueByDateData').textContent);
    console.log('revenueByDateRaw:', revenueByDateRaw);

    // Prepare data grouped by date
    const dates = revenueByDateRaw.map(item => item.date);
    const revenue = revenueByDateRaw.map(item => parseFloat(item.total_revenue));

    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Total Revenue',
                data: revenue,
                fill: true,
                backgroundColor: 'rgba(127, 90, 240, 0.4)', // shadcn purple
                borderColor: 'rgba(127, 90, 240, 1)',
                tension: 0.3,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        boxWidth: 12,
                        padding: 10,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                },
                zoom: {
                    pan: {
                        enabled: true,
                        mode: 'x',
                    },
                    zoom: {
                        wheel: {
                            enabled: true,
                        },
                        pinch: {
                            enabled: true
                        },
                        mode: 'x',
                    }
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            },
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'day',
                        tooltipFormat: 'MMM dd, yyyy',
                        displayFormats: {
                            day: 'MMM dd'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Date'
                    },
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Total Revenue'
                    },
                    grid: {
                        borderDash: [3, 3]
                    }
                }
            }
        }
    });
});
