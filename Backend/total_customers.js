document.addEventListener("DOMContentLoaded", function() {
    fetch('Backend/total_customers_data.php')
        .then(response => {
            console.log('Response status:', response.status); // Debugging: Ausgabe des Response-Status
            return response.json();
        })
        .then(data => {
            console.log('Data fetched:', data); // Debugging: Ausgabe der Daten in der Konsole

            const labels = data.map(item => item.ABC_Segment);
            const customerCounts = data.map(item => item.Total_Customers);
            const revenues = data.map(item => item.Total_Revenue);

            const ctx1 = document.getElementById('chart1').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Total Customers',
                            data: customerCounts,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Total Revenue',
                            data: revenues,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching the data:', error));
});
