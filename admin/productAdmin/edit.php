<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ShopVNB/includes/connect.php';



$MaSP = $_GET["MaSP"];
$result = $conn->query("SELECT * FROM SanPham WHERE MaSP='$MaSP'");
$sp = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $TenSP = $_POST["TenSP"];
    $MaLSP = $_POST["MaLSP"];
    $MaNCC = $_POST["MaNCC"];
    $GiaGoc = $_POST["GiaGoc"];
    $GiaGiam = $_POST["GiaGiam"];
    $MoTa = $_POST["MoTa"];

    $HinhAnh = $sp["HinhAnh"];
    if (!empty($_FILES["HinhAnh"]["name"])) {
        $target_dir = __DIR__ . "/../images/products/";
        $HinhAnh = basename($_FILES["HinhAnh"]["name"]);
        move_uploaded_file($_FILES["HinhAnh"]["tmp_name"], $target_dir . $HinhAnh);
    }

    $sql = "UPDATE SanPham SET 
            TenSP='$TenSP', MaLSP='$MaLSP', MaNCC='$MaNCC',
            GiaGoc='$GiaGoc', GiaGiam='$GiaGiam', MoTa='$MoTa', HinhAnh='$HinhAnh'
            WHERE MaSP='$MaSP'";
    $conn->query($sql);
    header("Location: productAdmin/productAdmin.php");
    exit();
}
?>

<div style="margin:30px auto; padding:25px; max-width:850px; background:#fff; border-radius:12px; box-shadow:0 3px 10px rgba(0,0,0,0.1);">
    <h3 style="text-align:center; color:#333; margin-bottom:25px;" class="text-danger"> Chỉnh sửa sản phẩm</h3>

    <form method="POST" enctype="multipart/form-data" style="width:100%;">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            
            <div>
                <label style="font-weight:600;">Tên sản phẩm:</label>
                <input type="text" name="TenSP" value="<?= $sp['TenSP'] ?>" style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
            </div>

            <div>
                <label style="font-weight:600;">Mã loại sản phẩm:</label>
                <input type="text" name="MaLSP" value="<?= $sp['MaLSP'] ?>" style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
            </div>

            <div>
                <label style="font-weight:600;">Mã nhà cung cấp:</label>
                <input type="text" name="MaNCC" value="<?= $sp['MaNCC'] ?>" style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
            </div>

            <div>
                <label style="font-weight:600;">Giá gốc:</label>
                <input type="number" name="GiaGoc" value="<?= $sp['GiaGoc'] ?>" style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
            </div>

            <div>
                <label style="font-weight:600;">Giá giảm:</label>
                <input type="number" name="GiaGiam" value="<?= $sp['GiaGiam'] ?>" style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
            </div>
            <div style="grid-column: span 2;">
                <label style="font-weight:600;">Mô tả:</label>
                <textarea name="MoTa" rows="3" style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;"><?= $sp['MoTa'] ?></textarea>
             </div>
        </div>

         <div style="margin-top:20px; display:flex; align-items:center; gap:20px;">
            <div>
                <label style="font-weight:600;">Hình ảnh:</label><br>
                <input type="file" name="HinhAnh">
            </div>
            <div>
                <img src="../images/products/<?= $sp['HinhAnh'] ?>" alt="Ảnh sản phẩm" style="width:120px; height:120px; object-fit:cover; border-radius:8px; border:1px solid #ccc;">
            </div>
        </div>

      <div style="text-align:center; margin-top:30px; display:flex; justify-content:center; gap:15px;">
            <button type="submit" style="padding:12px 25px; background:#f60505ff; color:white; border:none; border-radius:6px; font-weight:600; cursor:pointer;">
                 Cập nhật sản phẩm
            </button>

            <a href="javascript:history.back()" style="padding:12px 25px; background:#6c757d; color:white; border:none; border-radius:6px; font-weight:600; text-decoration:none; display:inline-block;">
                 Quay lại
            </a>
        </div>

    </form>
</div>
