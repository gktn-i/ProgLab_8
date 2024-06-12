document.addEventListener('DOMContentLoaded', function() {
    fetch('customer_segments.php')
        .then(response => response.json())
        .then(data => {
            createChart(data);
        })
        .catch(error => console.error('Error fetching data:', error));
});

function createChart(data) {
    const ctx = document.getElementById('customerChart').getContext('2d');

    const labels = Object.keys(data);
    const values = Object.values(data).map(segment => segment.length);

    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Customer Segments',
                data: values,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
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
}