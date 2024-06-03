<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);
$mysqli = require __DIR__ . "/database.php";
if ($mysqli->connect_errno) {
    echo json_encode(["error" => "Failed to connect to MySQL: " . $mysqli->connect_error]);
    exit();
}

$year = isset($_GET['year']) ? $_GET['year'] : null;

$data = [];

$query1 = "
    SELECT DATE_FORMAT(orderDate, '%Y-%m') AS month, COUNT(*) AS total_orders 
    FROM orders 
    " . ($year !== 'all' ? "WHERE YEAR(orderDate) = '$year'" : "") . "
    GROUP BY month 
    ORDER BY month;
";

$result1 = mysqli_query($mysqli, $query1);
if ($result1) {
    while ($row = mysqli_fetch_assoc($result1)) {
        $data['orders_by_month'][] = $row;
    }
} else {
    $data['orders_by_month'] = ["error" => "Query failed: " . $mysqli->error];
}

// Query for average order value by month
$query2 = "
    SELECT DATE_FORMAT(orderDate, '%Y-%m') AS month, AVG(total) AS avg_order_value 
    FROM orders 
    " . ($year !== 'all' ? "WHERE YEAR(orderDate) = '$year'" : "") . "
    GROUP BY month 
    ORDER BY month;
";

$result2 = mysqli_query($mysqli, $query2);
if ($result2) {
    while ($row = mysqli_fetch_assoc($result2)) {
        $data['average_order_value_by_month'][] = $row;
    }
} else {
    $data['average_order_value_by_month'] = ["error" => "Query failed: " . $mysqli->error];
}

// Query for orders by store
$query3 = "
    SELECT s.city, COUNT(*) AS total_orders 
    FROM orders o 
    JOIN stores s ON o.storeID = s.storeID 
    " . ($year !== 'all' ? "WHERE YEAR(o.orderDate) = '$year'" : "") . "
    GROUP BY s.city 
    ORDER BY total_orders DESC;
";

$result3 = mysqli_query($mysqli, $query3);
if ($result3) {
    while ($row = mysqli_fetch_assoc($result3)) {
        $data['orders_by_store'][] = $row;
    }
} else {
    $data['orders_by_store'] = ["error" => "Query failed: " . $mysqli->error];
}

// Query for pizza distribution
$query4 = "
    SELECT p.Name, COUNT(*) AS total_orders 
    FROM orderitems o 
    JOIN products p ON o.SKU = p.SKU 
    JOIN orders ord ON o.orderID = ord.orderID
    " . ($year !== 'all' ? "WHERE YEAR(ord.orderDate) = '$year'" : "") . "
    GROUP BY p.Name 
    ORDER BY total_orders DESC;
";

$result4 = mysqli_query($mysqli, $query4);
if ($result4) {
    while ($row = mysqli_fetch_assoc($result4)) {
        $data['pizza_distribution'][] = $row;
    }
} else {
    $data['pizza_distribution'] = ["error" => "Query failed: " . $mysqli->error];
}

echo json_encode($data);
$mysqli->close();
