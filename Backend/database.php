<?php
# Datenbank Name login_db
# folgende CSV Dateien sind in der DB:
# customers, products, stores, user
# user für Login, und registrieren mit folgender Struktur id, name, email, password_hash, reset_token_hash, reset_token_expires_at
# 

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
