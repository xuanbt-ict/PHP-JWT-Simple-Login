<?php

include_once '../config/database.php';
require "../vendor/autoload.php";
use Firebase\JWT\JWT;

$conn = (new Database())->getConnection();

$query = "INSERT INTO users SET name = 'XuanBT', email = 'xuanbt@gmail.com', password = :password";
$stmt = $conn->prepare($query);
$password_hash = password_hash('12345678', PASSWORD_BCRYPT);
$stmt->bindParam(':password', $password_hash);

if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(array("message" => "Created user"));
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Error when create user"));
}
