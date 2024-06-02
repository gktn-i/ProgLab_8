<?php
// Verbindung zur Datenbank herstellen
$mysqli = require __DIR__ . "/database.php";

// SQL-Abfrage für die Anzahl der Bestellungen pro Kategorie für jeden Store
$sql = "SELECT p.Category, o.storeID, COUNT(o.orderID) AS orderCount
FROM orderitems oi
JOIN orders o ON oi.orderID = o.orderID
JOIN products p ON oi.SKU = p.SKU
WHERE o.storeID = '$storeID'
GROUP BY p.Category, o.storeID
ORDER BY p.Category, o.storeID";

// Abfrage ausführen
$result = $mysqli->query($sql);

if ($result) {
    // Ergebnisse als JSON-Antwort senden
    $data = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($data);
} else {
    // Fehlermeldung als JSON-Antwort senden
    echo json_encode("Error executing SQL query: " . $mysqli->error);
}

// Verbindung zur Datenbank schließen
$mysqli->close();
?>
