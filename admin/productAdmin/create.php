<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ShopVNB/includes/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $MaSP = $_POST['MaSP'];
    $TenSP = $_POST['TenSP'];
    $GiaGoc = $_POST['GiaGoc'];
    $GiaGiam = $_POST['GiaGiam'];
    $MoTa = $_POST['MoTa'];
    $MaLSP = $_POST['MaLSP'];
    $MaNCC = $_POST['MaNCC'];

    // Upload ảnh
    $HinhAnh = null;
    if (!empty($_FILES['HinhAnh']['name'])) {
        $HinhAnh = basename($_FILES['HinhAnh']['name']);
        $target = "../Images/" . $HinhAnh;
        move_uploaded_file($_FILES['HinhAnh']['tmp_name'], $target);
    }

    $sql = "INSERT INTO SanPham (MaSP, TenSP, MaLSP, MaNCC, GiaGoc, GiaGiam, SoLuong, MoTa, HinhAnh)
            VALUES ('$MaSP', '$TenSP', '$MaLSP', '$MaNCC', '$GiaGoc', '$GiaGiam', '$SoLuong', '$MoTa', '$HinhAnh')";
    
    if ($conn->query($sql)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>
<h2>Thêm sản phẩm</h2>
<form method="post" enctype="multipart/form-data" style="max-width:800px; margin:auto;">
    <table style="width:100%;">
        <tr>
            <td style="padding:8px;">
                <label for="MaSP">Mã SP:</label><br>
                <input type="text" name="MaSP" id="MaSP" required style="width:100%; padding:6px;">
            </td>
            <td style="padding:8px;">
                <label for="TenSP">Tên SP:</label><br>
                <input type="text" name="TenSP" id="TenSP" required style="width:100%; padding:6px;">
            </td>
        </tr>
        <tr>
            <td style="padding:8px;">
                <label for="MaLSP">Mã loại:</label><br>
                <input type="text" name="MaLSP" id="MaLSP" style="width:100%; padding:6px;">
            </td>
            <td >
                <label for="MaNCC">Mã NCC:</label><br>
                <input type="text" name="MaNCC" id="MaNCC" style="width:100%; padding:6px;">
            </td>
        </tr>
        <tr>
            <td style="padding:8px;">
                <label for="GiaGoc">Giá gốc:</label><br>
                <input type="number" step="0.01" name="GiaGoc" id="GiaGoc" style="width:100%; padding:6px;">
            </td>
            <td style="padding:8px;">
                <label for="GiaGiam">Giá giảm:</label><br>
                <input type="number" step="0.01" name="GiaGiam" id="GiaGiam" style="width:100%; padding:6px;">
            </td>
        </tr>
        <tr>
            <td style="padding:8px;">
                <label for="HinhAnh">Hình ảnh:</label><br>
                <input type="file" name="HinhAnh" id="HinhAnh" accept="image/*">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding:8px;">
                <label for="MoTa">Mô tả:</label><br>
                <textarea name="MoTa" id="MoTa" rows="4" style="width:100%; padding:6px;"></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center; padding-top:10px;">
                <button type="submit" style="padding:8px 20px; background:#007bff; color:#fff; border:none; border-radius:4px; cursor:pointer;">Thêm</button>
                <a href="index.php" style="padding:8px 20px; background:#6c757d; color:#fff; text-decoration:none; border-radius:4px; margin-left:10px;">Quay lại</a>
            </td>
        </tr>
    </table>
</form>
