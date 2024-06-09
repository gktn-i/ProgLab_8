<?php
// Fehlerberichterstattung aktivieren
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mysqli = require __DIR__ . "/database.php"; // Stelle sicher, dass die Datenbankverbindung korrekt eingebunden ist

$conn = $mysqli;

header('Content-Type: application/json');

if (!isset($_GET['storeID'])) {
    echo json_encode(["error" => "Store-ID nicht angegeben"]);
    exit;
}

$storeID = $_GET['storeID'];

if (!preg_match('/^[a-zA-Z0-9]+$/', $storeID)) {
    echo json_encode(["error" => "Die Store-ID enthält ungültige Zeichen"]);
    exit;
}

// Query, um die Top-Produkte nach Umsatz für einen bestimmten Store abzurufen
$sql = "SELECT products.Name AS productName, SUM(products.Price) * COUNT(orderitems.SKU) as total_revenue
        FROM orders
        JOIN orderitems ON orders.orderID = orderitems.orderID
        JOIN products ON orderitems.SKU = products.SKU
        WHERE orders.storeID = ?
        GROUP BY products.Name
        ORDER BY total_revenue DESC";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(["error" => "Vorbereitung der Abfrage fehlgeschlagen: " . $conn->error]);
    exit;
}

$stmt->bind_param('s', $storeID); // Verwende 's' für eine Zeichenkette

if (!$stmt->execute()) {
    echo json_encode(["error" => "Abfrage konnte nicht ausgeführt werden: " . $stmt->error]);
    exit;
}

$result = $stmt->get_result();

if ($result === false) {
    echo json_encode(["error" => "Abfrage fehlgeschlagen: " . $stmt->error]);
    exit;
}

// Initialisiere ein Array, um die Ergebnisse zu speichern
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Gib die Daten als JSON aus
echo json_encode($data);

// Schließe die Datenbankverbindung
$conn->close();
?>
