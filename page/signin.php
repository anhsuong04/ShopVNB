<?php
include '../includes/connect.php';
include '../includes/header.php'; // header có session_start sẵn

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    $query = "SELECT * FROM Users WHERE Email='$email' AND MatKhau='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user'] = $user;
        echo "<script>window.location='../index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Sai Email hoặc mật khẩu!');</script>";
    }
}
?>

<!-- GIAO DIỆN ĐĂNG NHẬP -->
<section class="d-flex justify-content-center align-items-center" style="min-height: 80vh; background: #f8f9fa;">
    <div class="card shadow-lg border-0 rounded-4 p-4" style="width: 400px;">
        <div class="text-center mb-4">
            <img src="/SHOPVNB/images/logo/logo.png" alt="Logo" style="height: 60px;">
            <h4 class="mt-3 fw-bold text-danger">Đăng nhập tài khoản</h4>
            <p class="text-muted small">Chào mừng bạn đến với <b>VNB Shop</b></p>
        </div>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control form-control-lg" placeholder="Nhập email của bạn" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Mật khẩu</label>
                <input type="password" name="password" class="form-control form-control-lg" placeholder="Nhập mật khẩu" required>
            </div>

            <button type="submit" name="login" class="btn btn-danger w-100 py-2 fw-semibold">
                <i class="bi bi-box-arrow-in-right me-1"></i> Đăng nhập
            </button>
        </form>

        <div class="text-center mt-3">
            <p class="mb-1 text-muted">Chưa có tài khoản?</p>
            <a href="signup.php" class="text-decoration-none fw-semibold text-danger">Đăng ký ngay</a>
        </div>
    </div>
</section>

<?php include '../includes/footer.html'; ?>
