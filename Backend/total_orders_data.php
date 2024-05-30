<?php
header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mysqli = require __DIR__ . "/database.php";

if ($mysqli->connect_errno) {
    echo json_encode(["error" => "Failed to connect to MySQL: " . $mysqli->connect_error]);
    exit();
}

$graph = isset($_GET['graph']) ? $_GET['graph'] : '';

$data = [];
$query = '';

switch ($graph) {
    case 'orders_by_month':
        $query = "
            SELECT DATE_FORMAT(orderDate, '%Y-%m') AS month, COUNT(*) AS total_orders 
            FROM orders 
            GROUP BY month 
            ORDER BY month;
        ";
        break;
    case 'average_order_value_by_month':
        $query = "
            SELECT DATE_FORMAT(orderDate, '%Y-%m') AS month, AVG(total) AS avg_order_value 
            FROM orders 
            GROUP BY month 
            ORDER BY month;
        ";
        break;
    case 'orders_by_store':
        $query = "
            SELECT s.city, COUNT(*) AS total_orders 
            FROM orders o 
            JOIN stores s ON o.storeID = s.storeID 
            GROUP BY s.city 
            ORDER BY total_orders DESC;
        ";
        break;
    case 'orders_by_customer':
        $query = "
            SELECT c.customerID, COUNT(*) AS total_orders 
            FROM orders o 
            JOIN customers c ON o.customerID = c.customerID 
            GROUP BY c.customerID 
            ORDER BY total_orders DESC;
        ";
        break;
    default:
        echo json_encode(["error" => "Invalid graph parameter"]);
        exit();
}

$result = mysqli_query($mysqli, $query);

if (!$result) {
    echo json_encode(["error" => "Query failed: " . $mysqli->error]);
    exit();
}

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
$mysqli->close();
?>
