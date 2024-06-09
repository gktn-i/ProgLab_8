<?php
$mysqli = require __DIR__ . "/database.php";

if ($mysqli->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed: " . $mysqli->connect_error]);
    exit;
}

$category = isset($_GET['category']) ? $_GET['category'] : 'all';

if ($category === 'all') {
    $query = "
        SELECT YEAR(o.orderDate) AS Year, COUNT(o.orderID) AS OrdersPerYear
        FROM orders o
        GROUP BY Year
        ORDER BY Year
    ";
} else {
    $query = "
        SELECT YEAR(o.orderDate) AS Year, COUNT(o.orderID) AS OrdersPerYear
        FROM orders o
        JOIN orderitems oi ON o.orderID = oi.orderID
        JOIN products p ON oi.SKU = p.SKU
        WHERE p.Category = ?
        GROUP BY Year
        ORDER BY Year
    ";
}

$stmt = $mysqli->prepare($query);
if (!$stmt) {
    http_response_code(500);
    echo json_encode(["error" => "Failed to prepare SQL statement"]);
    exit;
}

if ($category !== 'all') {
    $stmt->bind_param("s", $category);
}

$result = $stmt->execute();
if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => "Failed to execute SQL query: " . $stmt->error]);
    exit;
}

$result = $stmt->get_result();
$years = [];
$ordersPerYear = [];
while ($row = $result->fetch_assoc()) {
    $years[] = $row['Year'];
    $ordersPerYear[] = $row['OrdersPerYear'];
}

echo json_encode([
    "years" => $years,
    "ordersPerYear" => $ordersPerYear,
]);

$stmt->close();
$mysqli->close();
?>
