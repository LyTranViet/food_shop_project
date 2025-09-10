<?php
require 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập trang này."; exit;
}

$id = $_GET['id'] ?? null;
if (!$id) { echo "Thiếu ID."; exit; }

$pdo->prepare("DELETE FROM foods WHERE id = ?")->execute([$id]);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Xóa món ăn</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
  <div class="alert alert-warning">
    ✅ Món ăn đã được xóa.
  </div>
  <a class="btn btn-primary" href="index.php">Quay lại trang chủ</a>
</body>
</html>