<?php
include 'config.php';

if (isset($_GET['MaSP'])) {
    $MaSP = $_GET['MaSP'];
    $conn->query("DELETE FROM SanPham WHERE MaSP='$MaSP'");
}

header("Location: index.php");
exit();
?>
