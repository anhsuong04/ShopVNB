<div class="sidebar">
    <div class="container">
        <form method="GET" action="" id="filterForm">
             <div>
                <button type="button" id="resetFilters" class="btn btn-secondary btn-sm w-70">Làm mới</button>
            </div>
             <?php if(!empty($_GET['maloai'])): ?>
                <input type="hidden" name="maloai" value="<?php echo htmlspecialchars($_GET['maloai']); ?>">
            <?php endif; ?>
            <!-- Lọc Giá -->
            <h5>CHỌN MỨC GIÁ</h5>
            <div>
                <input type="radio" name="gia" value="duoi500" <?php if(isset($_GET['gia']) && $_GET['gia']=='duoi500') echo 'checked'; ?>> Dưới 500.000đ
            </div>
            <div>
                <input type="radio" name="gia" value="500-1000" <?php if(isset($_GET['gia']) && $_GET['gia']=='500-1000') echo 'checked'; ?>> 500.000đ - 1.000.000đ 
            </div>
            <div>
                <input type="radio" name="gia" value="1000-2000" <?php if(isset($_GET['gia']) && $_GET['gia']=='1000-2000') echo 'checked'; ?>> 1.000.000đ - 2.000.000đ 
            </div>
                <div>
                <input type="radio" name="gia" value="2000-3000" <?php if(isset($_GET['gia']) && $_GET['gia']=='2000-3000') echo 'checked'; ?>> 2.000.000đ - 3.000.000đ 
            </div>
             <div>
                <input type="radio" name="gia" value="tren3000" <?php if(isset($_GET['gia']) && $_GET['gia']=='tren3000') echo 'checked'; ?>> Trên 3.000.000đ
            </div>

            <hr>

            <!-- Lọc Thương Hiệu -->
            <h5>THƯƠNG HIỆU</h5>
            <?php
            $brands = $conn->query("SELECT MaNCC, TenNCC FROM NhaCungCap");
            while($row = $brands->fetch_assoc()) {
                $checked = (!empty($_GET['brand']) && in_array($row['MaNCC'], $_GET['brand'])) ? 'checked' : '';
                echo "<div>
                        <input type='checkbox' name='brand[]' value='{$row['MaNCC']}' $checked> {$row['TenNCC']}
                      </div>";
            }
            ?>

            <hr>

            <!-- Lọc Loại Sản Phẩm -->
            <h5>LOẠI SẢN PHẨM</h5>
            <?php
            $types = $conn->query("SELECT MaLSP, TenLSP FROM LoaiSanPham");
            while($row = $types->fetch_assoc()) {
                $checked = (!empty($_GET['loai']) && in_array($row['MaLSP'], $_GET['loai'])) ? 'checked' : '';
                echo "<div>
                        <input type='checkbox' name='loai[]' value='{$row['MaLSP']}' $checked> {$row['TenLSP']}
                      </div>";
            }
            ?>

        </form>
    </div>
</div>

<script>
// Tự submit khi người dùng chọn
document.querySelectorAll('#filterForm input').forEach(input => {
  input.addEventListener('change', () => document.getElementById('filterForm').submit());
});
</script>
<script>
document.querySelectorAll('#filterForm input').forEach(input => {
    input.addEventListener('change', () => document.getElementById('filterForm').submit());
});

// Nút làm mới
document.getElementById('resetFilters').addEventListener('click', () => {
    const form = document.getElementById('filterForm');
    // Reset tất cả input
    form.querySelectorAll('input[type=checkbox], input[type=radio]').forEach(i => i.checked = false);
    // Submit lại form (vẫn giữ maloai nếu có input hidden)
    form.submit();
});
</script>
