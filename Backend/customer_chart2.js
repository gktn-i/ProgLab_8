document.addEventListener("DOMContentLoaded", function() {
    fetch('Backend/total_customers_data.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Data fetched:', data); // Debugging: Ausgabe der Daten in der Konsole

            const labels = data.map(item => item.ABC_Segment);
            const percentages = data.map(item => item.Percentage_of_Revenue);

            const ctx2 = document.getElementById('chart2').getContext('2d');
            new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Percentage of Revenue',
                        data: percentages,
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 206, 86, 0.8)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return `${labels[tooltipItem.dataIndex]}: ${percentages[tooltipItem.dataIndex]}%`;
                                }
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching the data:', error));
});
