<?php
session_start();
require('../includes/connect.php');
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>


<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bảng điều khiển - Quản trị SHOPVNB</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="/SHOPVNB/includes/css/adminstyle.css" type="text/css" />
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <h4 class="text-center text-uppercase mb-4">ShopVNB Admin</h4>
  <a href="index.php?page=dashboard" class="<?= $page == 'dashboard' ? 'active' : '' ?>"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
 <a href="index.php?page=productAdmin" class="<?= $page == 'sanpham' ? 'active' : '' ?>"><i class="bi bi-bag-fill me-2"></i>Sản phẩm</a>
  <a href="index.php?page=loaisp" class="<?= $page == 'loaisp' ? 'active' : '' ?>"><i class="bi bi-tags-fill me-2"></i>Loại sản phẩm</a>
  <a href="index.php?page=donhang" class="<?= $page == 'donhang' ? 'active' : '' ?>"><i class="bi bi-receipt-cutoff me-2"></i>Đơn hàng</a>
  <a href="index.php?page=khachhang" class="<?= $page == 'khachhang' ? 'active' : '' ?>"><i class="bi bi-people-fill me-2"></i>Khách hàng</a>
  <a href="index.php?page=thongke" class="<?= $page == 'thongke' ? 'active' : '' ?>"><i class="bi bi-graph-up-arrow me-2"></i>Thống kê</a>
  <a href="dangxuat.php" class="text-warning"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</a>
</div>
<!-- NỘI DUNG CHÍNH -->
 <div class="content">
  <?php
  switch ($page) {
    case 'productAdmin':
      include('productAdmin/productAdmin.php');
      break;
    case 'editsp':
    include('productAdmin/edit.php');
    break;
    case 'createsp':
    include('productAdmin/create.php');
    break;
     case 'xoasp':
    include('productAdmin/delete.php');
    break;
    case 'loaisp':
      include('pages/categories.php');
      break;
    case 'donhang':
      include('pages/orders.php');
      break;
    case 'khachhang':
      include('pages/users.php');
      break;
    case 'thongke':
      include('pages/stats.php');
      break;
    default:
      include('../admin/dashboard.php'); 
      break;
  }
  ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
