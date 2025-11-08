<?php
$page_title = 'Đăng ký tài khoản';
include('../includes/header.php');
require('../includes/connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    $avatar = 'default.jpg';

    // Upload ảnh đại diện
    if (isset($_FILES['ImgUpload']) && $_FILES['ImgUpload']['error'] == 0) {
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $file_name = $_FILES['ImgUpload']['name'];
    $file_tmp = $_FILES['ImgUpload']['tmp_name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (in_array($file_ext, $allowed)) {
        // Thư mục uploads cùng cấp với signup.php
        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        // Tạo tên file mới
        $newFileName = 'user_' . date('Ymd_His') . '.' . $file_ext;
        $uploadPath = $uploadDir . $newFileName;

        // Di chuyển file tạm sang thư mục uploads
        if (move_uploaded_file($file_tmp, $uploadPath)) {
            $avatar = $newFileName; // chỉ lưu tên file vào DB
        } else {
            $errors[] = 'Không thể tải ảnh lên. Vui lòng thử lại.';
        }
    } else {
        $errors[] = 'Chỉ cho phép định dạng ảnh JPG, JPEG, PNG, GIF.';
    }
}

    // Lấy dữ liệu từ form
    $ho = trim($_POST['Ho'] ?? '');
    $ten = trim($_POST['Ten'] ?? '');
    $email = trim($_POST['Email'] ?? '');
    $sdt = trim($_POST['SDT'] ?? '');
    $diachi = trim($_POST['DiaChi'] ?? '');
    $pass1 = $_POST['pass1'] ?? '';
    $pass2 = $_POST['pass2'] ?? '';

    // Kiểm tra hợp lệ
    if (empty($ho) || empty($ten) || empty($email) || empty($sdt) || empty($diachi) || empty($pass1) || empty($pass2))
        $errors[] = 'Vui lòng nhập đầy đủ thông tin.';
    if ($pass1 != $pass2)
        $errors[] = 'Mật khẩu không khớp.';
    
    if (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $email)) {
        $errors[] = 'Email phải có định dạng hợp lệ và kết thúc bằng @gmail.com.';
    }

    // Nếu không có lỗi
    if (empty($errors)) {
        $userid = 'U' . date('YmdHis');
        $matkhau = $pass1; // không hash mật khẩu

        $q = "INSERT INTO Users (UserID, Ho, Ten, Email, MatKhau, SDT, DiaChi, Role, Avatar, NgayTao, NgayCapNhat)
              VALUES ('$userid', '$ho', '$ten', '$email', '$matkhau', '$sdt', '$diachi', 3, '$avatar', NOW(), NOW())";
        $r = mysqli_query($conn, $q);

        if ($r) {
            echo "<script>
                    alert('Đăng ký thành công! Hãy đăng nhập để tiếp tục.');
                    window.location.href = 'signin.php';
                  </script>";
            exit();
        } else {
            $errors[] = 'Lỗi hệ thống: ' . mysqli_error($conn);
        }
    }
}
?>

<!-- ===================== GIAO DIỆN ĐĂNG KÝ ===================== -->
<link rel="stylesheet" href="/SHOPVNB/includes/css/styles.css" type="text/css" media="screen" />

<div class="container py-5">
  <div class="row justify-content-center align-items-center">
    <div class="col-md-8 col-lg-7 col-xl-6">
      <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
          <h2 class="text-center mb-4 text-danger fw-bold">Đăng ký tài khoản</h2>

          <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
              <?php foreach ($errors as $e) echo "- $e<br>"; ?>
            </div>
          <?php endif; ?>

          <form method="post" enctype="multipart/form-data">
            <!-- Ảnh đại diện -->
            <div class="text-center mb-3">
              <img src="uploads/default.jpg" id="avatarPreview" 
                   class="rounded-circle border border-2" 
                   style="width:120px;height:120px;object-fit:cover;box-shadow:0 4px 10px rgba(0,0,0,0.2)">
              <div class="mt-2">
                <label class="btn btn-outline-danger btn-sm mb-0">
                  <input type="file" name="ImgUpload" id="ImgUpload" hidden>
                  Chọn ảnh đại diện
                </label>
              </div>
            </div>

            <!-- Họ & Tên -->
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Họ</label>
                <input type="text" name="Ho" class="form-control" 
                       value="<?= htmlspecialchars($_POST['Ho'] ?? '') ?>">
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Tên</label>
                <input type="text" name="Ten" class="form-control" 
                       value="<?= htmlspecialchars($_POST['Ten'] ?? '') ?>">
              </div>
            </div>

            <!-- Thông tin cá nhân -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Email</label>
              <input type="email" name="Email" class="form-control" 
                     value="<?= htmlspecialchars($_POST['Email'] ?? '') ?>">
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">Số điện thoại</label>
              <input type="text" name="SDT" class="form-control" 
                     value="<?= htmlspecialchars($_POST['SDT'] ?? '') ?>">
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">Địa chỉ</label>
              <input type="text" name="DiaChi" class="form-control" 
                     value="<?= htmlspecialchars($_POST['DiaChi'] ?? '') ?>">
            </div>

            <!-- Mật khẩu -->
            <div class="mb-3">
              <label class="form-label fw-semibold">Mật khẩu</label>
              <input type="password" name="pass1" class="form-control">
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">Xác nhận mật khẩu</label>
              <input type="password" name="pass2" class="form-control">
            </div>

            <!-- Nút đăng ký -->
            <div class="d-grid">
              <button type="submit" class="btn btn-danger fw-bold py-2">Đăng ký</button>
            </div>

            <p class="text-center mt-3">
              Đã có tài khoản?
              <a href="login.php" class="text-danger fw-bold text-decoration-none">Đăng nhập ngay</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.getElementById('ImgUpload').addEventListener('change', function(e){
  const reader = new FileReader();
  reader.onload = function(){
    document.getElementById('avatarPreview').src = reader.result;
  }
  reader.readAsDataURL(e.target.files[0]);
});
</script>

<?php include('../includes/footer.html'); ?>
