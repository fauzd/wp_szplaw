gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

document.addEventListener("DOMContentLoaded", function () {

  //Анимация списков
  function animateList(list) {
    gsap.fromTo(
      list.querySelectorAll(".practice-list__item"), // Анимируем каждый элемент списка,
      {
        opacity: 0,
        // yPercent: 100,
      },
      {
        duration: 1,
        opacity: 1,
        // yPercent: 0,
        stagger: 0.5,
      }
    );
  }

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
        stagger: 0.5,
      }
    );
  }

  document.querySelectorAll(".practice-list").forEach((list) => {
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

  //Анимация параграфов
  function animateText(container) {
    const paragraphs =
      container.tagName === "P" ? [container] : container.querySelectorAll("p");
    gsap.fromTo(
      paragraphs,
      { opacity: 0 },
      { opacity: 1, stagger: 0.5, duration: 1 }
    );
  }

  document.querySelectorAll(".animate-text").forEach((element) => {
    if (element.getBoundingClientRect().top < window.innerHeight) {
      // Если элемент уже видим при загрузке
      animateText(element);
    } else {
      // Если элемент появляется при скролле
      ScrollTrigger.create({
        trigger: element,
        start: "top 60%",
        onEnter: () => animateText(element),
        once: true, // Триггер сработает только один раз
      });
    }
  });

  //Общий случай анимации любого блока
  function animateOpacity(container) {
    gsap.fromTo(
      container,
      { opacity: 0 },
      { opacity: 1, duration: 1, delay: 1 }
    );
  }
  document.querySelectorAll(".animate-opacity").forEach((element) => {
    if (element.getBoundingClientRect().top < window.innerHeight) {
      // Если элемент уже видим при загрузке
      animateOpacity(element);
    } else {
      // Если элемент появляется при скролле
      ScrollTrigger.create({
        trigger: element,
        start: "top 60%",
        onEnter: () => animateOpacity(element),
        once: true, // Триггер сработает только один раз
      });
    }
  });

});

