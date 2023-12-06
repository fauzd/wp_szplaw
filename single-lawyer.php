<?php get_header(); ?>

<?php
$current_lawyer_id = get_the_ID(); // Получаем ID текущего адвоката
$current_lawyer_url = get_permalink(); // Ссылка на текущую страницу адвоката
$archive_link = get_post_type_archive_link('lawyer');
?>

<?php if (have_posts()):
  while (have_posts()):
    the_post();
    $image_id = get_post_thumbnail_id();
    $small_mobile = wp_get_attachment_image_src($image_id, 'small-mobile')[0];
    $medium_obile = wp_get_attachment_image_src($image_id, 'medium-mobile')[0];
    $large_mobile = wp_get_attachment_image_src($image_id, 'large-mobile')[0];
    $medium_tablet = wp_get_attachment_image_src($image_id, 'medium-tablet')[0];
    $small_desktop = wp_get_attachment_image_src($image_id, 'small-desktop')[0];
    $large_desktop = wp_get_attachment_image_src($image_id, 'large-desktop')[0];
    $archive_link = get_post_type_archive_link('lawyer');
    ?>
    <main>
      <section class="lawyer">
        <div class="container lawyer__nav">
          <a href="<?php echo esc_url($archive_link) ?>" class="lawyer__header subtitle back-button">Назад к списку
            адвокатов</a>
        </div>
        <div class="container lawyer__main-wrapper">
          <div class="lawyer__img-wrapper lawyer__main-wrapper-child">
            <picture>
              <source media="(max-width: 320px)" srcset="<?php echo esc_url($small_mobile); ?>">
              <source media="(max-width: 480px)" srcset="<?php echo esc_url($medium_mobile); ?>">
              <source media="(max-width: 640px)" srcset="<?php echo esc_url($large_mobile); ?>">
              <source media="(max-width: 768px)" srcset="<?php echo esc_url($medium_tablet); ?>">
              <source media="(max-width: 1280px)" srcset="<?php echo esc_url($small_desktop); ?>">
              <source media="(max-width: 1920px)" srcset="<?php echo esc_url($large_desktop); ?>">
              <img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title_attribute(); ?>"
                class="lawyer__title-photo">
            </picture>
          </div>
          <div class="lawyer__info-wrapper lawyer__main-wrapper-child">
            <div class="lawyer__info-scroller">
              <h1 class="lawyer__title title">
                <?php the_title(); ?>
              </h1>
              <h4 class="lawyer__subtitle">
                <?php the_field('lawyer_position'); ?>
              </h4>
              <a href="mailto:#" class="lawyer__email text">
                <?php the_field('lawyer_email'); ?>
              </a>
              <h3 class="lawyer__education-title subtitle">Образование</h3>
              <div class="lawyer__education-value text">
                <?php the_field('lawyer_education'); ?>
              </div>
              <h3 class="lawyer__status-title subtitle">Статус</h3>
              <div class="lawyer__status-value text">
                <?php the_field('lawyer_status'); ?>
              </div>
              <h3 class="lawyer__specialization-title subtitle">Специализация</h3>
              <div class="text">
                <?php the_field('lawyer_specialization'); ?>
              </div>
            </div>
          </div>
        </div>
      </section>
      <?php
      // Аргументы для нового запроса
      $args = array(
        'post_type' => 'case', // тип поста - дело
        'posts_per_page' => 5,      // получить последние 5 дел
        'meta_query' => array(
          array(
            'key' => 'case_lawyers',   // ключ кастомного поля
            'value' => '"' . $current_lawyer_id . '"', // поиск по ID адвоката
            'compare' => 'LIKE'            // поиск вхождения
          )
        )
      );

      // Создаем новый запрос
      $cases_query = new WP_Query($args);

      if ($cases_query->have_posts()): ?>
        <section class="lawyer-cases">
          <div class="container lawyer-cases__container">
            <div class="lawyer-cases__container-child">
              <h2 class="lawyer-cases__list-title title ">Дела</h2>
              <ul class="lawyer-cases__list practice-list">
                <?php while ($cases_query->have_posts()):
                  $cases_query->the_post();

                  $case_id = get_the_ID(); // ID дела
          
                  $archive_url = home_url('/case/'); // URL архивной страницы дел
                  $case_link = add_query_arg(['case_id' => $case_id, 'return_url' => urlencode($current_lawyer_url)], $archive_url);

                  echo '<li class="lawyer-cases__item practice-list__item">';
                  echo '<a href="' . esc_url($case_link) . '" class="lawyer-cases__link practice-list__link">' . get_the_title() . '</a>';
                  echo '</li>';
                endwhile;
                wp_reset_postdata(); ?>
              </ul>
            </div>
            <div class="lawyer-cases__container-child lawyer-cases__decor">
              <object id="lawyer-cases__decor-svg" class="lawyer-cases__decor-svg" type="image/svg+xml"
                data="<?php bloginfo('template_url'); ?>/assets/images/lawyer-decor.svg"></object>
              <img src="<?php bloginfo('template_url'); ?>/assets/images/lawyer-decor-bg.jpg" alt=""
                class="lawyer-cases__decor-img" loading="lazy">
            </div>
          </div>
        </section>
      <?php else: ?>
        <style>
          .lawyer-publications {
            background: white;
          }

          .news__slide-wrapper {
            background-color: #F3F1E4;
          }
        </style>
      <?php endif; ?>

      <?php
      $args = array(
        'post_type' => 'blog',
        'posts_per_page' => 6,
        'post_status' => 'publish',  // Только опубликованные записи
        'meta_key' => 'post_date', // Ключ кастомного поля даты
        'orderby' => 'meta_value', // Сортировка по значению кастомного поля
        'order' => 'DESC',
        'meta_query' => array(
          array(
            'key' => 'post_autor',
            'value' => '"' . $current_lawyer_id . '"', // поиск по ID адвоката
            'compare' => 'LIKE'
          )
        )
      );
      $news = new WP_Query($args);

      if ($news->have_posts()): ?>
        <section class="lawyer-publications">
          <div class="container lawyer-publications__container swiper__container">
            <h2 class="lawyer-publications__title title swiper__title">Публикации</h2>
            <div class="lawyer-publications__swiper swiper">
              <div class="lawyer-publications__swiper-wrapper swiper-wrapper">

                <?php
                while ($news->have_posts()) {
                  $news->the_post();
                  get_template_part('assets/templates/blog-short-template');
                }
                wp_reset_postdata();
                ?>

              </div>
            </div>
            <div class="lawyer-publications__swiper-button-prev swiper-button-prev"></div>
            <div class="lawyer-publications__swiper-button-next swiper-button-next"></div>
          </div>
        </section>
      <?php endif; ?>
    </main>

  <?php endwhile; endif; ?>

<?php get_footer(); ?>