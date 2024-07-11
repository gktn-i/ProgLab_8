document.addEventListener("DOMContentLoaded", function() {
    fetch('Backend/total_customers_data.php')
        .then(response => {
            console.log('Response status:', response.status); // Debugging: Ausgabe des Response-Status
            return response.json();
        })
        .then(data => {
            console.log('Data fetched:', data); // Debugging: Ausgabe der Daten in der Konsole

            const labels = data.map(item => item.ABC_Segment);
            const revenues = data.map(item => item.Total_Revenue);

            // Farben für die Balken
            const backgroundColors = [
                'rgba(75, 192, 192, 0.2)', // Grün für A
                'rgba(54, 162, 235, 0.2)', // Blau für B
                'rgba(255, 206, 86, 0.2)'  // Gelb für C
            ];

            const borderColors = [
                'rgba(75, 192, 192, 1)', // Grün für A
                'rgba(54, 162, 235, 1)', // Blau für B
                'rgba(255, 206, 86, 1)'  // Gelb für C
            ];

            const ctx1 = document.getElementById('chart1').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Revenue',
                        data: revenues,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 1
                    }]
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