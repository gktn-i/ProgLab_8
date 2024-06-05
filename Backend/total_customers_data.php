<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);
$mysqli = require __DIR__ . "/database.php";
if ($mysqli->connect_errno) {
    echo json_encode(["error" => "Failed to connect to MySQL: " .$mysqli->connect_error]);
    exit();
}

$year = isset($_GET['year']) ? $_GET['year'] : null;

$data = [];;

//Total Customers per Month
$query1 = "
    SELECT DATE_FORMAT(o.orderDate, '%Y-%m') AS month, COUNT(DISTINCT o.customerID) AS total_customers 
    FROM orders o 
    " . ($year !== 'all' ? "WHERE YEAR(o.orderDate) = '$year'" : "") . "
    GROUP BY month 
    ORDER BY month;
";

$result1 = mysqli_query($mysqli, $query1);
if ($result1) {
    while ($row = mysqli_fetch_assoc($result1)) {
        $data['total_customers_by_month'][] = $row;
    }
} else {
    $data['total_customers_by_month'] = ["error" => "Query failed: " . $mysqli->error];
}

//Average Customers per Month
$query2 = "
    SELECT DATE_FORMAT(o.orderDate, '%Y-%m') AS month, AVG(customer_count) AS avg_customers 
    FROM (
        SELECT DATE_FORMAT(orderDate, '%Y-%m') AS month, COUNT(DISTINCT customerID) AS customer_count 
        FROM orders 
        " . ($year !== 'all' ? "WHERE YEAR(orderDate) = '$year'" : "") . "
        GROUP BY month
    ) AS subquery 
    GROUP BY month 
    ORDER BY month;
";

$result2 = mysqli_query($mysqli, $query2);
if ($result2) {
    while ($row = mysqli_fetch_assoc($result2)) {
        $data['average_customers_by_month'][] = $row;
    }
} else {
    $data['average_customers_by_month'] = ["error" => "Query failed: " . $mysqli->error];
}


// Customers per Store
$query3 = "
    SELECT s.city, COUNT(DISTINCT o.customerID) AS total_customers 
    FROM orders o 
    JOIN stores s ON o.storeID = s.storeID 
    " . ($year !== 'all' ? "WHERE YEAR(o.orderDate) = '$year'" : "") . "
    GROUP BY s.city 
    ORDER BY total_customers DESC;
";

$result3 = mysqli_query($mysqli, $query3);
if ($result3) {
    while ($row = mysqli_fetch_assoc($result3)) {
        $data['total_customers_by_store'][] = $row;
    }
} else {
    $data['total_customers_by_store'] = ["error" => "Query failed: " . $mysqli->error];
}

// average orders per customer
$query4 = "
    SELECT c.customerID, AVG(order_count) AS avg_orders 
    FROM (
        SELECT o.customerID, COUNT(*) AS order_count 
        FROM orders o 
        " . ($year !== 'all' ? "WHERE YEAR(o.orderDate) = '$year'" : "") . "
        GROUP BY o.customerID
    ) AS subquery
    JOIN customers c ON subquery.customerID = c.customerID 
    GROUP BY c.customerID 
    ORDER BY avg_orders DESC;
";

$result4 = mysqli_query($mysqli, $query4);
if ($result4) {
    while ($row = mysqli_fetch_assoc($result4)) {
        $data['average_orders_per_customer'][] = $row;
    }
} else {
    $data['average_orders_per_customer'] = ["error" => "Query failed: " . $mysqli->error];
}

echo json_encode($data);
$mysqli->close();
