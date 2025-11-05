<?php
require('../includes/connect.php');
require('../includes/header.php');

$maSP = isset($_GET['MaSP']) ? trim($_GET['MaSP']) : '';

$masp_sql = $conn->real_escape_string($maSP);
$sql = "
    SELECT sp.*, lsp.MaLSP, ncc.TenNCC 
    FROM SanPham sp 
    LEFT JOIN LoaiSanPham lsp ON sp.MaLSP = lsp.MaLSP
    LEFT JOIN NhaCungCap ncc ON ncc.MaNCC = sp.MaNCC 
    WHERE sp.MaSP = '$masp_sql'
";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    echo "<div class='container my-5'><h4 class='text-center text-muted'>Không tìm thấy sản phẩm!</h4></div>";
    include('../includes/footer.html');
    exit;
}

$sp = $result->fetch_assoc();
?>

<link rel="stylesheet" href="/SHOPVNB/includes/css/styles.css?v=<?php echo time(); ?>" type="text/css">

<div class="container my-5">
    <div class="detailproduct">
        <div class="row g-5">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="border rounded shadow-sm p-3 bg-white">
                    <img src="../images/products/<?php echo htmlspecialchars($sp['HinhAnh']); ?>"
                        class="img-fluid" alt="<?php echo htmlspecialchars($sp['TenSP']); ?>">
                </div>

                <div class="mt-4">
                    <strong class="p-3">Mô tả:</strong><hr class="my-2">   
                    <p class="mt-2"><?php echo nl2br(htmlspecialchars($sp['MoTa'] ?? '')); ?></p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-7 ">
                <h3 class="text-uppercase mb-3"><?php echo htmlspecialchars($sp['TenSP']); ?></h3>
                <p><strong>Mã: </strong><span class="text-danger"><?php echo htmlspecialchars($sp['MaSP']); ?></span></p>
                <p><strong>Thương hiệu: </strong> <span class="text-danger"><?php echo htmlspecialchars($sp['TenNCC']); ?></span> ||
                <strong>Tình trạng: </strong>
                    <?php echo $sp['SoLuong'] > 0 ? '<span class="text-danger">Còn hàng</span>' : '<span class="text-danger">Hết hàng</span>'; ?>
                </p>

                <div class="d-flex align-items-center gap-3 my-3">
                    <span class="fs-5 text-danger fw-bold">
                        <?php echo number_format($sp['GiaGiam'], 0, ',', '.'); ?> đ
                    </span>
                    <span class="fs-6 text-decoration-line-through text-secondary">
                        Giá niêm yết: <?php echo number_format($sp['GiaGoc'], 0, ',', '.'); ?> đ
                    </span>
                </div>

                <!-- Ưu đãi -->
                <div class="uu-dai-box mt-2 p-3 border rounded-3">
                    <h5 class="fw-bold text-danger mb-3">
                        <i class="bi bi-gift-fill me-2 text-danger"></i> ƯU ĐÃI
                    </h5>
                    <ul class="list-unstyled mb-3">
                        <li><i class="bi bi-check-circle-fill text-primary me-2"></i> Tặng 2 Quấn cán vợt Cầu Lông: <span class="text-danger">VNB 001, VS002</span> hoặc <span class="text-danger">Joto 001</span></li>
                        <li><i class="bi bi-check-circle-fill text-primary me-2"></i> Sản phẩm cam kết chính hãng</li>
                        <li><i class="bi bi-check-circle-fill text-primary me-2"></i> Một số sản phẩm được tặng bao hoặc bao nhung bảo vệ</li>
                        <li><i class="bi bi-check-circle-fill text-primary me-2"></i> Thanh toán sau khi kiểm tra hàng</li>
                        <li><i class="bi bi-check-circle-fill text-primary me-2"></i> Bảo hành chính hãng theo nhà sản xuất</li>
                    </ul>

                    <h6 class="fw-bold text-danger mb-2">
                        <i class="bi bi-gift text-warning me-2"></i> Ưu đãi thêm khi mua tại <span class="text-danger">VNB Premium</span>
                    </h6>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-check2-square text-success me-2"></i> Sơn logo mặt vợt miễn phí</li>
                        <li><i class="bi bi-check2-square text-success me-2"></i> Bảo hành lưới đan trong 72 giờ</li>
                        <li><i class="bi bi-check2-square text-success me-2"></i> Thay gen vợt miễn phí trọn đời</li>
                        <li><i class="bi bi-check2-square text-success me-2"></i> Tích lũy điểm thành viên Premium</li>
                        <li><i class="bi bi-check2-square text-success me-2"></i> Voucher giảm giá cho lần sau</li>
                    </ul>
                </div>
                <div class="mt-3">
                    <label class="fw-semibold"></label>
                    <div class="d-flex flex-wrap gap-2">
                        <?php
                        $sql_size = "
                            SELECT kc.MaSize, kc.TenSize
                            FROM SanPham_KichCo spk
                            JOIN KichCo kc ON spk.MaSize = kc.MaSize
                            WHERE spk.MaSP = '" . $conn->real_escape_string($sp['MaSP']) . "'
                            AND spk.SoLuong > 0
                        ";
                        $rs_size = $conn->query($sql_size);

                        if ($rs_size && $rs_size->num_rows > 0) {
                            while ($sz = $rs_size->fetch_assoc()) {
                                echo '
                                <button type="button" class="btn btn-outline-danger btn-size" 
                                    data-size="'.$sz['MaSize'].'">'.$sz['TenSize'].'</button>';
                            }
                        } 
                        ?>
                    </div>
                    <input type="hidden" name="selectedSize" id="selectedSize">
                    </div>
                <!-- Chọn số lượng -->
                <div class="d-flex align-items-center gap-2 mt-3">
                    <label for="soluong" class="fw-semibold">Số lượng:</label>
                    <div class="input-group" style="width:130px;">
                        <button type="button" class="btn btn-outline-danger" id="minusBtn">-</button>
                        <input type="number" name="soluong" id="soluong" value="1" min="1" max="<?php echo $sp['SoLuong']; ?>" class="form-control text-center">
                        <button type="button" class="btn btn-outline-danger" id="plusBtn">+</button>
                    </div>
                </div>

                <!-- Nút hành động -->
                <div class="d-flex gap-2 mt-5 flex-wrap">
                  <form method="POST" action="../cart.php">
                    <input type="hidden" name="MaSP" value="<?php echo $sp['MaSP']; ?>">
                    <input type="hidden" name="selectedSize" id="selectedSize">
                    <input type="hidden" name="soluong" id="soluongInput" value="1">
                    <button type="submit" class="btn btn-success" id="addToCartBtn">Thêm vào giỏ hàng</button>
             
                </form>

                </div>
            </div>
        </div>

        <hr class="custom-divider">
            <div class="mt-5">
            <h4 class="mb-4 text-center text-uppercase fw-bold text-danger">Sản phẩm tương tự</h4>
            <div id="similarProductsCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                <?php
                $sql_lq = "
                    SELECT MaSP, TenSP, HinhAnh, GiaGoc, GiaGiam 
                    FROM SanPham 
                    WHERE MaLSP = '" . $conn->real_escape_string($sp['MaLSP']) . "' 
                    AND MaSP != '$maSP'
                    LIMIT 8
                ";
                $rs_lq = $conn->query($sql_lq);
                if ($rs_lq && $rs_lq->num_rows > 0) {
                    $count = 0;
                    while ($row = $rs_lq->fetch_assoc()) {
                        if ($count % 4 == 0) {
                            echo '<div class="carousel-item '.($count == 0 ? 'active' : '').'"><div class="row g-3 justify-content-center">';
                        }

                        echo '
                        <div class="col-6 col-md-3">
                            <div class="card h-100 shadow-sm border-0 small-product">
                                <img src="../images/products/' . htmlspecialchars($row['HinhAnh']) . '" 
                                    class="card-img-top" alt="' . htmlspecialchars($row['TenSP']) . '">
                                <div class="card-body text-center p-2">
                                    <h6 class="card-title mb-1">' . htmlspecialchars($row['TenSP']) . '</h6>
                                    <p class="text-danger fw-semibold mb-1 small">' . number_format($row['GiaGiam'], 0, ',', '.') . ' đ</p>
                                    <a href="detail.php?MaSP=' . $row['MaSP'] . '" class="btn btn-outline-danger btn-sm py-0 px-2">Xem</a>
                                </div>
                            </div>
                        </div>';

                        if ($count % 4 == 3) {
                            echo '</div></div>';
                        }
                        $count++;
                    }

                    if ($count % 4 != 0) {
                        echo '</div></div>';
                    }
                } else {
                    echo '<p class="text-muted text-center">Không có sản phẩm tương tự.</p>';
                }
                ?>
                </div>

                <!-- Nút điều hướng -->
                <button class="carousel-control-prev" type="button" data-bs-target="#similarProductsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
                <span class="visually-hidden">Trước</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#similarProductsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
                <span class="visually-hidden">Sau</span>
                </button>
            </div>
            </div>


    </div>
</div>

<script>
document.getElementById('plusBtn').addEventListener('click', function() {
    let input = document.getElementById('soluong');
    if (parseInt(input.value) < parseInt(input.max)) input.value++;
});
document.getElementById('minusBtn').addEventListener('click', function() {
    let input = document.getElementById('soluong');
    if (parseInt(input.value) > parseInt(input.min)) input.value--;
});
</script>


<?php require('../includes/footer.html'); ?>
