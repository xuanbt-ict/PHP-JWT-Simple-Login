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
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';
    
    if ($email && $password) {
        $query = "SELECT id, name, password FROM users WHERE email = ? LIMIT 0,1";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $id = $row['id'];
            $name = $row['name'];
            $passwordHash = $row['password'];
        
            if (password_verify($password, $passwordHash)) {
                $issuedatClaim = time();
                $notbeforeClaim = $issuedatClaim + 10;
                $expireClaim = $issuedatClaim + 24 * 60 * 60 * 7;
                $tokenPayload = [
                    "iss" => 'http://localhost:8000',
                    "iat" => $issuedatClaim,
                    "nbf" => $notbeforeClaim,
                    "exp" => $expireClaim,
                    "data" => [
                        "id" => $id,
                        "email" => $email
                    ]
                ];
    
                $token = JWT::encode($tokenPayload, 'SECRET_KEY');
    
                http_response_code(200);
                echo json_encode([
                    "message" => "Success",
                    "token" => $token,
                    "email" => $email,
                    "name" => $name,
                    "expireAt" => $expireClaim
                ]);
                return;
            }
        }
    }
}

http_response_code(401);
echo json_encode(array("message" => "Login failed"));
