<?php
include 'database.php';
$mysqli = require __DIR__ . "/database.php";

// Umsatz pro Kunde berechnen
$query = "SELECT customers.customerID, SUM(orders.total) AS total_spent
          FROM customers
          LEFT JOIN orders ON customers.customerID = orders.customerID
          WHERE orders.total IS NOT NULL
          GROUP BY customers.customerID";

$result = $mysqli->query($query);

if (!$result) {
    die("Error in query: $query. " . $mysqli->error);
}

// Kunden in Segmente einteilen
$segment_A = [];
$segment_B = [];
$segment_C = [];

$total_spent = 0;
while ($row = $result->fetch_assoc()) {
    $total_spent += $row['total_spent'];
}

$target_A = 0.6 * $total_spent;
$target_B = 0.25 * $total_spent;

$result->data_seek(0); // Zurücksetzen des Resultatsatzes, um erneut durchzugehen
while ($row = $result->fetch_assoc()) {
    if ($row['total_spent'] >= $target_A) {
        $segment_A[] = $row;
    } elseif ($row['total_spent'] >= $target_B) {
        $segment_B[] = $row;
    } else {
        $segment_C[] = $row;
    }
}

// Daten für die Visualisierung zurückgeben
$data = [
    'A' => $segment_A,
    'B' => $segment_B,
    'C' => $segment_C
];

// Ausgabe der Kundensegmentdaten im JSON-Format
header('Content-Type: application/json');
echo json_encode($data);

$mysqli->close();
?>