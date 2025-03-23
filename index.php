<?php
require 'auth.php';
require 'products.php';

header('Content-Type: application/json');
$request_method = $_SERVER['REQUEST_METHOD'];

switch ($request_method) {
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['action'])) {
            if ($data['action'] == 'register') {
                echo json_encode(registerUser($data['username'], $data['password']));
            } elseif ($data['action'] == 'login') {
                echo json_encode(loginUser($data['username'], $data['password'], $data['twofa_code']));
            } elseif ($data['action'] == 'create_product') {
                echo json_encode(createProduct($data['name'], $data['description'], $data['price'], $data['quantity'], $data['token']));
            }
        }
        break;
    case 'GET':
        if (isset($_GET['action']) && $_GET['action'] == 'get_products') {
            echo json_encode(getProducts($_GET['token']));
        }
        break;
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data['action'] == 'update_product') {
            echo json_encode(updateProduct($data['id'], $data['name'], $data['description'], $data['price'], $data['quantity'], $data['token']));
        }
        break;
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data['action'] == 'delete_product') {
            echo json_encode(deleteProduct($data['id'], $data['token']));
        }
        break;
    default:
        echo json_encode(["message" => "Invalid Request"]);
        break;
}
?>
