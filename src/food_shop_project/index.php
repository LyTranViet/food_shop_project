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
      Gà Rán Siêu Ngon
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
<div class="container mb-5">
  
<!-- Ảnh nhà hàng full màn hình ngang -->
<div class="mb-4 text-center">
  <img src="123.jpg"
       class="img-fluid shadow-sm"
       alt="Gà Rán Ngon"
       style="width: 100vw; height: 250px; object-fit: cover;">
</div>
  <!-- Giới thiệu nhà hàng đẹp hơn -->
<div class="card border-0 shadow-sm bg-white p-4 mb-4 position-relative" style="border-left: 5px solid #dc3545;">
  <div class="card-body">
    <div class="d-flex align-items-start mb-3">
      <div class="me-3">
        <i class="bi bi-award-fill text-danger fs-1"></i>
      </div>
      <div>
        <h4 class="card-title fw-bold text-danger mb-1">Về Gà Rán Ngon</h4>
        <p class="text-muted mb-0 fst-italic">Trải nghiệm ẩm thực giòn rụm, thơm ngon mỗi ngày!</p>
      </div>
    </div>

    <p class="card-text text-muted mt-3">
      Chào mừng bạn đến với <strong>Gà Rán Ngon</strong> – nơi mang đến trải nghiệm ẩm thực tuyệt vời với các món gà rán giòn rụm, khoai tây chiên thơm ngon và nước uống mát lạnh.
    </p>
    <p class="card-text text-muted">
      Chúng tôi cam kết sử dụng <span class="text-success fw-semibold">nguyên liệu tươi sạch</span>, <span class="text-success fw-semibold">chế biến an toàn</span> và <span class="text-success fw-semibold">phục vụ tận tâm</span> mỗi ngày.
    </p>
    
    <div class="mt-3">
      <i class="bi bi-geo-alt-fill text-success me-2"></i>
      <span class="text-dark"><strong>Địa chỉ:</strong> 123 Đường Ngon, TP. HCM</span>
    </div>
  </div>
</div>
<!-- Danh mục hình ảnh -->
<div class="container my-5">
  <h4 class="fw-bold text-danger mb-4 text-center"><i class="bi bi-grid-3x3-gap-fill me-2"></i>Danh mục món ăn</h4>
  <div class="row g-4">
    
    <!-- Ảnh 1 -->
    <div class="col-md-4">
      <div class="card border-0 shadow-sm h-100">
        <img src="img1.jpg" class="card-img-top rounded" alt="Món 1" style="height: 200px; object-fit: cover;">
        <div class="card-body text-center">
          <h6 class="card-title fw-semibold text-dark">Gà Rán Truyền Thống</h6>
        </div>
      </div>
    </div>

    <!-- Ảnh 2 -->
    <div class="col-md-4">
      <div class="card border-0 shadow-sm h-100">
        <img src="img2.jpg" class="card-img-top rounded" alt="Món 2" style="height: 200px; object-fit: cover;">
        <div class="card-body text-center">
          <h6 class="card-title fw-semibold text-dark">Gà Rán Cay Xé Lưỡi</h6>
        </div>
      </div>
    </div>

    <!-- Ảnh 3 -->
    <div class="col-md-4">
      <div class="card border-0 shadow-sm h-100">
        <img src="img3.jpg" class="card-img-top rounded" alt="Món 3" style="height: 200px; object-fit: cover;">
        <div class="card-body text-center">
          <h6 class="card-title fw-semibold text-dark">Burger Gà Giòn</h6>
        </div>
      </div>
    </div>

    <!-- Ảnh 4 -->
    <div class="col-md-4">
      <div class="card border-0 shadow-sm h-100">
        <img src="img4.jpg" class="card-img-top rounded" alt="Món 4" style="height: 200px; object-fit: cover;">
        <div class="card-body text-center">
          <h6 class="card-title fw-semibold text-dark">Cơm Gà Sốt Tiêu</h6>
        </div>
      </div>
    </div>

    <!-- Ảnh 5 -->
    <div class="col-md-4">
      <div class="card border-0 shadow-sm h-100">
        <img src="img5.jpg" class="card-img-top rounded" alt="Món 5" style="height: 200px; object-fit: cover;">
        <div class="card-body text-center">
          <h6 class="card-title fw-semibold text-dark">Khoai Tây Lắc Phô Mai</h6>
        </div>
      </div>
    </div>

    <!-- Ảnh 6 -->
    <div class="col-md-4">
      <div class="card border-0 shadow-sm h-100">
        <img src="img6.jpg" class="card-img-top rounded" alt="Món 6" style="height: 200px; object-fit: cover;">
        <div class="card-body text-center">
          <h6 class="card-title fw-semibold text-dark">Nước Ép Trái Cây</h6>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Danh sách món -->
<div class="container">
  <h2 class="text-center mb-4 text-danger">🍽️ Menu Món Ăn</h2>

  <!-- Nút lọc -->
  <div class="text-end mb-3">
    <button class="btn btn-filter" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
      🔍 Lọc món ăn
    </button>
  </div>

  <!-- Bộ lọc -->
  <div class="collapse mb-4" id="filterCollapse">
    <form method="get" class="card p-3 border-0 shadow-sm bg-light">
      <div class="row g-2 align-items-center">
        <div class="col-md-8 col-12">
          <select name="category" class="form-select">
            <option value="">-- Tất cả loại món --</option>
            <?php foreach ($categories as $cat): ?>
              <option value="<?= htmlspecialchars($cat['category']) ?>" <?= $selectedCategory === $cat['category'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['category']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4 col-12">
          <button type="submit" class="btn btn-danger w-100">Lọc</button>
        </div>
      </div>
    </form>
  </div>

  <!-- Hiển thị món -->
  <div class="row">
    <?php if (empty($foods)): ?>
      <div class="col-12 text-center text-muted">Không có món ăn nào.</div>
    <?php else: ?>
      <?php foreach ($foods as $food): ?>
        <div class="col-md-4 mb-4">
          <div class="card food-card h-100 border-0 shadow-sm">
            <?php if ($food['image']): ?>
              <img src="<?= htmlspecialchars($food['image']) ?>" class="card-img-top rounded-top" alt="<?= htmlspecialchars($food['name']) ?>">
            <?php endif; ?>
            <div class="card-body d-flex flex-column">
              <h5 class="card-title text-danger"><?= htmlspecialchars($food['name']) ?></h5>
              <p class="card-text text-muted small"><?= htmlspecialchars($food['description']) ?></p>
              <p class="fw-bold text-success"><?= number_format($food['price'], 0) ?>k</p>
<form method="post" action="add_to_cart.php" class="d-flex align-items-center mt-auto">
  <input type="hidden" name="food_id" value="<?= $food['id'] ?>">
  <input type="number" name="quantity" value="1" min="1" class="form-control me-2 w-25">
  <button type="submit" class="btn btn-sm btn-success">🛒 Mua ngay</button>
</form>

              <a href="food_detail.php?id=<?= $food['id'] ?>" class="btn btn-link text-decoration-none mt-2">📖 Chi tiết</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>
<!-- Link Bootstrap Icons & Font -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<!-- Đặt bàn -->
<div class="container mb-5">
  <div class="card shadow-sm border-0">
    <div class="row g-0">
      <!-- Ảnh minh họa -->
      <div class="col-md-6 d-none d-md-block">
        <img src="table-booking.jpg" alt="Đặt bàn" class="img-fluid h-100 rounded-start" style="object-fit: cover;">
      </div>

      <!-- Form đặt bàn -->
      <div class="col-md-6">
        <div class="card-body p-4">
          <h4 class="card-title text-danger fw-bold mb-3"><i class="bi bi-calendar-check-fill me-2"></i>Đặt bàn ngay</h4>
          <p class="text-muted">Đặt trước để có trải nghiệm tốt nhất cùng bạn bè và người thân tại Gà Rán Ngon.</p>

          <form action="book_table.php" method="post">
            <div class="mb-3">
              <label class="form-label fw-semibold">Họ và tên</label>
              <input type="text" name="name" class="form-control" placeholder="Nguyễn Văn A" required>
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">Số điện thoại</label>
              <input type="tel" name="phone" class="form-control" placeholder="0123 456 789" required>
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">Số người</label>
              <input type="number" name="people" class="form-control" min="1" max="20" value="2" required>
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">Ngày & Giờ</label>
              <input type="datetime-local" name="datetime" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-danger w-100 fw-semibold">📅 Đặt bàn</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
            
<!-- Footer -->
<footer class="bg-light text-dark pt-5 border-top" style="font-family: 'Roboto', sans-serif;">
  <div class="container">
    <div class="row">

      <!-- Logo & Thông tin nhà hàng -->
      <div class="col-md-4 mb-4">
        <div class="d-flex align-items-center mb-3">
          <img src="Orange Red Fried Chicken Logo.png" alt="Logo Gà Rán Ngon" width="50" class="me-2">
          <h5 class="fw-bold text-danger mb-0">Gà Rán Ngon</h5>
        </div>
        <p class="text-muted">Trải nghiệm ẩm thực tuyệt vời với gà rán giòn, phục vụ tận tâm và nguyên liệu tươi sạch mỗi ngày.</p>
        <ul class="list-unstyled text-muted">
          <li><i class="bi bi-geo-alt-fill me-2"></i><strong>Địa chỉ:</strong> 123 Đường Ngon, TP. HCM</li>
          <li><i class="bi bi-telephone-fill me-2"></i><strong>Hotline:</strong> 0123 456 789</li>
          <li><i class="bi bi-envelope-fill me-2"></i><strong>Email:</strong> info@garanngon.vn</li>
        </ul>
      </div>

      <!-- Liên kết nhanh -->
      <div class="col-md-4 mb-4">
        <h5 class="fw-bold"><i class="bi bi-link-45deg me-1"></i>Liên kết nhanh</h5>
        <ul class="list-unstyled">
          <li><a href="index.php" class="text-dark text-decoration-none fw-medium"><i class="bi bi-house-door me-2"></i>Trang chủ</a></li>
          <li><a href="menu.php" class="text-dark text-decoration-none fw-medium"><i class="bi bi-card-list me-2"></i>Thực đơn</a></li>
          <li><a href="intro.php" class="text-dark text-decoration-none fw-medium"><i class="bi bi-info-circle me-2"></i>Giới thiệu</a></li>
          <li><a href="contac.php" class="text-dark text-decoration-none fw-medium"><i class="bi bi-telephone me-2"></i>Liên hệ</a></li>
        </ul>
      </div>

      <!-- Mạng xã hội -->
      <div class="col-md-4 mb-4">
        <h5 class="fw-bold"><i class="bi bi-share-fill me-1"></i>Kết nối với chúng tôi</h5>
        <div class="d-flex gap-3 mt-3">
          <a href="https://www.facebook.com/" class="text-white bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="bi bi-facebook"></i></a>
          <a href="https://www.facebook.com/" class="text-white bg-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="bi bi-instagram"></i></a>
          <a href="https://www.facebook.com/" class="text-white bg-info rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="bi bi-twitter"></i></a>
          <a href="https://www.facebook.com/" class="text-white bg-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="bi bi-youtube"></i></a>
        </div>
      </div>

    </div>

    <hr>
    <div class="text-center py-3">
      <p class="mb-0 text-muted">&copy; 2025 <strong>Gà Rán Ngon</strong>. All rights reserved.</p>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
