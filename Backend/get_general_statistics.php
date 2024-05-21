<?php
$mysqli = require __DIR__ . "/database.php";


$query = "SELECT 
            (SELECT COUNT(*) FROM orders) AS totalOrders, 
            (SELECT SUM(total) FROM orders) AS totalRevenue, 
            (SELECT COUNT(*) FROM customers) AS totalCustomers, 
            (SELECT COUNT(*) FROM products) AS totalProducts";

$result = mysqli_query($mysqli, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// JSON 
header('Content-Type: application/json');

echo json_encode($data);

