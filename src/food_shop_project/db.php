<?php
$host = 'mysql_db'; // Tên dịch vụ MySQL trong docker-compose.yml
$db = 'food_shop';  // Tên database khớp với MYSQL_DATABASE
$user = 'fooduser'; // Username khớp với MYSQL_USER
$pass = '123456';   // Password khớp với MYSQL_PASSWORD

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    exit;
}
?>
