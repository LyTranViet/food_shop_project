<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: admin_login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý món ăn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/assets/styles.css">
</head>
<body class="container mt-4">
    <h1>Chào mừng đến với trang quản lý món ăn</h1>
    <nav class="mt-4">
        <a class="btn btn-primary" href="admin_add_food.php">Thêm món ăn</a>
        <a class="btn btn-warning" href="admin_edit_food.php">Sửa món ăn</a>
        <a class="btn btn-danger" href="admin_delete_food.php">Xóa món ăn</a>
        <a class="btn btn-info" href="foods/list.php">Danh sách món ăn</a>
        <a class="btn btn-secondary" href="admin_logout.php">Đăng xuất</a>
    </nav>
</body>
</html>