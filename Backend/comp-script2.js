$(document).ready(function() {
    async function fetchSizeCount(storeID) {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", `Backend/get_order_size_count_comp.php?storeID=${storeID}`);
            xhr.responseType = "json";
            xhr.onload = function() {
                if (xhr.status === 200) {
                    resolve(xhr.response);
                } else {
                    reject(new Error("Error fetching size count: " + xhr.statusText));
                }
            };
            xhr.onerror = function() {
                reject(new Error("Network error while fetching size count"));
            };
            xhr.send();
        });
    }

    function updateSizeCountChart(store1Data, store2Data) {
        const store1Sizes = store1Data.map(item => item.Size);
        const store1Counts = store1Data.map(item => parseInt(item.orderCount));

        const store2Sizes = store2Data.map(item => item.Size);
        const store2Counts = store2Data.map(item => parseInt(item.orderCount));

        const allSizes = Array.from(new Set([...store1Sizes, ...store2Sizes]));
        const alignedStore1Counts = allSizes.map(size => store1Sizes.includes(size) ? store1Counts[store1Sizes.indexOf(size)] : 0);
        const alignedStore2Counts = allSizes.map(size => store2Sizes.includes(size) ? store2Counts[store2Sizes.indexOf(size)] : 0);

        drawBarChart('sizeCountChart', allSizes, alignedStore1Counts, alignedStore2Counts);
    }

    function drawBarChart(canvasId, labels, store1Data, store2Data) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        
        if (Chart.getChart(ctx)) {
            Chart.getChart(ctx).destroy();
        }

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Store 1',
                        data: store1Data,
                        backgroundColor: 'rgba(75, 192, 192, 0.8)',
                    },
                    {
                        label: 'Store 2',
                        data: store2Data,
                        backgroundColor: 'rgba(153, 102, 255, 0.8)',
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                       
                    }
                }
            }
        });
    }

    async function updateSizeCountOnSelection() {
        const store1Select = document.getElementById('store1Select');
        const store2Select = document.getElementById('store2Select');

        if (store1Select.value && store2Select.value) {
            try {
                const [store1Data, store2Data] = await Promise.all([
                    fetchSizeCount(store1Select.value),
                    fetchSizeCount(store2Select.value)
                ]);
                updateSizeCountChart(store1Data, store2Data);
            } catch (error) {
                console.error("Error fetching size count data for comparison: ", error);
            }
        }
    }

    const store1Select = document.getElementById('store1Select');
    const store2Select = document.getElementById('store2Select');

    store1Select.addEventListener('change', updateSizeCountOnSelection);
    store2Select.addEventListener('change', updateSizeCountOnSelection);

    const ctx = document.getElementById('sizeCountChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [
                {
                    label: 'Store 1',
                    data: [],
                    backgroundColor: 'rgba(75, 192, 192, 0.8)',
                },
                {
                    label: 'Store 2',
                    data: [],
                    backgroundColor: 'rgba(153, 102, 255, 0.8)',
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                title: {
                    display: true,
                   
                }
            }
        }
    });
});
