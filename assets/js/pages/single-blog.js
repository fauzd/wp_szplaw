document.addEventListener("DOMContentLoaded", function () {

const blogRecommendations = new Swiper(".blog-recommendations__swiper", {
  // Опции слайдера
  loop: true, // Бесконечная прокрутка
  // autoplay: {
  //   delay: 3000, // Время автопрокрутки в миллисекундах
  // },
  // centeredSlides: true,
  slidesPerView: 1,
  // spaceBetween: 20,
  navigation: {
    nextEl: ".blog-recommendations__swiper-button-next",
    prevEl: ".blog-recommendations__swiper-button-prev",
  },
  breakpoints: {
    320: {
      slidesPerView: 1,
      spaceBetween: 60,
    },
    640: {
      slidesPerView: 2,
      spaceBetween: 30,
    },
    760: {
      slidesPerView: 3,
      spaceBetween: 30,
    },
  },
});

});