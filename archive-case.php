<?php get_header(); ?>

<main class="practice">
  <section class="practice-hero">
    <?php
    $page_id = 284;
    $image_url_large_desktop = get_the_post_thumbnail_url($page_id, 'large-desktop');
    $image_url_small_desktop = get_the_post_thumbnail_url($page_id, 'small-desktop');
    $image_url_large_tablet = get_the_post_thumbnail_url($page_id, 'large-tablet');
    $image_url_large_mobile = get_the_post_thumbnail_url($page_id, 'large-mobile');
    $default_image_url = get_template_directory_uri() . '/assets/images/practice-bg-lg.jpg';

    if (!$image_url_large_desktop) {
      // Если нет изображения, используем фолбэк
      $image_url_large_desktop = $default_image_url;
      $image_url_small_desktop = $default_image_url;
      $image_url_large_tablet = $default_image_url;
      $image_url_large_mobile = $default_image_url;
    }
    ?>
    <picture>
      <source media="(max-width: 640px)" srcset="<?php echo esc_url($image_url_large_mobile); ?>">
      <source media="(max-width: 1024px)" srcset="<?php echo esc_url($image_url_large_tablet); ?>">
      <source media="(max-width: 1280px)" srcset="<?php echo esc_url($image_url_small_desktop); ?>">
      <source media="(max-width: 1920px)" srcset="<?php echo esc_url($image_url_large_desktop); ?>">
      <img class="practice__bg-img bg-img" src="<?php echo esc_url($image_url_large_desktop); ?>">
    </picture>
  </section>
  <div class="case-filter-wrapper">
    <section class="practice-filter">
      <div class="container practice-container">
        <h1 class="practice-filter__title title">Практики</h1>
        <ul class="practice-filter__list practice-list">
          <li class="practice-filter__item practice-filter__item-wide">
            <a href="#" class="practice-filter__link" data-id="">Все практики</a>
          </li>
          <li class="practice-filter__item practice-list__item"><a href="#" class="practice-filter__link"
              data-id="52">Комплексное сопровождение бизнеса</a></li>
          <li class="practice-filter__item practice-list__item"><a href="#" class="practice-filter__link"
              data-id="53,135">Разрешение споров</a></li>
          <li class="practice-filter__item practice-list__item"><a href="#" class="practice-filter__link"
              data-id="51">Исполнительное производство</a></li>
          <li class="practice-filter__item practice-list__item"><a href="#" class="practice-filter__link"
              data-id="49,136">Уголовное право</a></li>
          <li class="practice-filter__item practice-list__item"><a href="#" class="practice-filter__link"
              data-id="54">Семейное право</a></li>
          <li class="practice-filter__item practice-list__item"><a href="#" class="practice-filter__link"
              data-id="50">Защита чести, достоинства и деловой репутации</a></li>
        </ul>
      </div>
    </section>
    <section class="section-case">
      <div class="container case__wrapper">
        <!-- записи будут тут: -->
      </div>
      <div class="container loader__container">
        <div class="loader__wrapper">
          <i class="loader"></i>
        </div>
      </div>
      <div class="container case__btn-wrapper">
        <a id="load-cases-button" class="btn case__btn load-more-btn">Загрузить еще</a>
        <a class="btn case__btn return-to-btn" href="
        <?php
        $return_url = isset($_GET['return_url']) ? urldecode($_GET['return_url']) : '';
        if (!empty($return_url)) {
          echo esc_url($return_url);
        }
        ?>">Назад</a>
      </div>
    </section>
  </div>
</main>

<?php get_footer(); ?>