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
            const itemCounts = data.map(item => item.Total_Items);

            const ctx3 = document.getElementById('chart3').getContext('2d');
            new Chart(ctx3, {
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
                            label: 'Total Items',
                            data: itemCounts,
                            backgroundColor: 'rgba(255, 206, 86, 0.2)',
                            borderColor: 'rgba(255, 206, 86, 1)',
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