<?php
$mysqli = require __DIR__ . "/database.php";

$storeID = $_GET['storeID'];

if (!$storeID) {
    echo json_encode(['error' => 'Store ID not provided']);
    exit;
}

// Fetch orders data
$ordersQuery = "
    SELECT p.Name AS productName, SUM(o.nItems) AS quantitySold 
    FROM orderitems oi 
    JOIN products p ON oi.SKU = p.SKU
    JOIN orders o ON oi.orderID = o.orderID
    WHERE o.storeID = '$storeID' 
    GROUP BY p.Name
";
$ordersResult = mysqli_query($mysqli, $ordersQuery);
$ordersData = [];
while ($row = mysqli_fetch_assoc($ordersResult)) {
    $ordersData[] = $row;
}

// Fetch revenue data
$revenueQuery = "
    SELECT DATE_FORMAT(o.orderDate, '%Y-%m') AS period, SUM(o.total) AS totalRevenue 
    FROM orders o
    WHERE o.storeID = '$storeID'
    GROUP BY period
    ORDER BY period
";
$revenueResult = mysqli_query($mysqli, $revenueQuery);
$revenueData = [];
while ($row = mysqli_fetch_assoc($revenueResult)) {
    $revenueData[] = $row;
}

// Fetch total customers data
$customersQuery = "
    SELECT COUNT(DISTINCT customerID) AS totalCustomers, DATE_FORMAT(orderDate, '%Y-%m') as time 
    FROM orders 
    WHERE storeID = '$storeID'
    GROUP BY time
";
$customersResult = mysqli_query($mysqli, $customersQuery);
$customersData = [];
while ($row = mysqli_fetch_assoc($customersResult)) {
    $customersData[] = $row;
}
// Combine all data into a single response
$response = [
    'orders' => $ordersData,
    'revenue' => $revenueData,
    'customers' => $customersData,
];

header('Content-Type: application/json');
echo json_encode($response);
?>
