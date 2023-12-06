gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

document.addEventListener("DOMContentLoaded", function () {
  let offset = 0; // Счетчик для отслеживания количества загруженных записей
  //Строки фильтрации по датам
  let startDate = "";
  let endDate = "";

  //Функция очистки строк с датами из календаря
  function clearDates() {
    startDate = "";
    endDate = "";
  }

  //Функция анмаиции скролла к началу списка
  function scrollToCaseCard() {
    gsap.to(window, {
      duration: 1,
      scrollTo: { y: ".blog__content", offsetY: 30 },
      ease: "power2.out",
    });
  }

  function clearList() {
    const area = document.querySelector(".blog__swiper-wrapper.swiper-wrapper");
    area.innerHTML = "";
    offset = 0;
    console.log("очищаем blog__swiper-wrapper");
  }

  function showLoader() {
    const loader = document.querySelector(".loader__container");
    loader.style.display = "flex";
  }

  function loadPosts(
    postTag = "",
    startDate = "",
    endDate = "",
    reset = false
  ) {
    document.querySelector(".blog__btn").style.display = "none";
    showLoader();

    const data = new FormData();
    data.append("action", "load_posts");
    data.append("post_tag", postTag);
    data.append("offset", reset ? 0 : offset);
    data.append("start_date", startDate);
    data.append("end_date", endDate);

    fetch(ajax_blog.ajax_url, {
      method: "POST",
      body: data,
    })
      .then((response) => response.json())
      .then((response) => {
        const blogSwiperWrapper = document.querySelector(
          ".blog__swiper-wrapper.swiper-wrapper"
        );

        if (reset) {
          blogSwiperWrapper.innerHTML = "";
          offset = 0;
        }

        if (response.posts) {
          blogSwiperWrapper.insertAdjacentHTML("beforeend", response.posts);
          offset += 6;

          if (response.more_posts) {
            document.querySelector(".blog__btn").style.display = "block";
          } else {
            document.querySelector(".blog__btn").style.display = "none";
          }

          if (reset) {
            setTimeout(function () {
              scrollToCaseCard();
            }, 300);
          }
        } else {
          document.querySelector(".blog__btn").style.display = "none";
          blogSwiperWrapper.innerHTML =
            '<p class="text" style="text-align: center;">Таких постов не найдено</p>';
        }

        document.querySelector(".loader__container").style.display = "none";
      })
      .catch((error) => {
        console.log("AJAX error:", error);
      });
  }

  loadPosts();

  function getPostTag(element) {
    return element.getAttribute("data-tag-id");
  }

  document.querySelector(".blog__btn").addEventListener("click", function () {
    postTag = document.querySelector(".blog__filter-link--active");
    const postTagId = getPostTag(postTag);
    loadPosts(postTagId, startDate, endDate, false);
  });

  document.querySelectorAll(".blog__filter-link").forEach(function (link) {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      clearList();
      clearInput();

      document
        .querySelectorAll(".blog__filter-link")
        .forEach(function (otherLink) {
          otherLink.classList.remove("blog__filter-link--active");
        });

      this.classList.add("blog__filter-link--active");
      const postTag = getPostTag(this);
      loadPosts(postTag, "", "", true);
    });
  });

  //Фильтрация по датам
  function clearInput() {
    clearDates();
    const inputs = document.querySelectorAll(".date__input ");
    inputs.forEach(function (input) {
      if (input) {
        input.value = "";
      }
    });
  }

  clearInput();

  flatpickr("#date-range", {
    mode: "range",
    altInput: true,
    altFormat: "j M Y", // Формат для отображения пользователю
    dateFormat: "Ymd", // Формат для отправки в запросе
    locale: "ru",
    onChange: function (selectedDates, dateStr, instance) {
      // Меняем ширину инпута в зависимости от содержимого
      let temp = document.createElement("span");
      document.body.appendChild(temp);
      // Применяем стили, которые влияют на ширину текста
      temp.style.fontSize = window.getComputedStyle(instance.altInput).fontSize;
      temp.style.fontFamily = window.getComputedStyle(
        instance.altInput
      ).fontFamily;
      temp.style.fontWeight = window.getComputedStyle(
        instance.altInput
      ).fontWeight;
      temp.style.letterSpacing = window.getComputedStyle(
        instance.altInput
      ).letterSpacing;
      temp.style.paddingLeft = window.getComputedStyle(
        instance.altInput
      ).paddingLeft;
      temp.style.paddingRight = window.getComputedStyle(
        instance.altInput
      ).paddingRight;

      temp.style.visibility = "hidden";
      temp.style.position = "absolute";
      temp.style.whiteSpace = "nowrap";
      temp.textContent = instance.altInput.value;

      let width = temp.offsetWidth;
      document.body.removeChild(temp);

      instance.altInput.style.width = `${width + 10}px`;
    },
    onClose: function (selectedDates, dateStr, instance) {
      // Отдаем выбранные даты
      // Проверяем, выбран ли диапазон или одиночная дата
      const dates = dateStr.split(" — ");
      startDate = dates[0];
      endDate = dates[1] || startDate;

      clearList();
      showLoader();

      let activeTag = document.querySelector(".blog__filter-link--active");
      const postTag = getPostTag(activeTag);

      console.log("Грузим метку: ", postTag);
      console.log("Грузим начальную дату: ", startDate);
      console.log("Грузим конечную дату: ", endDate);

      loadPosts(postTag, startDate, endDate, true);
    },
  });
});
