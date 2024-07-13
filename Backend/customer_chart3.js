document.addEventListener("DOMContentLoaded", function() {
    fetch('Backend/total_customers_data.php')
        .then(response => response.json())
        .then(data => {
            console.log(data); // Debugging: Ausgabe der Daten in der Konsole

            const labels = data.map(item => item.ABC_Segment);

            const percentageRevenue = data.map(item => item.Percentage_of_Revenue);
            const percentageCustomers = data.map(item => item.Percentage_of_Customers);
            const percentageItems = data.map(item => item.Percentage_of_Items);

            const ctx3 = document.getElementById('chart3').getContext('2d');
            new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Percentage of Revenue',
                            data: percentageRevenue,
                            backgroundColor: 'rgba(75, 192, 192, 0.5)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Percentage of Customers',
                            data: percentageCustomers,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Percentage of Items ordered',
                            data: percentageItems,
                            backgroundColor: 'rgba(255, 206, 86, 0.5)',
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        x: {
                            stacked: false // Bars are not stacked, but placed side by side
                        },
                        y: {
                            beginAtZero: true,
                            max: 100, // Set the maximum value of the y-axis to 100
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.raw + '%';
                                }
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching the data:', error));
});