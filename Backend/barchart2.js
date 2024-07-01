document.addEventListener("DOMContentLoaded", function() {
    fetch('Backend/total_customers_data.php')
        .then(response => {
            console.log('Response status:', response.status); // Debugging: Ausgabe des Response-Status
            return response.json();
        })
        .then(data => {
            console.log('Data fetched:', data); // Debugging: Ausgabe der Daten in der Konsoles

            const labels = data.map(item => item.ABC_Segment);
            const customerCounts = data.map(item => item.Total_Customers);


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
