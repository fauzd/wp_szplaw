gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

//Функция анмаиции скролла к карточке дела
function scrollToCaseCard() {
  gsap.to(window, {
    duration: 1,
    scrollTo: { y: ".case__wrapper", offsetY: 60 },
    ease: "power2.out",
  });
}

jQuery(document).ready(function ($) {
  let offset = 0; // Счетчик для отслеживания количества загруженных записей
  let caseIdFromUrl;
  let practiceIdFromUrl;

  updateBackButtonVisibility(); //Обновляем статус кнопки назад

  //Фунуция ктр проверяет наличие url в адресе
  function isReturnUrlresent() {
    returnUrl = new URLSearchParams(window.location.search).get("return_url");
    return returnUrl !== null;
  }

  //Фунуция ктр проверяет наличие параметров в адресе
  function isUrlParamPresent() {
    caseIdFromUrl = new URLSearchParams(window.location.search).get("case_id"); //Ищем номер конкретного дела в адресе;
    practiceIdFromUrl = new URLSearchParams(window.location.search).get(
      "practice_id"
    ); //То же для практики
    console.log("caseId: ", caseIdFromUrl);
    console.log("practiceId: ", practiceIdFromUrl);
    return caseIdFromUrl !== null || practiceIdFromUrl !== null;
  }

  console.log("practiceIdFromUrl: ", practiceIdFromUrl);

  //Функция ктр скрывает и отображает кнопку назад
  function updateBackButtonVisibility() {
    console.log("Проверка кнопки Назад");
    if (isReturnUrlresent()) {
      $(".return-to-btn").show();
      console.log("Покажем кнопку Назад");
    } else {
      $(".return-to-btn").hide();
      console.log("Спрячем кнопку Назад");
    }
  }

  //Основная функция загрузки дел
  function loadCases(practiceId = [], caseId = "", reset = false) {
    $(".load-more-btn").hide();
    $(".loader__container").show();

    $.ajax({
      url: ajax_case.ajax_url,
      type: "POST",
      data: {
        action: "load_cases",
        practice_id: practiceId, // Добавляем ID практики в данные запроса
        case_id: caseId, // Добавляем ID дела в данные запроса
        offset: reset ? 0 : offset, // Если происходит сброс, начинаем с первой записи
      },
      beforeSend: function () {
        if (reset) {
          console.log("очищаем страницу");
          $(".container.case__wrapper").empty(); // Очистка контейнера перед загрузкой новых записей
          offset = 0; // Сброс смещения
        }
      },
      success: function (response) {
        console.log("ajax success");
        if (reset) {
          $(".container.case__wrapper").empty(); // Очистка контейнера при фильтрации
          offset = 0; // Сброс смещения
        }

        if (response.cases) {
          $(".container.case__wrapper").append(response.cases);
          offset += 5; // Увеличение смещения
          if (response.more_cases) {
            console.log("есть еще посты");
            $(".load-more-btn").show(); // Показать кнопку, если есть еще записи
          } else {
            $(".load-more-btn").hide(); // Скрыть кнопку, если записей больше нет
          }
        } else {
          $(".load-more-btn").hide(); // Скрыть кнопку, если нет записей
          $(".container.case__wrapper").html(
            '<p class="text" style="text-align: center;"">Таких дел не найдено</p>'
          );
        }
        $(".loader__container").hide();

        //Если дело одно, то скроллим к нему
        if (isUrlParamPresent()) {
          scrollToCaseCard();
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("AJAX error:", textStatus, errorThrown);
      },
    });
  }

  //Смотрим если есть конкретный id дела в ссылке, если нет, загружаем все без фильтров
  if (isUrlParamPresent()) {
    console.log("loading case# ", caseIdFromUrl);
    console.log("loading practice ", practiceIdFromUrl);
    loadCases([practiceIdFromUrl], caseIdFromUrl, true);
  } else {
    console.log("loading no filter");
    loadCases();
    $(".practice-filter__item-wide")
      .find("a")
      .addClass("practice-filter__link--active");
  }

  //Обрабатываем полученные из аттрибутов значения
  function getPracticeId(element) {
    // Получение значения data-id и преобразование его в массив чисел
    const dataId = $(element).data("id");
    if (dataId) {
      return dataId.toString().split(",").map(Number);
    }
    return []; // Возвращаем пустой массив, если data-id не определен
  }

  //Обрабатываем нажати кнопки "показать еще"
  $(".load-more-btn").on("click", function () {
    $(".loader__container").show();
    const practiceId = getPracticeId(this);
    loadCases(practiceId, "", false);
  });

  //Обрабатываем клик по ссылкам фильтра
  $(".practice-filter__link").on("click", function (e) {
    e.preventDefault();

    $(".practice-filter__link").removeClass("practice-filter__link--active");
    $(this).addClass("practice-filter__link--active");

    const practiceId = getPracticeId(this);
    console.log("Кликнута ссылка: ", practiceId);
    loadCases(practiceId, "", true); // Загружаем записи с этим ID и сбрасываем текущий список

    // Очистка параметров case_id и return_url из URL
    const urlWithoutParams =
      window.location.protocol +
      "//" +
      window.location.host +
      window.location.pathname;
    window.history.pushState({ path: urlWithoutParams }, "", urlWithoutParams);

    updateBackButtonVisibility(); //Обновляем статус кнопки Назад
  });
});
