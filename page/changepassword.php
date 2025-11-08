<?php
session_start();
$page_title = 'Đổi mật khẩu';
include '../includes/header.php';
require '../includes/connect.php';

// Lấy email: ưu tiên session (nếu user đã login)
$email_from_session = $_SESSION['user']['Email'] ?? null;
$messages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nếu session có email dùng session, còn không dùng input email trong form
    $email = $email_from_session ?: trim($_POST['email'] ?? '');

    $current = trim($_POST['pass'] ?? '');
    $new     = trim($_POST['pass1'] ?? '');
    $confirm = trim($_POST['pass2'] ?? '');

    // Validate
    if (empty($email))   $messages[] = 'Vui lòng nhập email hoặc đăng nhập trước khi đổi mật khẩu.';
    if (empty($current)) $messages[] = 'Vui lòng nhập mật khẩu hiện tại.';
    if (empty($new))     $messages[] = 'Vui lòng nhập mật khẩu mới.';
    if ($new !== $confirm) $messages[] = 'Mật khẩu mới và xác nhận không khớp.';

    if (empty($messages)) {
        // Lấy mật khẩu hiện tại từ DB
        $stmt = $conn->prepare("SELECT UserID, MatKhau FROM Users WHERE Email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $stmt->close();

        if (!$row) {
            $messages[] = 'Không tìm thấy tài khoản với email này.';
        } else {
            $dbPass = $row['MatKhau'];

            // Vì DB của bạn đang lưu plaintext (theo ví dụ), so sánh trực tiếp.
            // Nếu bạn dùng hash, thay bằng password_verify().
            if ($dbPass !== $current) {
                $messages[] = 'Mật khẩu hiện tại không đúng.';
            } else {
                // Cập nhật mật khẩu mới (lưu plaintext như hiện tại).
                $newPassToStore = $new; // nếu muốn hash: password_hash($new, PASSWORD_DEFAULT);

                $upd = $conn->prepare("UPDATE Users SET MatKhau = ? WHERE UserID = ?");
                $upd->bind_param("ss", $newPassToStore, $row['UserID']);
                $upd->execute();

                if ($upd->affected_rows > 0) {
	                $_SESSION['user']['MatKhau'] = $newPass;

                echo "<script>
                        alert('Đổi mật khẩu thành công!');
                        window.location.href = 'profile.php';
                      </script>";
                exit();
                } else {
                    $messages[] = 'Không thể cập nhật mật khẩu (không có thay đổi hoặc lỗi).';
                }
                $upd->close();
            }
        }
    }
}
?>

<!-- HTML form -->
<div class="container py-5" style="max-width:480px;">
  <div class="card shadow-sm">
    <div class="card-body p-4">
      <h3 class="mb-3 text-danger">Đổi mật khẩu</h3>

      <?php if (!empty($messages)): ?>
        <?php foreach ($messages as $m): ?>
          <div class="alert alert-info"><?= htmlspecialchars($m) ?></div>
        <?php endforeach; ?>
      <?php endif; ?>

      <form method="post" action="">
        <?php if (!$email_from_session): ?>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
          </div>
        <?php else: ?>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="text" class="form-control" readonly value="<?= htmlspecialchars($email_from_session) ?>">
          </div>
        <?php endif; ?>

        <div class="mb-3">
          <label class="form-label">Mật khẩu hiện tại</label>
          <input type="password" name="pass" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Mật khẩu mới</label>
          <input type="password" name="pass1" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Xác nhận mật khẩu mới</label>
          <input type="password" name="pass2" class="form-control" required>
        </div>

        <button class="btn btn-danger w-100" type="submit">Cập nhật mật khẩu</button>
        <a href="profile.php" class="btn btn-link mt-2 d-block text-center"> Quay lại hồ sơ</a>
      </form>
    </div>
  </div>
</div>

<?php include '../includes/footer.html'; ?>
