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
