<?php
session_start();
require('includes/connect.php');
$successMsg = $_SESSION['successMsg'] ?? "";
$errorMsg   = $_SESSION['errorMsg'] ?? "";
unset($_SESSION['successMsg'], $_SESSION['errorMsg']);

// Khởi tạo giỏ hàng
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Thêm vào giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $MaSP = $_POST['MaSP'] ?? "";
        $Size = $_POST['selectedSize'] ?? "";
        $Soluong = max(1, intval($_POST['soluong'] ?? 1));

        if ($MaSP) {
            $Size = !empty($Size) ? $Size : 'default';
            $key = $MaSP . '-' . $Size;

            if (isset($_SESSION['cart'][$key])) {
                $_SESSION['cart'][$key]['Soluong'] += $Soluong;
            } else {
                $_SESSION['cart'][$key] = [
                    'MaSP' => $MaSP,
                    'Size' => $Size,
                    'Soluong' => $Soluong
                ];
            }
        }

        header('Location: cart.php');
        exit;
    }
}

// Xóa sản phẩm
if (isset($_POST['action']) && $_POST['action'] === 'remove') {
    $key = $_POST['key'] ?? "";
    if (isset($_SESSION['cart'][$key])) {
        unset($_SESSION['cart'][$key]);
    }
}

// Cập nhật giỏ hàng
if (isset($_POST['action']) && $_POST['action'] === 'update') {
    foreach ($_POST['soluong'] as $key => $sl) {
        if (isset($_SESSION['cart'][$key])) {
            $_SESSION['cart'][$key]['Soluong'] = max(1, intval($sl));
        }
    }
}

// Lấy dữ liệu sản phẩm
$sanpham = [];
$tongtien = 0;

if (!empty($_SESSION['cart'])) {
    $keys = array_keys($_SESSION['cart']);
    $maSPs = array_unique(array_map(fn($k) => explode('-', $k)[0], $keys));

   $sql = "
    SELECT sp.MaSP, sp.TenSP, sp.GiaGoc, sp.GiaGiam, sp.HinhAnh, kc.MaSize, kc.TenSize
    FROM SanPham sp
    LEFT JOIN SanPham_KichCo spk ON sp.MaSP = spk.MaSP
    LEFT JOIN KichCo kc ON spk.MaSize = kc.MaSize
    WHERE sp.MaSP IN ('" . implode("','", $maSPs) . "')
    ";
    $rs = $conn->query($sql);

    while ($sp = $rs->fetch_assoc()) {
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['MaSP'] == $sp['MaSP']) {
            $sp['Size'] = $item['Size'];
            $sp['SoLuong'] = $item['Soluong'];
            if ($item['Size'] !== 'default') {
                $sql_size = "SELECT TenSize FROM KichCo WHERE MaSize = '" . $conn->real_escape_string($item['Size']) . "'";
                $rs_size = $conn->query($sql_size);
                if ($rs_size && $row_size = $rs_size->fetch_assoc()) {
                    $sp['TenSize'] = $row_size['TenSize'];
                } else {
                    $sp['TenSize'] = $item['Size']; 
                }
            } else {
                $sp['TenSize'] = '-';
            }

            $sp['ThanhTien'] = $sp['GiaGiam'] * $item['Soluong'];
            $sanpham[$key] = $sp;
            $tongtien += $sp['ThanhTien'];
        }
    }
}

}

require('includes/header.php');
?>
<div class="container my-3">
    <?php if($successMsg): ?>
        <div class="alert alert-success"><?php echo $successMsg; ?></div>
    <?php elseif($errorMsg): ?>
        <div class="alert alert-danger"><?php echo $errorMsg; ?></div>
    <?php endif; ?>
</div>

<link rel="stylesheet" href="includes/css/styles.css?v=<?php echo time(); ?>">

<div class="container my-5">
    <h3 class="text-center mb-4 text-danger text-uppercase fw-bold">Giỏ hàng của bạn</h3>

    <?php if (empty($sanpham)): ?>
        <p class="text-center text-muted">Giỏ hàng của bạn đang trống.</p>
        <div class="text-center">
            <a href="/SHOPVNB/product/index.php" class="btn btn-outline-danger">Tiếp tục mua sắm</a>
        </div>
    <?php else: ?>
        <form method="POST" action="cart.php">
            <input type="hidden" name="action" value="update">
            <div class="table-responsive">
                <table class="table align-middle text-center">
                    <thead class="table-danger">
                        <tr>
                            <th>Hình</th>
                            <th>Tên sản phẩm</th>
                            <th>Size</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sanpham as $key => $item): ?>
                        <tr>
                            <td><img src="images/products/<?php echo $item['HinhAnh']; ?>" width="60"></td>
                            <td><?php echo htmlspecialchars($item['TenSP']); ?></td>
                             <td><?php echo htmlspecialchars($item['TenSize']); ?></td>
                            <td><?php echo number_format($item['GiaGiam'], 0, ',', '.'); ?> đ</td>
                            <td style="width: 100px;">
                                <input type="number" name="soluong[<?php echo $key; ?>]" 
                                       value="<?php echo $item['SoLuong']; ?>" min="1"
                                       class="form-control text-center">
                            </td>
                            <td class="text-danger fw-bold">
                                <?php echo number_format($item['ThanhTien'], 0, ',', '.'); ?> đ
                            </td>
                            <td>
                                <form method="POST" action="cart.php" style="display:inline;">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="key" value="<?php echo $key; ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <a href="/SHOPVNB/product/index.php" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Tiếp tục mua sắm
                </a>
                <div class="text-end">
                    <p class="fw-bold fs-5">Tổng: 
                        <span class="text-danger"><?php echo number_format($tongtien, 0, ',', '.'); ?> đ</span>
                    </p>
                    <form method="POST" action="xulymuahang.php" style="display:inline;">
                        <input type="hidden" name="action" value="checkout">
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-bag-check-fill"></i> Thanh toán
                        </button>
                    </form>


                </div>
            </div>
        </form>
    <?php endif; ?>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const btnThanhToan = document.querySelector("form[action='muahang.php'] button");
    btnThanhToan.addEventListener("click", function(e){
        const cartCount = <?php echo $cartCount; ?>;
        if(cartCount === 0){
            e.preventDefault();
            alert("Giỏ hàng của bạn đang trống. Vui lòng thêm sản phẩm trước khi thanh toán!");
        }
    });
});
</script>
<?php require('includes/footer.html'); ?>
