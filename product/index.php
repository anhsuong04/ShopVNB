<?php
require("../includes/connect.php");
include('../includes/header.php');

$maloai = isset($_GET['maloai']) ? $_GET['maloai'] : '';

// --- CẤU HÌNH PHÂN TRANG ---
$limit = 6; // số sản phẩm trên mỗi trang
$page = isset($_GET['page']) && $_GET['page'] > 0 ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$where = [];

if (isset($_GET['gia'])) {
    switch ($_GET['gia']) {
        case 'duoi500': $where[] = "GiaGiam < 500000"; break;
        case '500-1000': $where[] = "GiaGiam BETWEEN 500000 AND 1000000"; break;
        case '1000-2000': $where[] = "GiaGiam BETWEEN 1000000 AND 2000000"; break;
        case '2000-3000': $where[] = "GiaGiam BETWEEN 2000000 AND 3000000"; break;
        case 'tren3000': $where[] = "GiaGiam > 3000000"; break;
    }
}

if (!empty($_GET['brand'])) {
    $brands = array_map([$conn, 'real_escape_string'], $_GET['brand']);
    $where[] = "MaNCC IN ('" . implode("','", $brands) . "')";
}

if (!empty($_GET['loai'])) {
    $types = array_map([$conn, 'real_escape_string'], $_GET['loai']);
    $where[] = "MaLSP IN ('" . implode("','", $types) . "')";
}elseif (!empty($_GET['maloai'])) {
    $maloai_sql = $conn->real_escape_string($_GET['maloai']);
    $where[] = "MaLSP = '$maloai_sql'";
}
$sort="";
if(isset($_GET['sort'])){
    if($_GET['sort'] == 'pricesale_desc') $sort = " ORDER BY GiaGiam DESC";
    elseif($_GET['sort'] == 'pricesale') $sort = " ORDER BY GiaGiam ASC";
}
#dem tong san pham
$count = "SELECT COUNT(*) AS total FROM SanPham";
if (count($where) > 0) $count .= " WHERE " . implode(" AND ", $where);
$count_result = $conn->query($count);
$total_rows = $count_result ? $count_result->fetch_assoc()['total'] : 0;
$total_pages = ceil($total_rows / $limit);

$sql = "SELECT * FROM SanPham";
if (count($where) > 0) $sql .= " WHERE " . implode(" AND ", $where);
$sql .= $sort;
$sql .= " LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

?>
<link rel="stylesheet" href="/SHOPVNB/includes/css/styles.css" type="text/css" />
<div class="container my-5">
  <div class="row">
    <!-- SIDEBAR -->
    <div class="col-md-3">
      <?php include('../includes/sidebar_filter.php'); ?>
    </div>

    <!-- DANH SÁCH SẢN PHẨM -->
    <div class="col-md-9">
        <div class="d-flex align-items-center justify-content-between mb-4">
    <h3 class="text-uppercase text-dark mb-0">
        <?php
        if (!empty($maloai)) {
            $maloai_sql = $conn->real_escape_string($maloai);
            $queryLoai = $conn->query("SELECT TenLSP FROM LoaiSanPham WHERE MaLSP = '$maloai_sql'");
            $tenLoai = ($queryLoai && $queryLoai->num_rows > 0) ? $queryLoai->fetch_assoc()['TenLSP'] : '';
            echo htmlspecialchars($tenLoai);
        } else {
            echo "Tất cả sản phẩm";
        }
        ?>
    </h3>
    <form method="GET" id="sortForm">
        <?php
        foreach ($_GET as $key => $val) {
            if ($key != 'sort') {
                if (is_array($val)) {
                    foreach ($val as $v) {
                        echo '<input type="hidden" name="'.$key.'[]" value="'.$v.'">';
                    }
                } else {
                    echo '<input type="hidden" name="'.$key.'" value="'.$val.'">';
                }
            }
        }
        ?>
        <select name="sort" class="form-select w-auto" onchange="document.getElementById('sortForm').submit();">
            <option value="">Tất cả</option>
            <option value="pricesale_desc" <?php if(isset($_GET['sort']) && $_GET['sort']=='pricesale_desc') echo 'selected'; ?>>Giá cao đến thấp</option>
            <option value="pricesale" <?php if(isset($_GET['sort']) && $_GET['sort']=='pricesale') echo 'selected'; ?>>Giá thấp đến cao</option>
        </select>
    </form>
    </div>

        <div class="row g-4">
                    <?php
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()):
                        ?>
                            <div class="col-6 col-md-4 col-lg-4">
                                <div class="card h-100 shadow-sm">
                                    <img src="../images/products/<?php echo htmlspecialchars($row['HinhAnh']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['TenSP']); ?>">
                                    <div class="card-body text-center">
                                        <h6 class="card-title"><?php echo htmlspecialchars($row['TenSP']); ?></h6>
                                        <div class="d-flex justify-content-center gap-2">
                                            <p class="fw-semibold text-decoration-line-through mb-0"><?php echo number_format($row['GiaGoc'],0,',','.'); ?> đ</p>
                                            <p class="text-danger fw-semibold mb-0"><?php echo number_format($row['GiaGiam'],0,',','.'); ?> đ</p>
                                        </div>
                                        <div class="d-flex justify-content-between gap-2 mt-2">
                                            <a href="/SHOPVNB/product/detail.php?MaSP=<?php echo $row['MaSP']; ?>" class="btn btn-outline-danger btn-sm flex-fill text-nowrap">Xem chi tiết</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        endwhile;
                    } else {
                        echo '<p class="text-center text-muted">Không có sản phẩm nào.</p>';
                    }
                    ?>

                </div>

                <!-- PHÂN TRANG -->
                <?php if ($total_pages > 1): 
                    $params = $_GET;
                    unset($params['page']); // page sẽ gán lại
                ?>
                <nav class="mt-4">
                    <ul class="pagination justify-content-center">
                        <?php
                        for ($i=1; $i <= $total_pages; $i++) {
                            $active = ($i==$page)?'active':'';
                            $params['page'] = $i;
                            $url = '?' . http_build_query($params);
                            echo '<li class="page-item '.$active.'"><a class="page-link" href="'.$url.'">'.$i.'</a></li>';
                        }
                        ?>
                    </ul>
                </nav>
                <?php endif; ?>

            </div>
    </div>
</div>

<?php
include('../includes/footer.html');
$conn->close();
?>