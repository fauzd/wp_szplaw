<?php get_header(); ?>

<?php if (have_posts()):
  while (have_posts()):
    the_post();

    $related_post_ids = get_post_meta(get_the_ID(), 'post_type', true); // Получаем ID из кастомного поля

    $archive_link = get_post_type_archive_link('blog');


    if (!empty($related_post_id)) {
      $related_post = get_post($related_post_id); // Получаем запись по ID
      if ($related_post) {
        $related_post_title = $related_post->post_title; // Получаем заголовок записи
      }
    }
    ?>
    <main>
      <section class="blog-post-hero">
        <?php
        $page_id = 275;
        $image_url_large_desktop = get_the_post_thumbnail_url($page_id, 'large-desktop');
        $image_url_small_desktop = get_the_post_thumbnail_url($page_id, 'small-desktop');
        $image_url_large_tablet = get_the_post_thumbnail_url($page_id, 'large-tablet');
        $image_url_large_mobile = get_the_post_thumbnail_url($page_id, 'large-mobile');
        $default_image_url = get_template_directory_uri() . '/assets/images/blog-post-bg-lg.jpg';

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
            <img class="blog-post__bg-img bg-img" src="<?php echo esc_url($image_url_large_desktop); ?>">
          </picture>

      </section>
      <section class="blog-post-content">
        <article class="container post__container">
          <div class="post__header-wrapper">
            <a href="<?php echo esc_url($archive_link) ?>" class="post__header subtitle back-button">Назад в блог</a>
            <?php
            foreach ($related_post_ids as $related_post_id) {
              $related_post = get_post($related_post_id);
              if ($related_post) {
                echo '<a class="post__header-tag btn">' . esc_html($related_post->post_title) . '</a>';
              }
            }
            ?>
          </div>
          <?php get_template_part('assets/templates/blog-full-template'); ?>
      </section>
      <?php

      $current_post_id = get_the_ID(); // Получаем ID текущей записи
      $meta_query_conditions = array(); // Инициализируем пустой массив для условий
  
      foreach ($related_post_ids as $id) {
        $meta_query_conditions[] = array(
          'key' => 'post_type',
          'value' => $id,
          'compare' => 'LIKE'
        );
      }

      $args = array(
        'post_type' => 'blog',     // Ваш кастомный тип записи
        'posts_per_page' => 6,          // Ограничение количества записей
        'post_status' => 'publish',  // Только опубликованные записи
        'meta_key' => 'post_date', // Ключ кастомного поля даты
        'orderby' => 'meta_value', // Сортировка по значению кастомного поля
        'order' => 'DESC',     // Новые записи первыми
        'post__not_in' => array($current_post_id), // Исключить текущую запись
        'meta_query' => array(
          'relation' => 'OR', // Используем OR для выбора записей, соответствующих любому условию внутри
          ...$meta_query_conditions
        )
      );

      $blog_posts = new WP_Query($args);

      if ($blog_posts->have_posts()): ?>
        <section class="blog-recommendations">
          <div class="container blog-recommendations__container swiper__container">
            <h2 class="blog-recommendations__title title swiper__title">Рекомендованные новости</h2>
            <div class="blog-recommendations__swiper swiper">
              <div class="blog-recommendations__swiper-wrapper swiper-wrapper">

                <?php while ($blog_posts->have_posts()):
                  $blog_posts->the_post(); ?>
                  <div class="blog-recommendations__swiper-slide swiper-slide slide">
                    <div class="blog-recommendations__slide-wrapper slide-wrapper">
                      <div class="blog-recommendations__slide-date slide-date">
                        <?php echo esc_html(get_field('post_date'), true); ?>
                      </div>
                      <p class="blog-recommendations__slide-text slide-text">
                        <?php the_title(); ?>
                      </p>
                      <a href="<?php the_permalink(); ?>" class="blog-recommendations__slide-btn btn slide-btn">Подробнее</a>
                    </div>
                  </div>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>


              </div>
            </div>
            <div class="blog-recommendations__swiper-button-prev swiper-button-prev"></div>
            <div class="blog-recommendations__swiper-button-next swiper-button-next"></div>
          </div>
        </section>
      <?php endif; ?>
    </main>
  <?php endwhile; endif; ?>

<?php get_footer(); ?>