<?php
// get_total_orders.php

$mysqli = require __DIR__ . "/database.php";

if ($mysqli->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed: " . $mysqli->connect_error]);
    exit;
}

$size = isset($_GET['size']) ? $_GET['size'] : 'Medium';
$query = "SELECT p.Category, COUNT(oi.SKU) AS TotalOrders
          FROM orderitems oi
          JOIN products p ON oi.SKU = p.SKU
          WHERE p.Size = ?
          GROUP BY p.Category";

$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $size);
$stmt->execute();
$result = $stmt->get_result();

$totalOrders = [];
while ($row = $result->fetch_assoc()) {
    $totalOrders[$row['Category']] = $row['TotalOrders'];
}

echo json_encode($totalOrders);

$stmt->close();
$mysqli->close();
?>
