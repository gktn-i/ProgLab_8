<?php
include 'database.php'; // Verbindung zur Datenbank herstellen
$mysqli = require __DIR__ . "/database.php"; // Beispiel für die Verbindung



$query = "
    SELECT storeID, AVG(nItems) AS avg_customers
    FROM orders
    GROUP BY storeID
";

$result = mysqli_query($mysqli, $query);

$data = []; // Array für die gesendeten Daten vorbereiten

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data['average_customers_per_store'][] = $row;
    }
} else {
    $data['average_customers_per_store'] = ["error" => "Query failed: " . $mysqli->error];
}

// Daten als JSON kodieren
$json_data = json_encode($data);

// Ausgabe der Daten im JSON-Format
header('Content-Type: application/json');
echo $json_data;

// Verbindung zur Datenbank schließen
mysqli_close($mysqli);
?>
