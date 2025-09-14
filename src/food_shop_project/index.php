<?php
session_start();
require 'db.php';

// Hàm escape an toàn
function e($str) {
    return htmlspecialchars((string)($str ?? ''), ENT_QUOTES, 'UTF-8');
}

// Lấy danh mục món
$categories = $pdo->query("SELECT DISTINCT category FROM foods WHERE category IS NOT NULL")->fetchAll();
$selectedCategory = $_GET['category'] ?? '';

if ($selectedCategory) {
    $stmt = $pdo->prepare("SELECT * FROM foods WHERE category = ? ORDER BY id DESC");
    $stmt->execute([$selectedCategory]);
    $foods = $stmt->fetchAll();
} else {
    $foods = $pdo->query("SELECT * FROM foods ORDER BY id DESC")->fetchAll();
}

$current_page = basename($_SERVER['PHP_SELF']); // lấy tên file hiện tại

// Xử lý tìm kiếm
$searchQuery = $_GET['q'] ?? '';
if ($searchQuery) {
    $stmt = $pdo->prepare("SELECT * FROM foods WHERE name LIKE ? ORDER BY id DESC");
    $stmt->execute(["%$searchQuery%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM foods ORDER BY id DESC");
}
$foods = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Gà Rán Ngon - Trang chủ</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

  <style>
    body { background-color: #f8f9fa; font-family: 'Roboto', sans-serif; }
    .section-title {
      font-weight: 700;
      font-size: 1.8rem;
      color: #dc3545;
      text-align: center;
      margin-bottom: 2rem;
      text-transform: uppercase;
    }
    .food-card { transition: transform 0.3s; border-radius: 10px; }
    .food-card:hover { transform: scale(1.02); }
    .btn-filter {
      background-color: #fff;
      border: 1px solid #dc3545;
      color: #dc3545;
      font-weight: 500;
    }
    .btn-filter:hover { background-color: #dc3545; color: #fff; }
    section { padding: 60px 0; }
    section.bg-light { background: #fdfdfd; }
    section.bg-gray { background: #f1f1f1; }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold text-danger d-flex align-items-center" href="index.php">
      <img src="Orange Red Fried Chicken Logo.png" alt="Logo" height="40" class="me-2">
      Gà Rán Ngon
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto fw-semibold">
        <li class="nav-item">
          <a class="nav-link <?= $current_page=='index.php'?'text-danger fw-bold':'' ?>" href="index.php">
            <i class="bi bi-house-door-fill me-1"></i>Trang chủ
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current_page=='menu.php'?'text-danger fw-bold':'' ?>" href="menu.php">
            <i class="bi bi-card-list me-1"></i>Thực đơn
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current_page=='intro.php'?'text-danger fw-bold':'' ?>" href="intro.php">
            <i class="bi bi-info-circle-fill me-1"></i>Giới thiệu
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current_page=='contact.php'?'text-danger fw-bold':'' ?>" href="contact.php">
            <i class="bi bi-telephone-fill me-1"></i>Liên hệ
          </a>
        </li>
      </ul>

      <div class="d-flex gap-2 ms-lg-3 mt-3 mt-lg-0">
        <a href="cart.php" class="btn btn-outline-danger">
          <i class="bi bi-cart-fill me-1"></i>Giỏ hàng
        </a>
        <a href="book_table.php" class="btn btn-danger">
          <i class="bi bi-calendar-check-fill me-1"></i>Đặt bàn
        </a>

        <?php if (isset($_SESSION['user_id'])): ?>
          <a href="logout.php" class="btn btn-secondary">
            <i class="bi bi-box-arrow-right me-1"></i>Đăng xuất
          </a>
        <?php else: ?>
          <a href="login.php" class="btn btn-outline-dark">
            <i class="bi bi-box-arrow-in-right me-1"></i>Đăng nhập
          </a>
          <a href="register.php" class="btn btn-danger">
            <i class="bi bi-person-plus-fill me-1"></i>Đăng ký
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<!-- Search -->
<div class="container py-4">
  <form class="d-flex mb-3 position-relative" method="get" action="">
    <input class="form-control form-control-sm rounded-pill ps-3 pe-5 shadow-sm"
           type="search" name="q" placeholder="Tìm món ăn..." aria-label="Search"
           value="<?= e($searchQuery) ?>">
    <button class="btn btn-primary btn-sm position-absolute top-0 end-0 mt-1 me-1 rounded-circle shadow-sm" type="submit">
      <i class="bi bi-search"></i>
    </button>
  </form>

  <?php if ($searchQuery): ?>
    <div class="row g-4">
      <?php if (empty($foods)): ?>
        <div class="col-12 text-center text-muted">Không tìm thấy món ăn nào.</div>
      <?php else: foreach ($foods as $food): ?>
        <div class="col-md-4">
          <div class="card h-100 shadow-sm border-0 food-card">
            <?php if (!empty($food['image'])): ?>
              <img src="<?= e($food['image']) ?>" class="card-img-top" alt="<?= e($food['name']) ?>" style="height:220px; object-fit:cover;">
            <?php endif; ?>
            <div class="card-body d-flex flex-column">
              <h5 class="text-danger fw-bold"><?= e($food['name']) ?></h5>
              <p class="text-muted small flex-grow-1"><?= e($food['description']) ?></p>
              <p class="fw-bold text-success"><?= number_format((float)$food['price'],0) ?>k</p>

              <form method="post" action="add_to_cart.php" class="d-flex mt-auto gap-2">
                <input type="hidden" name="food_id" value="<?= e($food['id']) ?>">
                <input type="number" name="quantity" value="1" min="1" class="form-control w-25">
                <button class="btn btn-success flex-grow-1">🛒 Mua ngay</button>
              </form>

              <a href="food_detail.php?id=<?= e($food['id']) ?>" class="btn btn-link text-decoration-none mt-2">📖 Chi tiết</a>
            </div>
          </div>
        </div>
      <?php endforeach; endif; ?>
    </div>
  <?php else: ?>
    <div class="text-center text-muted py-5">Nhập từ khóa và nhấn tìm kiếm để xem món ăn.</div>
  <?php endif; ?>
</div>

<!-- Phần còn lại: Hero, Danh mục, Menu, Đặt bàn, Footer -->
<!-- (ở các chỗ hiển thị name, description, image... mình đều thay bằng e($var)) -->

<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
