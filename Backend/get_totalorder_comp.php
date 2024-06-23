<?php

if (isset($_GET['storeID'])) {
    // Verbindung zur Datenbank herstellen (Annahme: Verwendung von MySQLi)
    $mysqli = require __DIR__ . "/database.php";

    // Überprüfen, ob die Verbindung erfolgreich hergestellt wurde
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // storeID aus GET-Parametern auslesen
    $storeID = $_GET['storeID'];

    // SQL-Abfrage für die Bestellanzahl eines bestimmten Stores
    $sql = "SELECT COUNT(*) AS orderCount FROM orders WHERE storeID = '$storeID'";

 /*    $sql = "SELECT COUNT(*) AS totalProducts
    FROM orderitems oi
    JOIN orders o ON oi.orderID = o.orderID
    WHERE o.storeID = ?"; */
    
    // Abfrage ausführen
    $result = $mysqli->query($sql);

    if ($result) {
        // Bestellanzahl aus dem Ergebnis extrahieren
        $row = $result->fetch_assoc();
        $orderCount = $row['orderCount'];

        // Bestellanzahl als JSON-Antwort senden
        echo json_encode($orderCount);
    } else {
        // Fehlermeldung als JSON-Antwort senden
        echo json_encode("Error executing SQL query: " . $mysqli->error);
    }

    // Verbindung zur Datenbank schließen
    $mysqli->close();
}
?>
