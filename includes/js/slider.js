// Khởi tạo Swiper chính
document.addEventListener("DOMContentLoaded", function () {
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

// Swiper cho sản phẩm
document.addEventListener("DOMContentLoaded", () => {
  const swiperProduct = new Swiper(".mySwiperProduct", {
    slidesPerView: 4,
    spaceBetween: 20,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    breakpoints: {
      768: { slidesPerView: 2 },
      1024: { slidesPerView: 4 },
    },
  });

  const tabs = document.querySelectorAll(".tab");
  const products = document.querySelectorAll(".product-item");

  tabs.forEach(tab => {
    tab.addEventListener("click", () => {
      // Bỏ active tab cũ
      tabs.forEach(t => t.classList.remove("active"));
      tab.classList.add("active");

      const category = tab.dataset.category;

      products.forEach(item => {
        if (category === "all" || item.dataset.category === category) {
          item.style.display = "block";
        } else {
          item.style.display = "none";
        }
      });
      swiperProduct.update();
    });
  });
});
