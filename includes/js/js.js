// Khởi tạo Swiper
document.addEventListener("DOMContentLoaded", function() {
    const swiper = new Swiper(".mySwiper", {
        loop: true,              
        autoplay: {
            delay: 4000,        
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        speed: 600,              
    });
});
