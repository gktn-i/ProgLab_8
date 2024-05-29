<?php
$mysqli = require __DIR__ . "/database.php";

if ($mysqli->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $mysqli->connect_error);
}

$query = "SELECT 
DATE_FORMAT(o.orderDate, '%Y-%m') AS Month,
p.Category,
COUNT(DISTINCT oi.OrderID) AS OrderCount,
SUM(o.total) AS TotalRevenue
FROM 
orders o
JOIN 
orderitems oi ON o.orderID = oi.OrderID
JOIN 
products p ON oi.SKU = p.SKU
GROUP BY 
Month, p.Category
ORDER BY 
Month ASC, p.Category ASC;
";

$result = $mysqli->query($query);

if (!$result) {
    die("Fehler bei der Abfrage: " . $mysqli->error);
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);

$mysqli->close();
