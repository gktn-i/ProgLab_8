<?php
include 'database.php';
$mysqli = require __DIR__ . "/database.php";




// Durchschnittliche Anzahl von Bestellungen pro Monat berechnen
$query = "
    SELECT s.city, COUNT(c.customerID) AS total_customers
FROM stores s
LEFT JOIN orders o ON s.storeID = o.storeID
LEFT JOIN customers c ON o.customerID = c.customerID
GROUP BY s.city
ORDER BY total_customers DESC;
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
