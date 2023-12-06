gsap.registerPlugin(ScrollTrigger);

document.addEventListener("DOMContentLoaded", function () {
  const screenWidth = window.innerWidth;
  const breakpoint = 641;

  const lawyerPublications = new Swiper(".lawyer-publications__swiper", {
    // Слайдер публикаций внизу страницы
    loop: true, // Бесконечная прокрутка
    // autoplay: {
    //   delay: 3000, // Время автопрокрутки в миллисекундах
    // },
    // centeredSlides: true,
    slidesPerView: 1,
    // spaceBetween: 20,
    navigation: {
      nextEl: ".lawyer-publications__swiper-button-next",
      prevEl: ".lawyer-publications__swiper-button-prev",
    },
    breakpoints: {
      320: {
        slidesPerView: 1,
        spaceBetween: 60,
      },
      640: {
        slidesPerView: 2,
        spaceBetween: 40,
      },
      960: {
        slidesPerView: 3,
        spaceBetween: 40,
      },
    },
  });

  //Анмиация декора в десктопной версии
  if (document.getElementById("lawyer-cases__decor-svg")) {
    new Vivus("lawyer-cases__decor-svg", {
      start: "inViewport",
      duration: 200,
    });
  }

  //Анимация скролла секции инфо на странице адвоката
  if (document.querySelector(".lawyer__info-wrapper")) {
    if (screenWidth >= breakpoint) {
      ScrollTrigger.create({
        trigger: ".lawyer__info-scroller",
        start: "top 10%",
        end: "bottom 90%",
        pin: ".lawyer__img-wrapper",
      });
    }
  }
});
