<?php

include_once '../config/database.php';
require "../vendor/autoload.php";
use Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$conn = (new Database())->getConnection();

$data = json_decode(file_get_contents("php://input"), true);
if (!empty($data)) {
    $accessToken = $data['access_token'] ?? null;
    $name = $data['name'] ?? null;
    $phone = $data['phone'] ?? null;
    $address = $data['address'] ?? null;
    
    if ($accessToken) {
        if (!$name) {
            http_response_code(422);
            echo json_encode(array("message" => "Name can not null"));
            return;
        }

        try {
            $tokenPayload = JWT::decode($accessToken, 'SECRET_KEY', ['HS256']);
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(["error" => 'Access token wrong or expired']);
            return;
        }

        $dataPayload = $tokenPayload->data ?: [];
        $userId = $dataPayload->id ?: 0;

        if ($userId) {
            $query = "UPDATE users SET name = ?, phone = ?, address = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(1, $name);
            $stmt->bindParam(2, $phone);
            $stmt->bindParam(3, $address);
            $stmt->bindParam(4, $userId);
            $stmt->execute();
        
            http_response_code(200);
            echo json_encode(["message" => "Success"]);
            return;
        }
    }
}

http_response_code(401);
echo json_encode(array("message" => "Login failed"));
