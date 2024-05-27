<?php

$mysqli = require __DIR__ . "/database.php";

$storeID = $_GET['storeID'];

// Fetch total revenue data
$revenueQuery = "
    SELECT SUM(o.total) AS totalRevenue 
    FROM orders o
    WHERE o.storeID = '$storeID'
";
$revenueResult = mysqli_query($mysqli, $revenueQuery);
$revenueData = mysqli_fetch_assoc($revenueResult);

// Fetch total orders data
$ordersQuery = "
    SELECT COUNT(*) AS totalOrders 
    FROM orders o
    WHERE o.storeID = '$storeID'
";
$ordersResult = mysqli_query($mysqli, $ordersQuery);
$ordersData = mysqli_fetch_assoc($ordersResult);

// Fetch total customers data
$customersQuery = "
    SELECT COUNT(DISTINCT o.customerID) AS totalCustomers 
    FROM orders o
    WHERE o.storeID = '$storeID'
";
$customersResult = mysqli_query($mysqli, $customersQuery);
$customersData = mysqli_fetch_assoc($customersResult);

// Combine all data into a single response
$response = [
    'totalRevenue' => $revenueData['totalRevenue'],
    'totalOrders' => $ordersData['totalOrders'],
    'totalCustomers' => $customersData['totalCustomers'],
];

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>