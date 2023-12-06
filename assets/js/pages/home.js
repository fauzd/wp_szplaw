document.addEventListener("DOMContentLoaded", function () {
  const casesSwiper = new Swiper(".index-services__cases-swiper", {
    // Опции слайдера
    loop: true, // Бесконечная прокрутка
    autoplay: {
      delay: 3000, // Время автопрокрутки в миллисекундах
    },
    // centeredSlides: true,
    slidesPerView: 1,
    spaceBetween: 0,
    pagination: {
      el: ".swiper-pagination", // Элемент для отображения пагинации
      // bulletActiveClass: ".services__cases-bullet--active",
      // bulletClass: ".services__cases-bullet",
      clickable: "true",
    },
  });

  const newsSwiper = new Swiper(".news__swiper", {
    // Опции слайдера
    loop: true, // Бесконечная прокрутка
    // autoplay: {
    //   delay: 3000, // Время автопрокрутки в миллисекундах
    // },
    // centeredSlides: true,
    slidesPerView: 1,
    // spaceBetween: 20,
    navigation: {
      nextEl: ".news__swiper-button-next",
      prevEl: ".news__swiper-button-prev",
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

  const screenWidth = window.innerWidth;
  const breakpoint = 1000;

  //Анимация отрисовки SVG в секции hero
  if (document.getElementById("index-hero")) {
    var svgPath =
      screenWidth >= breakpoint
        ? "/assets/images/hero-bg-decor.svg"
        : "/assets/images/hero-bg-decor-sm.svg";
    new Vivus("index-hero", {
      duration: 200,
      file: homeParams.themeUrl + svgPath,
    });
  }

  //Анимация шторы, картинки и слогана на главной
  let heroTl = gsap.timeline();

  heroTl
    .to(".curtain", {
      opacity: 0,
      duration: 2,
      onComplete: function () {
        gsap.set(".curtain", { display: "none" }); // Установить display в конце анимации чтобы не перекрывала контент и ссылки
      },
    })
    .from(
      ".hero__bg-img",
      {
        duration: 10,
        // xPercent: -10,
        // yPercent: 10,
        scale: 1.3,
      },
      "<"
    )
    .fromTo(
      ".hero__title-1row",
      {
        scale: 1.5,
        opacity: 0,
      },
      {
        duration: 1.5,
        opacity: 1,
        scale: 1,
        transformOrigin: "right bottom",
      },
      "<"
    )
    .fromTo(
      ".hero__title-2row",
      {
        scale: 1.5,
        opacity: 0,
      },
      {
        opacity: 1,
        duration: 1.5,
        scale: 1,
        transformOrigin: "center bottom",
      },
      "<"
    )
    .fromTo(
      ".hero__title-3row",
      {
        scale: 1.5,
        opacity: 0,
      },
      {
        opacity: 1,
        duration: 1.5,
        scale: 1,
        transformOrigin: "center bottom",
      },
      "<"
    );

});
