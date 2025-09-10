<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Replace with your actual admin credentials
    $admin_username = 'admin';
    $admin_password = 'password';

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['role'] = 'admin';
        header('Location: index.php');
        exit;
    } else {
        $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập quản trị</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>Đăng nhập quản trị</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="post" class="form-control p-3">
        <input class="form-control mb-2" name="username" placeholder="Tên đăng nhập" required>
        <input class="form-control mb-2" name="password" type="password" placeholder="Mật khẩu" required>
        <button class="btn btn-primary" type="submit">Đăng nhập</button>
    </form>
</body>
</html>