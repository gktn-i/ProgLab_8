<?php
$mysqli = require __DIR__ . "/database.php";

if ($mysqli->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $mysqli->connect_error);
}

if (isset($_GET['storeID1']) && isset($_GET['storeID2'])) {
    $storeID1 = $_GET['storeID1'];
    $storeID2 = $_GET['storeID2'];

    $sql = "SELECT 
                p.Category,
                COUNT(DISTINCT oi.OrderID) AS OrderCount
            FROM 
                orders o
            JOIN 
                orderitems oi ON o.orderID = oi.OrderID
            JOIN 
                products p ON oi.SKU = p.SKU
            WHERE 
                o.storeID = ?
            GROUP BY 
                p.Category
            ORDER BY 
                p.Category ASC";

    $stmt1 = $mysqli->prepare($sql);
    $stmt1->bind_param("i", $storeID1);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $store1Data = $result1->fetch_all(MYSQLI_ASSOC);
    $stmt1->close();

    $stmt2 = $mysqli->prepare($sql);
    $stmt2->bind_param("i", $storeID2);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    $store2Data = $result2->fetch_all(MYSQLI_ASSOC);
    $stmt2->close();

    echo json_encode(array("store1Data" => $store1Data, "store2Data" => $store2Data));
} else {
    echo "Store-IDs nicht gefunden.";
}

$mysqli->close();
?>
