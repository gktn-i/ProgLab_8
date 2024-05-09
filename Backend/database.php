<?php
# Datenbank Name login_db
# folgende CSV Dateien sind in der DB:
# customers, products, stores, user


$host = "localhost";
$dbname = "login_db";
$username = "root";
$password = "";

$mysqli = new mysqli(
    hostname: $host,
    username: $username,
    password: $password,
    database: $dbname,
);

if ($mysqli->connect_errno) {
    die("Connection error". $mysqli->connect_error);

}

return $mysqli;
