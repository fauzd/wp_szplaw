document.addEventListener("DOMContentLoaded", function () {

//Анимация декора
if (document.getElementById("about-decor-bg")) {
  new Vivus("about-decor-bg", { start: "inViewport", duration: 200 });
}

//Слайдер обзоров
let reviewsSwiper = new Swiper(".reviews-swiper", {
  // Опции слайдера
  // loop: true, // Бесконечная прокрутка
  // autoplay: {
  //   delay: 3000, // Время автопрокрутки в миллисекундах
  // },
  centeredSlides: true,
  slidesPerView: 1,
  spaceBetween: 20,
  navigation: {
    nextEl: ".reviews-swiper__button-next",
    prevEl: ".reviews-swiper__button-prev",
  },
  pagination: {
    el: ".reviews-slide__swiper-pagination", // Элемент для отображения пагинации
    // bulletActiveClass: ".services__cases-bullet--active",
    // bulletClass: ".services__cases-bullet",
    clickable: "true",
  },
});

//Анимация списка преимуществ
document.querySelectorAll(".about-content__bottom-list").forEach((list) => {
  if (list.getBoundingClientRect().top < window.innerHeight) {
    // Если заголовок уже видим при загрузке
    animateList(list);
  } else {
    // Если заголовок появляется при скролле
    ScrollTrigger.create({
      trigger: list,
      start: "top 70%",
      onEnter: () => animateList(list),
      once: true, // Триггер сработает только один раз
    });
  }
});

function animateList(list) {
  gsap.fromTo(
    list.querySelectorAll(".about-content__bottom-item"), // Анимируем каждый элемент списка,
    {
      opacity: 0,
      // yPercent: 100,
    },
    {
      duration: 1,
      opacity: 1,
      // yPercent: 0,
      stagger: 0.2,
    }
  );
}
  
});