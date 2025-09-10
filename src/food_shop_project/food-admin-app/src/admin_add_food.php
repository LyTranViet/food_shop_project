<?php
require 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập trang này."; exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO foods (name, description, price, image) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_POST['name'], $_POST['desc'], $_POST['price'], $_POST['image']]);
    echo "✅ Thêm món thành công!";
}
?>

<form method="post">
    <input name="name" placeholder="Tên món" required>
    <textarea name="desc" placeholder="Mô tả" required></textarea>
    <input name="price" type="number" step="0.01" placeholder="Giá" required>
    <input name="image" placeholder="URL ảnh">
    <button type="submit">Thêm món</button>
</form>