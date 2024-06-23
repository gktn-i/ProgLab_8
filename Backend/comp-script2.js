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

    function updateOrderTimeChart(storeID1, storeID2) {
        fetch(`Backend/get_ordertime_comp.php?storeID1=${storeID1}&storeID2=${storeID2}`)
            .then(response => response.json())
            .then(data => {
                var store1Data = new Array(24).fill(0);
                var store2Data = new Array(24).fill(0);

                data.forEach(function(row) {
                    if (row.storeID === storeID1) {
                        store1Data[row.orderHour] = row.orderCount;
                    } else if (row.storeID === storeID2) {
                        store2Data[row.orderHour] = row.orderCount;
                    }
                });

                drawOrderTimeChart('ordertimeChart', store1Data, store2Data);
            })
            .catch(error => console.error('Error fetching order time data:', error));
    }

    function drawOrderTimeChart(canvasId, store1Data, store2Data) {
        const ctx = document.getElementById(canvasId).getContext('2d');

        if (Chart.getChart(ctx)) {
            Chart.getChart(ctx).destroy();
        }

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [...Array(24).keys()], // Stunden von 0 bis 23
                datasets: [
                    {
                        label: 'Store 1',
                        data: store1Data,
                        backgroundColor: 'rgba(75, 192, 192, 0.5)'
                    },
                    {
                        label: 'Store 2',
                        data: store2Data,
                        backgroundColor: 'rgba(153, 102, 255, 0.5)'
                    }
                ]
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Hours'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Orders'
                        }
                    }
                }
            }
        });
    }

    async function updateChartsOnSelection() {
        const store1Select = document.getElementById('store1Select');
        const store2Select = document.getElementById('store2Select');

        if (store1Select.value && store2Select.value) {
            try {
                const [store1SizeData, store2SizeData] = await Promise.all([
                    fetchSizeCount(store1Select.value),
                    fetchSizeCount(store2Select.value)
                ]);
                updateSizeCountChart(store1SizeData, store2SizeData);

                updateOrderTimeChart(store1Select.value, store2Select.value);
            } catch (error) {
                console.error("Error updating charts on selection: ", error);
            }
        }
    }

    const store1Select = document.getElementById('store1Select');
    const store2Select = document.getElementById('store2Select');

    store1Select.addEventListener('change', updateChartsOnSelection);
    store2Select.addEventListener('change', updateChartsOnSelection);

    const sizeCountCtx = document.getElementById('sizeCountChart').getContext('2d');
    new Chart(sizeCountCtx, {
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

    const ordertimeCtx = document.getElementById('ordertimeChart').getContext('2d');
    new Chart(ordertimeCtx, {
        type: 'bar',
        data: {
            labels: [...Array(24).keys()], 
            datasets: [
                {
                    label: 'Store 1 ',
                    data: [],
                    backgroundColor: 'rgba(75, 192, 192, 0.5)'
                },
                {
                    label: 'Store 2 ',
                    data: [],
                    backgroundColor: 'rgba(153, 102, 255, 0.5)'
                }
            ]
        },
        options: {
            scales: {
                x: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Hour'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Orders'
                    }
                }
            }
        }
    });

    if (store1Select.value && store2Select.value) {
        updateChartsOnSelection();
    }
});
