<?php 
$page_title = 'Welcome to this Site!';
include ('includes/header.php');
include('includes/connect.php');

?>
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<link rel="stylesheet" href="/SHOPVNP/includes/css/styles.css" type="text/css" media="screen" />

<div class="body">
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
<section class="flash_sale">
  <div class="container">
    <div class="title">
      <h2>Sản phẩm mới nhất</h2>
    </div>

    <div class="tabs">
    <button class="tab active" data-category="all">Tất cả</button>
    <button class="tab" data-category="LSP001">Vợt cầu lông</button>
    <button class="tab" data-category="LSP002">Giày cầu lông</button>
    <button class="tab" data-category="LSP003">Áo cầu lông</button>
    <button class="tab" data-category="LSP004">Quần cầu lông</button>
    <button class="tab" data-category="LSP005">Váy cầu lông</button>
  </div>


    <div class="swiper mySwiperProduct">
      <div class="swiper-wrapper">
        <?php
        $sql = "SELECT MaSP, TenSP, GiaGoc, GiaGiam, HinhAnh, MaLSP FROM SanPham ORDER BY NgayTao DESC ";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "
            <div class='swiper-slide product-item' data-category='{$row['MaLSP']}'>
              <div class='product-card'>
                <div class='product-image'>
                  <img src='images/products/{$row['HinhAnh']}' alt='{$row['TenSP']}'>
                </div>
                <div class='product-info'>
                  <h3>{$row['TenSP']}</h3>
                  <p class='price'>".number_format($row['GiaGoc'],0,',','.')."₫</p>
                  <p class='pricesale'>".number_format($row['GiaGiam'],0,',','.')."₫</p>
                  <a href='/SHOPVNB/product/detail.php?MaSP={$row['MaSP']}' class='btn'>Xem chi tiết</a>
                </div>
              </div>
            </div>";
          }
        } else {
          echo "<p>Chưa có sản phẩm nào.</p>";
        }
        ?>
      </div>

      <!-- Nút điều hướng -->
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
  </div>
</section>
  <section class="sale">
        <div class="container">
          <div class="title">
            <h2><a href="">
              <span>Giảm giá</span>
            </a></h2>
          </div>
          <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 cl-xs-12">
              <div class="three_sale">
                <a href="">
                  <img src="images/sale/vot.webp">
                </a>
              </div>
            </div>
          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 cl-xs-12">
              <div class="three_sale">
                <a href="">
                  <img src="images/sale/ao.webp">
                </a>
              </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 cl-xs-12">
              <div class="three_sale">
                <a href="">
                  <img src="images/sale/giay.webp">
                </a>
              </div>
            </div>
          </div>
        </div>
  </section>
  <section class="section_banner">
    <div class="container">
        <div class="title">
            <h2><a href=""><span>Sản Phẩm Cầu Lông</span></a></h2>
        </div>

        <!-- Hàng 1: 3 banner -->
        <div class="row">
            <div class="col">
                <div class="snip_banner">
                  <a href="/SHOPVNB/product/index.php?maloai=LSP001">
                    <img src="images/logo/vot.webp" alt="">
                    <div class="container_banner"><p>Vợt Cầu Lông</p></div>
                  </a>
                   

                </div>
            </div>
            <div class="col">
                <div class="snip_banner">
                    <a href="/SHOPVNB/product/index.php?maloai=LSP002">
                      <img src="images/logo/giay.webp" alt="">
                    <div class="container_banner"><p>Giày Cầu Lông</p></div>
                    </a>
                </div>
            </div>
            <div class="col">
                <div class="snip_banner">
                   <a href="/SHOPVNB/product/index.php?maloai=LSP003">
                     <img src="images/logo/ao.webp" alt="">
                    <div class="container_banner"><p>Áo Cầu Lông</p></div>
                   </a>
                </div>
            </div>
        </div>

       <div class="row row-2">
            <div class="col-xl-2 col-sm-12">
                <div class="snip_banner">
                </div>
            </div>
            <div class="col-xl-4 col-sm-12">
                <div class="snip_banner">
                  <a href="/SHOPVNB/product/index.php?maloai=LSP005">
                    <img src="images/logo/vay.webp" alt="">
                    <div class="container_banner"><p>Váy Cầu Lông</p></div>
                  </a>
                </div>
            </div>
            <div class="col-xl-4 col-sm-12">
                <div class="snip_banner">
                    <a href="/SHOPVNB/product/index.php?maloai=LSP004">
                      <img src="images/logo/quan.webp" alt="">
                    <div class="container_banner"><p>Quần Cầu Lông</p></div>
                    </a>
                </div>
            </div>
            <div class="col-xl-2 col-sm-12">
                <div class="snip_banner">
                </div>
            </div>
        </div>
    </div>
</section>

</div>
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script src="includes/js/slider.js"></script>
<?php
include ('includes/footer.html');
?>