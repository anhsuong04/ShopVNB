<?php
require('../includes/connect.php');

$rowsPerPage = 10;
$p = isset($_GET['p']) ? intval($_GET['p']) : 1;
if ($p < 1) $p = 1;
$offset = ($p - 1) * $rowsPerPage;

// Xử lý tìm kiếm
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($search != '') {
    $sql = "SELECT * FROM SanPham WHERE TenSP LIKE '%$search%' LIMIT $offset, $rowsPerPage";
    $countSql = "SELECT COUNT(*) AS total FROM SanPham WHERE TenSP LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM SanPham LIMIT $offset, $rowsPerPage";
    $countSql = "SELECT COUNT(*) AS total FROM SanPham";
}

$result = $conn->query($sql);
$countResult = $conn->query($countSql);
$totalRows = $countResult->fetch_assoc()['total'];
$maxPage = ceil($totalRows / $rowsPerPage);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="../includes/css/adminstyle.css" type="text/css" />

<h2>Danh sách sản phẩm</h2>

<form method="GET" action="">
    <input type="text" name="search" placeholder="Nhập tên sản phẩm..." value="<?= htmlspecialchars($search) ?>">
    <button type="submit">Tìm kiếm</button>
     <form action="../admin/index.php" method="get" style="display:inline;">
            <input type="hidden" name="page" value="createsp">
            <input type="hidden" name="MaSP" value="<?= $row['MaSP'] ?>">
            <button type="submit">Thêm mới</button>
    </form>
</form>

<table>
    <tr>
        <th>Mã SP</th>
        <th>Tên SP</th>
        <th>Giá Gốc</th>
        <th>Giá Giảm</th>
        <th>Hình Ảnh</th>
        <th>Hành động</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['MaSP'] ?></td>
        <td><?= $row['TenSP'] ?></td>
        <td><?= number_format($row['GiaGoc'], 0, ',', '.') ?>₫</td>
        <td><?= number_format($row['GiaGiam'], 0, ',', '.') ?>₫</td>
        <td>
            <?php if (!empty($row['HinhAnh'])): ?>
                <img src="../images/products/<?= htmlspecialchars($row['HinhAnh']) ?>" alt="Ảnh sản phẩm">
            <?php else: ?>
                <span>Không có ảnh</span>
            <?php endif; ?>
        </td>
       <td style="text-align: center;">
            <!-- Nút Sửa -->
           <form action="../admin/index.php" method="get" style="display:inline;">
            <input type="hidden" name="page" value="editsp">
            <input type="hidden" name="MaSP" value="<?= $row['MaSP'] ?>">
            <button type="submit"><i class="bi bi-pencil-square"></i></button>
        </form>
        <form action="../admin/index.php" method="get" style="display:inline;">
            <input type="hidden" name="page" value="xoasp">
            <input type="hidden" name="MaSP" value="<?= $row['MaSP'] ?>">
            <button type="submit"><i class="bi bi-trash-fill"></i></button>
        </form>
            <!-- Nút Chi tiết -->
        <form action="chitiet.php" method="get" style="display:inline;">
                <input type="hidden" name="MaSP" value="<?= $row['MaSP'] ?>">
                <button type="submit" class="btn btn-sm btn-info text-white" title="Xem chi tiết">
                    <i class="bi bi-eye-fill"></i>
                </button>
            </form>
        </td>

    </tr>
    <?php endwhile; ?>
</table>

<!-- Phân trang -->
<div class="pagination" style="text-align:center; margin-top:15px;">
<?php
// Giữ lại từ khóa tìm kiếm nếu có
$searchParam = $search != '' ? '&search=' . urlencode($search) : '';
if ($p > 1) {
    echo "<a href='index.php?page=productAdmin&p=1$searchParam'>&lt;&lt;</a> ";
    echo "<a href='index.php?page=productAdmin&p=" . ($p - 1) . "$searchParam'>&lt;</a> ";
}

for ($i = 1; $i <= $maxPage; $i++) {
    if ($i == $p)
        echo "<b>$i</b> ";
    else
        echo "<a href='index.php?page=productAdmin&p=$i$searchParam'>$i</a> ";
}

if ($p < $maxPage) {
    echo "<a href='index.php?page=productAdmin&p=" . ($p + 1) . "$searchParam'>&gt;</a> ";
    echo "<a href='index.php?page=productAdmin&p=$maxPage$searchParam'>&gt;&gt;</a>";
}

?>
</div>

