<?php
// إعدادات الاتصال بقاعدة البيانات
$host = 'localhost';
$dbname = 'info_sec_mgmt';
$db_user = 'root';      // غيّري إذا كان اسم المستخدم مختلفًا
$db_pass = '';          // غيّري إذا كانت كلمة المرور غير فارغة

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
