document.addEventListener("DOMContentLoaded", function () {
  // Обработка нажатия бургер меню
  document
    .querySelector(".header__burger")
    .addEventListener("click", function () {
      this.classList.toggle("open");
      document.querySelector(".header__nav-list").classList.toggle("open");
      document.body.classList.toggle("no-scroll");
    });
});
