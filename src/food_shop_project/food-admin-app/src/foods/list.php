<?php
require '../db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập trang này."; exit;
}

$foods = $pdo->query("SELECT * FROM foods")->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách món ăn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h3>Danh sách món ăn</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Tên món</th>
                <th>Mô tả</th>
                <th>Giá</th>
                <th>Hình ảnh</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($foods as $food): ?>
                <tr>
                    <td><?= htmlspecialchars($food['name']) ?></td>
                    <td><?= htmlspecialchars($food['description']) ?></td>
                    <td><?= htmlspecialchars($food['price']) ?></td>
                    <td><img src="<?= htmlspecialchars($food['image']) ?>" alt="<?= htmlspecialchars($food['name']) ?>" style="width: 100px;"></td>
                    <td>
                        <a href="admin_edit_food.php?id=<?= $food['id'] ?>" class="btn btn-warning">Sửa</a>
                        <a href="admin_delete_food.php?id=<?= $food['id'] ?>" class="btn btn-danger">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a class="btn btn-primary" href="admin_add_food.php">Thêm món mới</a>
    <a class="btn btn-secondary" href="index.php">Quay lại</a>
</body>
</html>