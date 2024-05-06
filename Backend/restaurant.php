<?php

$mysqli = require 'database.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';


function fetchAllRestaurants($mysqli)
{
    $sql = "SELECT id, name, address, phone FROM restaurants";
    $result = $mysqli->query($sql);

    $restaurants = [];
    while ($row = $result->fetch_assoc()) {
        $restaurants[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($restaurants);

}

function fetchSingleRestaurant($mysqli, $id)
{
    $restaurantSql = "SELECT id, name, address, phone FROM restaurants WHERE id = ?";
    $stmt = $mysqli->prepare($restaurantSql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $restaurantResult = $stmt->get_result();
    $restaurant = $restaurantResult->fetch_assoc();

    if ($restaurant) {
        $menuSql = "SELECT id, name, description, price FROM menu WHERE restaurant_id = ?";
        $menuStmt = $mysqli->prepare($menuSql);
        $menuStmt->bind_param('i', $id);
        $menuStmt->execute();
        $menuResult = $menuStmt->get_result();

        $menu = [];
        while ($row = $menuResult->fetch_assoc()) {
            $menu[] = $row;
        }

        $restaurant['menu'] = $menu;
        header('Content-Type: application/json');
        echo json_encode($restaurant);
    } else {
        echo json_encode(['error' => 'Restaurant nicht gefunden']);
    }
}

