<?php
$page_title = 'Register';
include ('../includes/header.php');
// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require ('../includes/connect.php'); 
		
	$errors = array(); // Initialize an error array.
	$avatar = ''; // mặc định nếu không tải lên

    if (isset($_FILES['ImgUpload']) && $_FILES['ImgUpload']['error'] == 0) {
        
        $allowed = ['jpg','jpeg','png','gif']; // định dạng cho phép
        $file_name = $_FILES['ImgUpload']['name'];
        $file_tmp = $_FILES['ImgUpload']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        // Kiểm tra định dạng
        if (in_array($file_ext, $allowed)) {
            // Tạo tên file duy nhất
            $avatar = 'uploads/' . uniqid() . '.' . $file_ext;
            
            // Tạo thư mục nếu chưa tồn tại
            if (!is_dir('uploads')) {
                mkdir('uploads', 0777, true);
            }
            
            // Di chuyển file từ tmp lên server
            move_uploaded_file($file_tmp, $avatar);
        } else {
            $errors[] = 'Chỉ cho phép file ảnh jpg, jpeg, png, gif.';
        }
    }

	// Check for a first name:
	if (empty($_POST['Ho'])) {
		$errors[] = 'Bạn quên nhập họ.';
	} else {
		$ho = mysqli_real_escape_string($dbc, trim($_POST['Ho']));
	}
	
	// Tên
	if (empty($_POST['Ten'])) {
		$errors[] = 'Bạn quên nhập tên.';
	} else {
		$ten = mysqli_real_escape_string($dbc, trim($_POST['Ten']));
	}
	
	// Email
	if (empty($_POST['Email'])) {
		$errors[] = 'Bạn quên nhập email.';
	} else {
		$email = mysqli_real_escape_string($dbc, trim($_POST['Email']));
	}
	
	// Số điện thoại
	if (empty($_POST['SDT'])) {
		$errors[] = 'Bạn quên nhập số điện thoại.';
	} else {
		$sdt = mysqli_real_escape_string($dbc, trim($_POST['SDT']));
	}
	
	// Địa chỉ
	if (empty($_POST['DiaChi'])) {
		$errors[] = 'Bạn quên nhập địa chỉ.';
	} else {
		$diachi = mysqli_real_escape_string($dbc, trim($_POST['DiaChi']));
	}
	
	// Mật khẩu và xác nhận
	if (!empty($_POST['pass1'])) {
		if ($_POST['pass1'] != $_POST['pass2']) {
			$errors[] = 'Mật khẩu không khớp.';
		} else {
			$matkhau = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
		}
	} else {
		$errors[] = 'Bạn quên nhập mật khẩu.';
	}
	if (empty($errors)) { // If everything's OK.
	
		// Register the user in the database...
		$userid = 'U'.time();
		// Make the query:
		$q = "INSERT INTO Users 
        (UserID, Ho, Ten, Email, Matkhau, SDT, DiaChi, Role, Avatar, NgayTao, NgayCapNhat)
        VALUES
        ('$userid', '$ho', '$ten', '$email', SHA1('$matkhau'), '$sdt', '$diachi', 3, '$avatar', NOW(), NOW())";

		$r = @mysqli_query ($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.
		
			// Print a message:
			echo '<h1>Chúc mừng!</h1>
		<p>Bây giờ bạn đã đăng ký. Bạn sẽ có thể đăng nhập!</p><p><br /></p>';	
		
		} else { // If it did not run OK.
			
			// Public message:
			echo '<h1>Lỗi hệ thống</h1>
			<p class="error">Bạn không thể đăng ký do lỗi hệ thống. Chúng tôi xin lỗi vì sự bất tiện này.</p>'; 
			
			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
						
		} // End of if ($r) IF.
		
		mysqli_close($dbc); // Close the database connection.

		// Include the footer and quit the script:
		include ('../includes/footer.html'); 
		exit();
		
	} else { // Report the errors.
	
		echo '<h1>Lỗi!</h1>
		<p class="error">Có lỗi xảy ra<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p><p><br /></p>';
		
	} // End of if (empty($errors)) IF.
	
	mysqli_close($dbc); // Close the database connection.

} // End of the main Submit conditional.
?>
<link rel="stylesheet" href="/SHOPVNB/includes/css/styles.css" type="text/css" media="screen" />

 <form method="post" asp-action="SignUp">
     <div class="row g-5">
         <div class="col-md-12 col-lg-6 col-xl-5">
             <!-- Avatar Start -->
             <!-- Avatar -->
             <div class="w-50 justify-content-md-center"
                  style="position: relative; left: 50%; transform: translate(-50%)">
                 <img src="~/img/avatar-default.jpg"
                      class="img-fluid w-100"
                      id="image_preview"
                      style="
                                 aspect-ratio: 1;
                                 object-fit: cover;
                                 border-radius: 100%;
                                 box-shadow: 0 5px 15px 0 rgba(0, 0, 0, 0.25);
                             " />
             </div>
             <!-- Avatar End -->
             <!-- Menu Profile Start -->
             <div class="d-flex mt-5 justify-content-center">
                 <a class="btn btn-outline-danger" style="margin-right: 20px; position:relative">
                     <label style="font-size: 16px">Chọn ảnh đại diện</label>
                     <input type="file"
                            name="ImgUpload"
                            id="image_upload"
                            style="
                                     position: absolute;
                                     width: 100%;
                                     height: 100%;
                                     top: 0;
                                     left: 0;
                                     opacity: 0;
                                 " />
                 </a>
             </div>
             <!-- Menu Profile End -->
         </div>

         <div class="col-md-12 col-lg-6 col-xl-7">
             <div class="row">
                 <div class="col-md-12 col-lg-6">
                     <div class="form-item w-100">
                         <label class="form-label my-3">Họ </label><br>
                          <input type="text" name="Ho" value="<?php if(isset($_POST['Ho'])) echo $_POST['Ho']; ?>" />
                     </div>
                 </div>
                 <div class="col-md-12 col-lg-6">
                     <div class="form-item w-100">
                        <label class="form-label my-3">Tên</label><br>
                        <input type="text" name="Ten"  value="<?php if(isset($_POST['Ten'])) echo $_POST['Ten']; ?>" />
                     </div>
                 </div>
             </div>
             <div class="form-item">
                 <label class="form-label my-3">Số điện thoại</label><br>
                 <input type="text" name="SDT" maxlength="15" value="<?php if(isset($_POST['SDT'])) echo $_POST['SDT']; ?>" />
             </div>
             
             <div class="form-item">
                 <label class="form-label my-3">Email </label><br>
                  <input type="text" name="Email" maxlength="100" value="<?php if(isset($_POST['Email'])) echo $_POST['Email']; ?>" />
             </div>
             <div class="form-item">
                 <label class="form-label my-3">Địa chỉ <sup></sup></label><br>
                  <input type="text" name="DiaChi" maxlength="255" value="<?php if(isset($_POST['DiaChi'])) echo $_POST['DiaChi']; ?>" />
             </div>
             <div class="form-item">
                 <label class="form-label my-3">Mật khẩu</label><br>
                  <input type="password" name="pass1" maxlength="50" />
             </div> <div class="form-item">
                 <label class="form-label my-3">Xác nhận mật khẩu</label><br>
                 <input type="password" name="pass2" maxlength="50" />
             </div>
             <div class="form-item my-3">
                 <button type="submit" class="btn btn-danger">
                     <span class="mx-3" style="color: white"> Đăng ký </span>
                 </button>
             </div>
         </div>
     </div>
 </form>
<script>
document.getElementById('image_upload').addEventListener('change', function(event){
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('image_preview').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
});
</script>

<?php include ('../includes/footer.html'); ?>