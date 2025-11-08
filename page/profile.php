<?php
session_start();
include '../includes/connect.php';
include '../includes/header.php';

// Nếu chưa đăng nhập thì quay lại login
if (!isset($_SESSION['user'])) {
    echo "<script>window.location='login.php';</script>";
    exit();
}

// Lấy thông tin người dùng mới nhất từ DB (phòng khi avatar hoặc thông tin được cập nhật)
$userSession = $_SESSION['user'];
$email = mysqli_real_escape_string($conn, $userSession['Email']);
$sql = "SELECT * FROM Users WHERE Email = '$email' LIMIT 1";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Nếu không tồn tại (trường hợp bị xóa user) thì logout
if (!$user) {
    session_destroy();
    echo "<script>alert('Tài khoản không còn tồn tại.'); window.location='login.php';</script>";
    exit();
}

$hoTenDayDu = trim(($user['Ho'] ?? '') . ' ' . ($user['Ten'] ?? ''));
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hồ sơ cá nhân - ShopVNB</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
            margin: 0;
            padding: 0;
        }
        .profile-container {
            width: 400px;
            background: #fff;
            margin: 50px auto;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            text-align: center;
        }
        .profile-container img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 3px solid #4a90e2;
            object-fit: cover;
            margin-bottom: 15px;
        }
        h2 {
            color: #333;
            margin-bottom: 10px;
        }
        p {
            margin: 8px 0;
            color: #555;
            font-size: 15px;
        }
        .btn-1 {
            display: inline-block;
            padding: 10px 18px;
            margin-top: 20px;
            background: lightblue;
            color: white;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s ease;
        }
        .btn-1:hover {
            background: #357ABD;
        }
        .btn-logout {
            background: lightcoral;
        }
        .btn-logout:hover {
            background: #c0392b;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <?php
       
        $avatarURL = "uploads/" . $user['Avatar'];
        
        ?>
        <img src="<?php echo htmlspecialchars($avatarURL); ?>" alt="Avatar người dùng">

        <h2><?php echo htmlspecialchars($hoTenDayDu ?: 'Người dùng'); ?></h2>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['Email']); ?></p>
        <p><strong>SĐT:</strong> <?php echo htmlspecialchars($user['SDT'] ?? 'Chưa có'); ?></p>
        <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($user['DiaChi'] ?? 'Chưa có'); ?></p>

        <a href="logout.php" class="btn-1 btn-logout">Đăng xuất</a>
        <a href="changepassword.php" class="btn-1">Đổi mật khẩu</a>
    </div>
</body>
</html>

<?php include '../includes/footer.html'; ?>
