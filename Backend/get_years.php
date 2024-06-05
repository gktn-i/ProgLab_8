<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$mysqli = require __DIR__ . "/database.php";

if ($mysqli->connect_error) {
    http_response_code(500); 
    echo json_encode(["error" => "Database connection failed: " . $mysqli->connect_error]);
    exit;
}

$query = "SELECT DISTINCT YEAR(orderDate) AS year FROM orders ORDER BY year ASC";

$result = $mysqli->query($query);

if (!$result) {
    http_response_code(500); 
    echo json_encode(["error" => "Failed to execute query"]);
    exit;
}

$years = [];
while ($row = $result->fetch_assoc()) {
    $years[] = $row['year'];
}

echo json_encode($years);

$mysqli->close();
?>
