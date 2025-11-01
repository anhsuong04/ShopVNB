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

    <!-- CSS -->
    <link rel="stylesheet" href="includes/css/style.css" type="text/css" />
    <!-- File JS riêng -->
    <script script src="includes/js/js.js"></script>
</head>

<body>
<header class="bg-light border-bottom shadow-sm">
    <div class="container d-flex justify-content-between align-items-center py-2">
        <!-- Logo -->
        <a href="index.php" class="d-flex align-items-center text-decoration-none text-dark">
            <img src="images/logo/logo.png" alt="VNB Shop Logo" style="height:50px;">
            <h1 class="h5 ms-2 mb-0"><span class="text-danger">VNB</span> Shop</h1>
        </a>
        <form class="d-none d-md-flex ms-3" action="timkiem.php" method="get" style="flex:1; max-width:400px;">
            <input type="text" name="q" class="form-control" placeholder="Tìm sản phẩm...">
            <button class="btn btn-outline-danger ms-2" type="submit"><i class="bi bi-search"></i></button>
        </form>

        <!-- Khu vực icon bên phải -->
       <!-- Khu vực icon bên phải -->
        <div class="d-flex align-items-center">
            <!-- Tài khoản -->
            <a href="taikhoan.php" class="btn btn-outline-secondary me-2 d-flex align-items-center">
                <i class="bi bi-person"></i>
                <span class="ms-1 d-none d-md-inline">Tài khoản</span>
            </a>

            <!-- Giỏ hàng -->
            <a href="giohang.php" class="btn btn-outline-success me-2 d-flex align-items-center">
                <i class="bi bi-cart3"></i>
                <span class="ms-1 d-none d-md-inline">Giỏ hàng</span>
            </a>

            <!-- Nút mở menu (3 gạch) -->
            <button class="btn btn-outline-dark d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                <i class="bi bi-list fs-4"></i>
            </button>
        </div>

    </div>

    <!-- MENU CHÍNH (desktop) -->
    <nav class="navbar navbar-expand-md navbar-light bg-white border-top">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a href="index.php" class="nav-link">Trang chủ</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Sản phẩm</a>
                        <ul class="dropdown-menu">
                            <?php
                            require("connect.php");
                            $sql = "SELECT * FROM LoaiSanPham";
                            $result = mysqli_query($conn, $sql);
                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<li><a class="dropdown-item" href="sanpham.php?loai=' . $row['MaLSP'] . '">' . htmlspecialchars($row['TenLSP']) . '</a></li>';
                                }
                            } else {
                                echo '<li><a class="dropdown-item" href="#">Chưa có loại sản phẩm</a></li>';
                            }
                            mysqli_close($conn);
                            ?>
                        </ul>
                    </li>

                    <li class="nav-item"><a href="uudai.php" class="nav-link">Ưu đãi</a></li>
                    <li class="nav-item"><a href="gioithieu.php" class="nav-link">Giới thiệu</a></li>
                    <li class="nav-item"><a href="lienhe.php" class="nav-link">Liên hệ</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- OFFCANVAS (menu & tìm kiếm cho mobile) -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenu">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title"><span class="text-danger">VNB</span> Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <!-- Thanh tìm kiếm -->
            <form class="d-flex mb-3" action="timkiem.php" method="get">
                <input type="text" name="q" class="form-control me-2" placeholder="Tìm sản phẩm...">
                <button class="btn btn-outline-danger" type="submit"><i class="bi bi-search"></i></button>
            </form>

            <!-- Danh sách menu -->
            <ul class="navbar-nav">
                <li class="nav-item"><a href="index.php" class="nav-link">Trang chủ</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Sản phẩm</a>
                    <ul class="dropdown-menu">
                        <?php
                        require("connect.php");
                        $sql = "SELECT * FROM LoaiSanPham";
                        $result = mysqli_query($conn, $sql);
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<li><a class="dropdown-item" href="sanpham.php?loai=' . $row['MaLSP'] . '">' . htmlspecialchars($row['TenLSP']) . '</a></li>';
                            }
                        } else {
                            echo '<li><a class="dropdown-item" href="#">Chưa có loại sản phẩm</a></li>';
                        }
                        mysqli_close($conn);
                        ?>
                    </ul>
                </li>
                <li class="nav-item"><a href="uudai.php" class="nav-link">Ưu đãi</a></li>
                <li class="nav-item"><a href="gioithieu.php" class="nav-link">Giới thiệu</a></li>
                <li class="nav-item"><a href="lienhe.php" class="nav-link">Liên hệ</a></li>
            </ul>
        </div>
    </div>
</header>


<!-- Bootstrap JS Bundle (bắt buộc cho dropdown & toggle hoạt động) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
