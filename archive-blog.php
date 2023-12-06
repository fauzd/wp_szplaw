<?php get_header(); ?>

<main class="blog">
  <section class="blog-hero">
    <?php
    $page_id = 272;
    $image_url_large_desktop = get_the_post_thumbnail_url($page_id, 'large-desktop');
    $image_url_small_desktop = get_the_post_thumbnail_url($page_id, 'small-desktop');
    $image_url_large_tablet = get_the_post_thumbnail_url($page_id, 'large-tablet');
    $image_url_large_mobile = get_the_post_thumbnail_url($page_id, 'large-mobile');
    $default_image_url = get_template_directory_uri() . '/assets/images/blog-bg-lg.jpg';

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
      <img class="blog__bg-img bg-img" src="<?php echo esc_url($image_url_large_desktop); ?>">
    </picture>
  </section>
  <section class="blog__content">
    <div class="container blog__container">
      <div class="blog__title-wrapper ">
        <h1 class="blog__title title blog__title-wrapper-child">Блог</h1>
        <div class="blog__filter-swiper">
          <div class="blog__filter blog__title-wrapper-child swiper-wrapper">
            <div class="swiper-slide"><a href="#" class="blog__filter-link blog__filter-link--active btn"
                data-tag-id="1235813213455">
                Все записи
              </a></div>
            <?php
            $tag_args = array(
              'post_type' => 'post-type',
              'posts_per_page' => -1,
              'post_status' => 'publish',
            );

            $tags = new WP_Query($tag_args);

            if ($tags->have_posts()):
              while ($tags->have_posts()):
                $tags->the_post();
                ?>
                <div class="swiper-slide"><a href="#" class="blog__filter-link btn"
                    data-tag-id="<?php echo get_the_ID(); ?>">
                    <?php the_title(); ?>
                  </a></div>
                <?php
              endwhile;
              wp_reset_postdata();
            else:
              echo '<p>Записей нет.</p>';
            endif;
            ?>
          </div>
          <div class="date__wrapper">
            <input type="text" id="date-range" placeholder="Выберите диапазон дат" class="date__input text">
          </div>
        </div>
      </div>
      <div class="blog__cards-wrapper">
        <div class="blog__swiper-wrapper swiper-wrapper">
        </div>
        <div class="container loader__container">
          <div class="loader__wrapper">
            <i class="loader"></i>
          </div>
        </div>
      </div>
      <button class="btn blog__btn">Загрузить еще</button>
    </div>
  </section>
</main>

<?php get_footer(); ?>