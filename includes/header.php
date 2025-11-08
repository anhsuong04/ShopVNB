<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($page_title) ? $page_title : "VNB Shop - Cửa hàng cầu lông"; ?></title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>    
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
      rel="stylesheet" 
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
      crossorigin="anonymous">
      <!-- File JS riêng -->
    <script script src="/SHOPVNB/includes/js/slider.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="/SHOPVNB/includes/css/styles.css" type="text/css" />
  
</head>

<body>


<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="bg-light border-bottom shadow-sm">
    <div class="container d-flex justify-content-between align-items-center py-2">
        <!-- Logo -->
        <a href="/SHOPVNB/index.php" class="d-flex align-items-center text-decoration-none text-dark">
            <img src="/SHOPVNB/images/logo/logo.png" alt="VNB Shop Logo" style="height:50px;">
            <h1 class="h5 ms-2 mb-0"><span class="text-danger">VNB</span> Shop</h1>
        </a>

        <!-- Ô tìm kiếm -->
        <form class="d-none d-md-flex ms-3" action="/SHOPVNB/product/index.php" method="get" style="flex:1; max-width:400px;">
            <input type="text" name="q" class="form-control" placeholder="Tìm sản phẩm...">
            <button class="btn btn-outline-danger ms-2" type="submit"><i class="bi bi-search"></i></button>
        </form>

        <!-- Khu vực icon bên phải -->
        <div class="d-flex align-items-center">
            <?php if (isset($_SESSION['user'])): ?>
                <!-- Nếu đã đăng nhập -->
                <div class="dropdown me-2">
                    <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person"></i>
                        <span class="ms-1 d-none d-md-inline">Xin chào, <?= htmlspecialchars($_SESSION['user']['Ten']) ?></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/SHOPVNB/page/profile.php">Thông tin cá nhân</a></li>
                        <li><a class="dropdown-item" href="/SHOPVNB/page/logout.php">Đăng xuất</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <!-- Nếu chưa đăng nhập -->
                <a href="/SHOPVNB/page/signin.php" class="btn btn-outline-secondary me-2 d-flex align-items-center">
                    <i class="bi bi-person"></i>
                    <span class="ms-1 d-none d-md-inline">Tài khoản</span>
                </a>
            <?php endif; ?>

            <!-- Giỏ hàng -->
            <a href="/SHOPVNB/cart.php" class="btn btn-outline-success me-2 d-flex align-items-center">
                <i class="bi bi-cart3"></i>
                <span class="ms-1 d-none d-md-inline">Giỏ hàng</span>
                <?php 
                $cartCount = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'SoLuong')) : 0;
                if ($cartCount > 0) {
                    echo '<span class="badge bg-danger ms-1">'.$cartCount.'</span>';
                }
                ?>
            </a>

            <!-- Nút mở menu (3 gạch) -->
            <button class="btn btn-outline-dark d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                <i class="bi bi-list fs-4"></i>
            </button>
        </div>
    </div>

    <!-- MENU CHÍNH -->
    <nav class="navbar navbar-expand-md navbar-light bg-white border-top">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a href="/SHOPVNB/index.php" class="nav-link">Trang chủ</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="/SHOPVNB/product/index.php" data-bs-toggle="dropdown" id="menuSanPham">Sản phẩm</a>
                        <ul class="dropdown-menu">
                            <?php
                            require("connect.php");
                            $sql = "SELECT * FROM LoaiSanPham";
                            $result = mysqli_query($conn, $sql);
                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<li><a class="dropdown-item" href="/SHOPVNB/product/index.php?maloai=' . $row['MaLSP'] . '">' . htmlspecialchars($row['TenLSP']) . '</a></li>';
                                }
                            } else {
                                echo '<li><a class="dropdown-item" href="#">Chưa có loại sản phẩm</a></li>';
                            }
                            
                            ?>
                        </ul>
                    </li>

                    <li class="nav-item"><a href="/SHOPVNB/page/about.php" class="nav-link">Giới thiệu</a></li>
                    <li class="nav-item"><a href="/SHOPVNB/page/contact.php" class="nav-link">Liên hệ</a></li>

                    <?php if (isset($_SESSION['user']) && in_array($_SESSION['user']['Role'], [1, 2])): ?>
                        <!-- Nếu là Admin hoặc Nhân viên -->
                        <li class="nav-item">
                            <a href="/SHOPVNB/admin/dashboard.php" class="nav-link text-danger fw-semibold">Trang Admin</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>



<!-- Bootstrap JS Bundle (bắt buộc cho dropdown & toggle hoạt động) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  const menuSanPham = document.getElementById("menuSanPham");
  menuSanPham.addEventListener("click", function(e) {
    if (!menuSanPham.classList.contains("show")) {
      // Nếu chưa mở dropdown, chuyển trang
      window.location.href = menuSanPham.href;
    }
  });
});
</script>
</body>
</html>
