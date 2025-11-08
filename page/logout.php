<?php
session_start();

session_unset();
session_destroy();

$redirect_page = "../index.php";
?>

<?php include('../includes/header.php'); ?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng xuất - ShopVNB</title>
  <meta http-equiv="refresh" content="3;url=<?php echo $redirect_page; ?>">
  <style>
    body {
        font-family: "Segoe UI", Arial, sans-serif;
        background: #f8f9fa;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .logout-wrapper {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        min-height: 80vh;
    }
    .logout-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        text-align: center;
        padding: 40px 50px;
        animation: fadeIn 0.8s ease-in-out;
        max-width: 400px;
    }
    .logout-container img {
        width: 90px;
        height: 90px;
        object-fit: contain;
        margin-bottom: 15px;
    }
    h1 {
        color: #dc3545;
        margin-bottom: 10px;
    }
    p {
        color: #555;
        margin-bottom: 10px;
    }
    a {
        color: #dc3545;
        text-decoration: none;
        font-weight: bold;
    }
    a:hover {
        text-decoration: underline;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body>
  <div class="logout-wrapper">
    <div class="logout-container">
      <img src="/SHOPVNB/images/logo/logo.png" alt="Logo" style="height: 60px;">
      <h1>Đăng xuất thành công!</h1>
      <p>Bạn sẽ được chuyển hướng về trang chủ trong 3 giây...</p>
      <p>Hoặc <a href="<?php echo $redirect_page; ?>">nhấn vào đây</a> nếu không muốn đợi.</p>
    </div>
  </div>

  
</body>
</html>
<?php include('../includes/footer.html'); ?>