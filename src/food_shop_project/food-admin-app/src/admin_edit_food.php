<?php
require 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập trang này."; exit;
}

$id = $_GET['id'] ?? null;
if (!$id) { echo "Thiếu ID."; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE foods SET name=?, description=?, price=?, image=? WHERE id=?");
    $stmt->execute([$_POST['name'], $_POST['desc'], $_POST['price'], $_POST['image'], $id]);
    echo "<div class='alert alert-success'>✅ Sửa món thành công!</div>";
}

$food = $pdo->query("SELECT * FROM foods WHERE id = $id")->fetch();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Sửa món ăn</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
  <h3>Sửa món ăn</h3>
  <form method="post" class="form-control p-3">
    <input class="form-control mb-2" name="name" value="<?= htmlspecialchars($food['name']) ?>" placeholder="Tên món" required>
    <textarea class="form-control mb-2" name="desc" placeholder="Mô tả" required><?= htmlspecialchars($food['description']) ?></textarea>
    <input class="form-control mb-2" name="price" type="number" step="0.01" value="<?= htmlspecialchars($food['price']) ?>" placeholder="Giá" required>
    <input class="form-control mb-3" name="image" value="<?= htmlspecialchars($food['image']) ?>" placeholder="Link ảnh">
    <button class="btn btn-primary" type="submit">Cập nhật</button>
    <a class="btn btn-secondary" href="index.php">Quay lại</a>
  </form>
</body>
</html>