<?php

// Database connection
$host = 'localhost';
$user = "root";
$password = "";
$database = "thibella_db";

try {
    $conn = new mysqli($host, $user, $password, $database);
} catch (Exception $e) {
    echo json_encode(["error" => "Connection failed: ",
    "message" => $e->getMessage()]);
    die();
}