jQuery(document).ready(function ($) {
  let searchTimer;
  $(".search-modal__form-input").val("");

  // Функция для закрытия модального окна
  function closeModal() {
    $("body").removeClass("modal-open");
    $(".search-modal").css("display", "none");
    $(".search-modal__results-list").html("");
    $(".search-modal__form-input").val("");
    $(".search-modal__form-input").each(function () {
      toggleClearButton($(this));
    });
  }

  // Функция для открытия модального окна
  function openModal() {
    $(".search-modal").css("display", "flex"); // Отображение модального окна
    $("body").addClass("modal-open"); // Добавление класса к body
    $(".search-modal__form-input").focus(); // Установка фокуса на поле ввода
  }

  // Обработчик закрытия по клику на крестик
  $(".search-modal__close").on("click", function (e) {
    e.preventDefault();
    closeModal();
  });

  // Обработчик закрытия модального окна при клике вне контента
  $(".search-modal").on("click", function (e) {
    if (!$(e.target).closest(".search-modal__content").length) {
      closeModal();
    }
  });

  // Обработчик открытия модального окна десктоп
  $(".header__search-link").on("click", function (e) {
    e.preventDefault();
    openModal();
  });
  
  // Обработчик открытия модального окна мобильные
  $(".search-mobile-btn").on("click", function (e) {
    e.preventDefault();
    openModal();
    $(".header__burger").removeClass("open");
  });

  $(".search-modal__form input[name='search']").on("input", function () {
    clearTimeout(searchTimer);
    let searchValue = $(this).val();
    let form = $(".search-modal__form");

    searchTimer = setTimeout(function () {
      form.addClass("loading-animation");
      $(".search-modal__results-list").html("");

      $.ajax({
        url: ajax_search.ajax_url,
        type: "post",
        data: {
          action: "my_ajax_search",
          search: searchValue,
        },
        success: function (response) {
          $(".search-modal__results-list").html(response);
        },
        error: function (xhr, status, error) {
          // Обработка ошибки
          $(".search-modal__results-list").html(
            '<li class="search-modal__results-item">Произошла ошибка при поиске. Пожалуйста, попробуйте позже.</li>'
          );
          console.error("Ошибка AJAX-запроса: " + status + ", " + error);
        },
        complete: function () {
          form.removeClass("loading-animation");
        },
      });
    }, 500);
  });

  // Функция для обновления отображения крестика
  function toggleClearButton(input) {
    let clearButton = input.siblings(".search-modal__clear");
    if (input.val().length > 0) {
      clearButton.show();
    } else {
      clearButton.hide();
    }
  }

  // Отображение или скрытие крестика в зависимости от наличия текста
  $(".search-modal__form-input").on("input", function () {
    toggleClearButton($(this));
  });

  // Очистка поля ввода и скрытие крестика при нажатии на него
  $(".search-modal__clear").on("click", function () {
    $(this).siblings(".search-modal__form-input").val("").focus();
    $(this).hide();
    $(".search-modal__results-list").html("");
  });

  // Первоначальная инициализация состояния крестика
  $(".search-modal__form-input").each(function () {
    toggleClearButton($(this));
  });
});
