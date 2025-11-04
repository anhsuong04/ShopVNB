<?php
include('../includes/header.php');
?>
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <div class="col-12">
                    <div class="text-center mx-auto" style="max-width: 700px;">
                        <h1 class="text-danger">Liên hệ </h1>
                        <p class="mb-4">Biểu mẫu liên hệ hiện không hoạt động. Nhận biểu mẫu liên hệ chức năng và hoạt động với Ajax & PHP trong vài phút. Chỉ cần sao chép và dán các tệp, thêm một chút mã và bạn đã hoàn tất. <a href="https://htmlcodex.com/contact-form" class="text-danger">Tải xuống ngay</a>.</p>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="h-100 rounded">
                        <iframe class="rounded w-100"
                                style="height: 400px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3893323.8932460994!2d102.10998308619577!3d15.775376498204717!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135abb362bd10c9%3A0x8918057fd3e000b7!2zVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1694259649153!5m2!1svi!2s"
                                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="col-lg-7">
                    <form action="" class="">
                        <input type="text" class="w-100 form-control border-0 py-3 mb-4" placeholder="Tên của bạn">
                        <input type="email" class="w-100 form-control border-0 py-3 mb-4" placeholder="Nhập mail của bạn">
                        <textarea class="w-100 form-control border-0 mb-4" rows="5" cols="10" placeholder="Tin nhắn của bạn"></textarea>
                        <button class="w-100 btn form-control border-secondary py-3 bg-white text-danger " type="submit">Gửi</button>
                    </form>
                </div>
                <div class="col-lg-5">
                    <div class="d-flex p-4 rounded mb-4 bg-white">
                        <i class="fas fa-map-marker-alt fa-2x text-danger me-4"></i>
                        <div>
                            <h4>Địa chỉ</h4>
                            <p class="mb-2">126 Trần Quý Cáp, TP. Nha Trang, tỉnh Khánh Hòa</p>
                        </div>
                    </div>
                    <div class="d-flex p-4 rounded mb-4 bg-white">
                        <i class="fas fa-envelope fa-2x text-danger me-4"></i>
                        <div>
                            <h4>Gửi thư cho chúng tôi</h4>
                            <p class="mb-2">vnbshop@gmail.com</p>
                        </div>
                    </div>
                    <div class="d-flex p-4 rounded bg-white">
                        <i class="fa fa-phone-alt fa-2x text-danger me-4"></i>
                        <div>
                            <h4>Số điện thoại</h4>
                            <p class="mb-2">0901 234 567</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('../includes/footer.html');
?>