<?php
require 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secret_key = "your_secret_key"; // يفضل استبداله بمتغير بيئي

$headers = getallheaders();
if (!isset($headers['Authorization'])) {
    die(json_encode(["error" => "Unauthorized"]));
}

$token = str_replace("Bearer ", "", $headers['Authorization']);

try {
    $decoded = JWT::decode($token, new Key($secret_key, 'HS256'));
    $user_id = $decoded->user_id; // الحصول على معرف المستخدم
} catch (Exception $e) {
    die(json_encode(["error" => "Invalid Token"]));
}
?>
