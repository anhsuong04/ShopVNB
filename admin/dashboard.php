 <link rel="stylesheet" href="/SHOPVNB/includes/css/adminstyle.css" type="text/css" />
<div class="content">
  <div class="row g-4">

    <!-- SẢN PHẨM -->
    <div class="col-md-3">
      <div class="card shadow-sm border-0">
        <div class="card-body text-center">
          <i class="bi bi-bag-fill fs-1 text-danger"></i>
          <h6 class="mt-2">Sản phẩm</h6>
          <p class="display-6 text-primary">
            <?php
              $result = $conn->query("SELECT COUNT(*) AS total FROM SanPham");
              echo $result->fetch_assoc()['total'];
            ?>
          </p>
          <a href="pages/products.php" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
        </div>
      </div>
    </div>

    <!-- KHÁCH HÀNG -->
    <div class="col-md-3">
      <div class="card shadow-sm border-0">
        <div class="card-body text-center">
          <i class="bi bi-people-fill fs-1 text-danger"></i>
          <h6 class="mt-2">Khách hàng</h6>
          <p class="display-6 text-success">
            <?php
              $result = $conn->query("SELECT COUNT(*) AS total FROM Users WHERE Role = 3");
              echo $result->fetch_assoc()['total'];
            ?>
          </p>
          <a href="pages/users.php" class="btn btn-outline-warning btn-sm">Xem chi tiết</a>
        </div>
      </div>
    </div>

    <!-- ĐƠN HÀNG -->
    <div class="col-md-3">
      <div class="card shadow-sm border-0">
        <div class="card-body text-center">
          <i class="bi bi-receipt-cutoff fs-1 text-danger"></i>
          <h6 class="mt-2">Đơn hàng</h6>
          <p class="display-6 text-success">
            <?php
              $result = $conn->query("SELECT COUNT(*) AS total FROM HoaDon");
              echo $result->fetch_assoc()['total'];
            ?>
          </p>
          <a href="pages/orders.php" class="btn btn-outline-success btn-sm">Xem chi tiết</a>
        </div>
      </div>
    </div>

    <!-- NHÀ CUNG CẤP -->
    <div class="col-md-3">
      <div class="card shadow-sm border-0">
        <div class="card-body text-center">
          <i class="bi bi-truck fs-1 text-danger"></i>
          <h6 class="mt-2">Nhà Cung Cấp</h6>
          <p class="display-6 text-danger">
            <?php
              $result = $conn->query("SELECT COUNT(*) AS total FROM NhaCungCap");
              echo $result->fetch_assoc()['total'];
            ?>
          </p>
          <a href="pages/suppliers.php" class="btn btn-outline-danger btn-sm">Xem chi tiết</a>
        </div>
      </div>
    </div>

    <!-- LOẠI SẢN PHẨM -->
    <div class="col-md-3">
      <div class="card shadow-sm border-0">
        <div class="card-body text-center">
          <i class="bi bi-tags-fill fs-1 text-danger"></i>
          <h6 class="mt-2">Loại sản phẩm</h6>
          <p class="display-6 text-info">
            <?php
              $result = $conn->query("SELECT COUNT(*) AS total FROM LoaiSanPham");
              echo $result->fetch_assoc()['total'];
            ?>
          </p>
          <a href="pages/categories.php" class="btn btn-outline-info btn-sm">Xem chi tiết</a>
        </div>
      </div>
    </div>

    <!-- DOANH THU -->
    <div class="col-md-3">
      <div class="card shadow-sm border-0">
        <div class="card-body text-center">
          <i class="bi bi-cash-coin fs-1 text-success"></i>
          <h6 class="mt-2">Tổng doanh thu</h6>
          <p class="display-6 text-success">
            <?php
              $result = $conn->query("SELECT SUM(TongTien) AS total FROM HoaDon");
              $row = $result->fetch_assoc();
              echo number_format($row['total'] ?? 0, 0, ',', '.') . ' đ';
            ?>
          </p>
          <a href="thongke.php" class="btn btn-outline-success btn-sm">Xem chi tiết</a>
        </div>
      </div>
    </div>

  </div>
</div>
