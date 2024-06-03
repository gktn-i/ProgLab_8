<?php

if (isset($_GET['storeID'])) {
    $storeID = $_GET['storeID'];
} else {
    echo json_encode("Error: storeID parameter is missing");
    exit();
}

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT p.Category, o.storeID, COUNT(o.orderID) AS orderCount
FROM orderitems oi
JOIN orders o ON oi.orderID = o.orderID
JOIN products p ON oi.SKU = p.SKU
WHERE o.storeID = '$storeID'
GROUP BY p.Category, o.storeID
ORDER BY p.Category, o.storeID";

$result = $mysqli->query($sql);

if ($result) {
    $data = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($data);
} else {
    echo json_encode("Error executing SQL query: " . $mysqli->error);
}

$mysqli->close();

