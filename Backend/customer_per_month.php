<?php
include 'database.php';
$mysqli = require __DIR__ . "/database.php";




// Durchschnittliche Anzahl von Bestellungen pro Monat berechnen
$query = "SELECT 
        DATE_FORMAT(orderDate, '%Y-%m') AS month,
        COUNT(orderID) AS customers_per_month
    FROM orders
    GROUP BY month
    ORDER BY month;
";


$result = $mysqli->query($query);

if (!$result) {
    die("Error in query: $query. " . $mysqli->error);
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}


// Ausgabe der Daten im JSON-Format
header('Content-Type: application/json');
echo json_encode($data);

$mysqli->close();
?>