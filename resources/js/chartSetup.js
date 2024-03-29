document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('insightsChart').getContext('2d');

    const insightsData = window.insightsData;

    const dates = insightsData.map(data => data.date).reverse();
    const mobileScores = insightsData.map(data => data.mobile_score * 100).reverse();
    const desktopScores = insightsData.map(data => data.desktop_score * 100).reverse();

    const insightsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [
                {
                    label: '',
                    data: mobileScores,
                    borderColor: 'rgb(0, 123, 255, 1)',
                    backgroundColor: 'rgb(0, 123, 255)',
                    showLine: true,
                    fill: false,
                },
                {
                    label: '',
                    data: desktopScores,
                    borderColor: 'rgb(102, 176, 255, 1)',
                    backgroundColor: 'rgb(102, 176, 255)',
                    showLine: true,
                    fill: false,
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: 100
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                annotation: {
                    annotations: {
                        redBox: {
                            type: 'box',
                            yMin: 0,
                            yMax: 50,
                            backgroundColor: 'rgba(255, 0, 0, 0.2)',
                            borderWidth: 0,
                        },
                        orangeBox: {
                            type: 'box',
                            yMin: 50,
                            yMax: 90,
                            backgroundColor: 'rgba(255, 165, 0, 0.2)',
                            borderWidth: 0,
                        },
                        greenBox: {
                            type: 'box',
                            yMin: 90,
                            yMax: 100,
                            backgroundColor: 'rgba(0, 128, 0, 0.2)',
                            borderWidth: 0,
                        }
                    }
                }
            }
        }
    });
});
