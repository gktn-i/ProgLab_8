<?php

$mysqli = require 'database.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

function createOrder($mysqli){

    session_start();

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['error' => 'Benutzer nicht eingeloggt']);
        return;
    }

    //Zurzeit noch hard code bsp pizza_id
    $user_id = $_SESSION['user_id'];
    $restaurant_id = isset($_POST['restaurant_id']) ? intval($_POST['restaurant_id']) : 0;
    $pizza_id = isset($_POST['pizza_id']) ? intval($_POST['pizza_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

    if ($restaurant_id <= 0 || $pizza_id <= 0 || $quantity <= 0) {
        echo json_encode(['error' => 'Fehlende oder ungültige Parameter: restaurant_id, pizza_id, quantity']);
        return;
    }


    //Datenbank
    $sql = "INSERT INTO orders (user_id, restaurant_id, pizza_id, quantity, order_date, status) VALUES (?, ?, ?, ?, NOW(), 'pending')";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('iiii', $user_id, $restaurant_id, $pizza_id, $quantity);

    if ($stmt->execute()) {
        echo json_encode(['success' => 'Bestellung erfolgreich erstellt']);
    } else {
        echo json_encode(['error' => 'Fehler bei der Erstellung der Bestellung: ' . $stmt->error]);
    }
}
