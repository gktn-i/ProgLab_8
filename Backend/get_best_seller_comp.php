<?php
// Überprüfen, ob der "storeID"-Schlüssel im $_GET-Array vorhanden ist
if (isset($_GET['storeID'])) {
    // Verbindung zur Datenbank herstellen (Annahme: Verwendung von MySQLi)
    $mysqli = require __DIR__ . "/database.php";

    // Überprüfen, ob die Verbindung erfolgreich hergestellt wurde
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Vorbereiten und Ausführen der SQL-Abfrage unter Verwendung von Prepared Statements
    $sql = "SELECT p.Name, p.SKU, p.Price, p.Category
            FROM (
                SELECT oi.SKU, COUNT(*) AS orderCount
                FROM orderitems oi
                JOIN orders o ON oi.orderID = o.orderID
                WHERE o.storeID = ?
                GROUP BY oi.SKU
                ORDER BY orderCount DESC
                LIMIT 3
            ) AS bestsellers
            JOIN products AS p ON bestsellers.SKU = p.SKU";

    // Vorbereiten der Abfrage
    if ($stmt = $mysqli->prepare($sql)) {
        // Binden des Parameters und Ausführen der Abfrage
        $storeID = $_GET['storeID'];
        $stmt->bind_param("s", $storeID);
        $stmt->execute();

        // Speichern des Abfrageergebnisses
        $result = $stmt->get_result();

        // Konvertieren des Ergebnisses in ein assoziatives Array
        $response = array();
        while ($row = $result->fetch_assoc()) {
            $response[] = $row;
        }

        // Schließen des Prepared Statements
        $stmt->close();

        // Ausgabe des Ergebnisses als JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Fehlerbehandlung bei der Abfragevorbereitung
        echo "Error preparing SQL statement: " . $mysqli->error;
    }

    // Schließen der Datenbankverbindung
    $mysqli->close();
} else {
    // Fehlermeldung, wenn "storeID"-Parameter fehlt
    echo "Error: 'storeID' parameter is missing.";
}
?>