<?php

// Überprüfen, ob die storeIDs gesetzt sind
if (isset($_GET['storeID1']) && isset($_GET['storeID2'])) {
    $storeID1 = $_GET['storeID1'];
    $storeID2 = $_GET['storeID2'];
} else {
    header('Content-Type: application/json');
    echo json_encode(["error" => "Error: storeID1 or storeID2 parameter is missing"]);
    exit();
}

// Verbindung zur Datenbank herstellen
$mysqli = require __DIR__ . "/database.php";

// SQL-Abfrage vorbereiten
$sql = "SELECT o.storeID, p.Category, SUM(o.total) as total_amount
        FROM orders o
        JOIN orderitems oi ON o.orderID = oi.orderID
        JOIN products p ON oi.SKU = p.SKU
        WHERE o.storeID IN (?, ?)
        GROUP BY o.storeID, p.Category
        ORDER BY o.storeID, total_amount DESC";

$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode(["error" => "Error preparing SQL query: " . $mysqli->error]);
    exit();
}

// Parameter binden und Abfrage ausführen
$stmt->bind_param("ss", $storeID1, $storeID2);
$stmt->execute();

$result = $stmt->get_result();

if ($result) {
    $data = $result->fetch_all(MYSQLI_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    header('Content-Type: application/json');
    echo json_encode(["error" => "Error executing SQL query: " . $mysqli->error]);
}

// Ressourcen freigeben
$stmt->close();
$mysqli->close();

?>
