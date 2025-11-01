<?php 
$page_title = 'Welcome to this Site!';
include ('includes/header.php');
?>
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

<link rel="stylesheet" href="includes/css/style.css" type="text/css" media="screen" />
<div class="swiper mySwiper">
  <div class="swiper-wrapper">
    <div class="swiper-slide">
      <img src="images/slider/slider1.webp" alt="Banner 1">
    </div>
    <div class="swiper-slide">
      <img src="images/slider/slider2.webp" alt="Banner 2">
    </div>
    <div class="swiper-slide">
      <img src="images/slider/slider3.webp" alt="Banner 3">
    </div>
    <div class="swiper-slide">
      <img src="images/slider/slider4.webp" alt="Banner 4">
    </div>
  </div>
  <!-- Nút điều hướng -->
  <div class="swiper-button-prev"></div>
  <div class="swiper-button-next"></div>
  <!-- Pagination -->
  <div class="swiper-pagination"></div>
</div>
<div class="container">
  <div class= "row promo-box">
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <div class="promo-item">
        <div class="icon">
          <img width="50" height="50" src="images/icon/xetai.png" alt="van chuyen">
        </div>
        <div class="info">
          Vận chuyển 
          <span>TOÀN QUỐC</span>
          <br>
           thanh toán khi nhận hàng 
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <div class="promo-item">
        <div class="icon">
          <img width="50" height="50" src="images/icon/chatluong.png" alt="chat luong">
        </div>
        <div class="info">
          <span>Bảo đảm chất lượng</span>
          <br>
           Sản phẩm đảm bảo chất lượng
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <div class="promo-item">
        <div class="icon">
          <img width="50" height="50" src="images/icon/thanhtoan.jpg" alt="thanh toan">
        </div>
        <div class="info">
          Tiến hành 
          <span>THANH TOÁN</span>
          <br>
          với nhiều 
          <span>PHƯƠNG THỨC</span>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
      <div class="promo-item">
        <div class="icon">
          <img width="50" height="50" src="images/icon/doitra.jpeg" alt="doi tra">
        </div>
        <div class="info">
          <span>ĐỔi sản phẩm</span>
          <br>
           nếu sản phẩm bị lỗi 
        </div>
      </div>
    </div>
  </div>

</div>
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<!-- File JS riêng -->
<script src="includes/js/slider.js"></script>
<?php
include ('includes/footer.html');
?>