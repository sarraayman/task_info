<?php
require 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = 'your_secret_key_here'; // Use the same key as in index.php

if (!isset($_COOKIE['token'])) {
    echo "Access denied: No token provided.";
    exit;
}

$token = $_COOKIE['token'];

try {
    // Decode the token. Make sure to pass the key and the algorithm.
    $decoded = JWT::decode($token, new Key($key, 'HS256'));
    // Token is valid; you can use $decoded->data as needed.
    echo "Welcome, " . $decoded->data->name;
} catch (Exception $e) {
    // If token verification fails, display the error message.
    echo "Access denied: " . $e->getMessage();
}
?>
