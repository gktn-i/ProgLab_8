<?php

// Überprüfen, ob die storeIDs gesetzt sind
if (isset($_GET['storeID1']) && isset($_GET['storeID2'])) {
    $storeID1 = $_GET['storeID1'];
    $storeID2 = $_GET['storeID2'];
} else {
    echo json_encode(["error" => "Error: storeID1 or storeID2 parameter is missing"]);
    exit();
}

// Verbindung zur Datenbank herstellen
$mysqli = require __DIR__ . "/database.php";

// SQL-Abfrage vorbereiten
$sql = "SELECT 
            storeID,
            HOUR(orderDate) AS orderHour,
            COUNT(*) AS orderCount
        FROM 
            orders
        WHERE 
            storeID IN (?, ?)
        GROUP BY 
            storeID, 
            HOUR(orderDate)
        ORDER BY 
            storeID, 
            orderHour";

$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    echo json_encode(["error" => "Error preparing SQL query: " . $mysqli->error]);
    exit();
}

// Parameter binden und Abfrage ausführen
$stmt->bind_param("ss", $storeID1, $storeID2);
$stmt->execute();

$result = $stmt->get_result();

if ($result) {
    $data = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($data);
} else {
    echo json_encode(["error" => "Error executing SQL query: " . $mysqli->error]);
}

// Ressourcen freigeben
$stmt->close();
$mysqli->close();

?>
