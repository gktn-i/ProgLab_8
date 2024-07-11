document.addEventListener("DOMContentLoaded", function() {
    fetch('Backend/time_data.php')
        .then(response => response.json())
        .then(data => {
            console.log(data); // Debugging: Ausgabe der Daten in der Konsole

            const labels = data.map(item => item.Hour + ':00');
            const customerCounts = data.map(item => item.CustomerCount);

            const ctx = document.getElementById('chart5').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Number of Customers',
                        data: customerCounts,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    scales: {
                        x: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Hour of the Day (5-18 closed)'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Customers'
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.raw + ' customers';
                                }
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching the data:', error));
});