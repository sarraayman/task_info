<?php
require 'db.php';
require 'auth.php';

// إضافة منتج جديد
function createProduct($name, $description, $price, $quantity, $token) {
    global $conn;
    if (!$user = verifyJWT($token)) return false;
    $sql = "INSERT INTO products (name, description, price, quantity) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdi", $name, $description, $price, $quantity);
    return $stmt->execute();
}

// جلب كل المنتجات
function getProducts($token) {
    global $conn;
    if (!$user = verifyJWT($token)) return false;
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// تحديث بيانات المنتج
function updateProduct($id, $name, $description, $price, $quantity, $token) {
    global $conn;
    if (!$user = verifyJWT($token)) return false;
    $sql = "UPDATE products SET name=?, description=?, price=?, quantity=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdii", $name, $description, $price, $quantity, $id);
    return $stmt->execute();
}

// حذف منتج
function deleteProduct($id, $token) {
    global $conn;
    if (!$user = verifyJWT($token)) return false;
    $sql = "DELETE FROM products WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
?>
