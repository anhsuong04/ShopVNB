<?php
session_start();
require('includes/connect.php');

if (!isset($_SESSION['user'])) {
    $_SESSION['errorMsg'] = "Bạn cần đăng nhập trước khi thanh toán!";
    header("Location: page/signin.php");
    exit;
}

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    $_SESSION['errorMsg'] = "Giỏ hàng của bạn đang trống!";
    header("Location: cart.php");
    exit;
}

$userID = $_SESSION['user']['UserID'];
$ngayLap = date('Y-m-d H:i:s');

// Tính tổng tiền
$tongTien = 0;
foreach ($cart as $item) {
    $tongTien += $item['Soluong'] * getGiaGiam($conn, $item['MaSP']);
}

// Tạo mã hóa đơn tự động (HD + timestamp)
$maHD = 'HD' . time();

// Thêm vào bảng HoaDon
$stmt = $conn->prepare("INSERT INTO HoaDon (MaHD, UserID, NgayLap, TongTien) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssd", $maHD, $userID, $ngayLap, $tongTien);
if ($stmt->execute()) {
    // Thêm chi tiết hóa đơn
    $stmt_ct = $conn->prepare("INSERT INTO ChiTietHoaDon (MaHD, MaSP, MaSize, SoLuong, DonGia) VALUES (?, ?, ?, ?, ?)");
    foreach ($cart as $item) {
        $maSize = ($item['Size'] === 'default') ? NULL : $item['Size'];
        $donGia = getGiaGiam($conn, $item['MaSP']);
        $stmt_ct->bind_param("sssii", $maHD, $item['MaSP'], $maSize, $item['Soluong'], $donGia);
        $stmt_ct->execute();
    }

    // Xóa giỏ hàng
    unset($_SESSION['cart']);
    $_SESSION['successMsg'] = "Thanh toán thành công!";
} else {
    $_SESSION['errorMsg'] = "Thanh toán thất bại, vui lòng thử lại!";
}

header("Location: cart.php");
exit;

// Hàm lấy giá giảm của sản phẩm
function getGiaGiam($conn, $MaSP) {
    $sql = "SELECT GiaGiam FROM SanPham WHERE MaSP = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $MaSP);
    $stmt->execute();
    $stmt->bind_result($gia);
    $stmt->fetch();
    $stmt->close();
    return $gia ?? 0;
}
