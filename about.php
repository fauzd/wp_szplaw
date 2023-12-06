<?php
/*
Template Name: about
*/
?>

<?php get_header(); ?>

<main class="about">
  <section class="about-hero">
    <?php
    $is_Custom_Img = get_field('about_bg_flag');
    $custom_Img_Url = get_field('about_bg_team');

    if (!$is_Custom_Img):
      ?>
      <picture>
        <source
          srcset="<?php bloginfo('template_url'); ?>/assets/images/about-bg-lg@3x.avif 3x, <?php bloginfo('template_url'); ?>/assets/images/about-bg-lg@2x.avif 2x, <?php bloginfo('template_url'); ?>/assets/images/about-bg-lg.avif 1x"
          type="image/avif">
        <source
          srcset="<?php bloginfo('template_url'); ?>/assets/images/about-bg-lg@3x.webp 3x, <?php bloginfo('template_url'); ?>/assets/images/about-bg-lg@2x.webp 2x, <?php bloginfo('template_url'); ?>/assets/images/about-bg-lg.webp 1x"
          type="image/webp">

        <img class="about__bg-img bg-img" src="<?php bloginfo('template_url'); ?>/assets/images/about-bg-lg.jpg">
      </picture>
    <?php else: ?>
      <?php
      $image_id = get_field('about_bg_team', false, false);

      if ($image_id) {
        echo wp_get_attachment_image($image_id, 'full', false, array('class' => 'about__bg-img bg-img'));
      }
      ?>
    <?php endif; ?>
  </section>
  <section class="about-content__top">
    <div class="container">
      <div class="about-content__top-wrapper">
        <div class="about-content__top-text">
          <h2 class="about-content__top-title title">LAW BOUTIQUE</h2>
          <div class="about-content__top-descr text animate-text">
            <?php
            $about_main = get_field('about_main');

            echo $about_main; ?>
          </div>
        </div>
        <div class="about-content__top-decor">
          <div class="about-content__top-decor-centerer">
            <picture>
              <source
                srcset="<?php bloginfo('template_url'); ?>/assets/images/about-decor-bg@3x.avif 3x, <?php bloginfo('template_url'); ?>/assets/images/about-decor-bg@2x.avif 2x, <?php bloginfo('template_url'); ?>/assets/images/about-decor-bg.avif 1x"
                type="image/avif">
              <source
                srcset="<?php bloginfo('template_url'); ?>/assets/images/about-decor-bg@3x.webp 3x, <?php bloginfo('template_url'); ?>/assets/images/about-decor-bg@2x.webp 2x, <?php bloginfo('template_url'); ?>/assets/images/about-decor-bg.webp 1x"
                type="image/webp">

              <img class="about-content__top-bg"
                src="<?php bloginfo('template_url'); ?>/assets/images/about-decor-bg.png" alt="Гимназия заглавное фото"
                loading="lazy">
            </picture>
            <object id="about-decor-bg" class="about-content__top-img" type="image/svg+xml"
              data="<?php bloginfo('template_url'); ?>/assets/images/about-bottom-decor.svg"></object>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="about-content__bottom">
    <div class="container">
      <h2 class="about-content__bottom-title title">Наши
        преимущества</h2>
      <div class="about-content__bottom-wrapper">
        <div class="about-content__bottom-descr">
          <?php
          $about_advantages = get_field('about_advantages');

          if ($about_advantages) {
            echo $about_advantages;
          }
          ?>
        </div>
      </div>
    </div>
  </section>
  <?php
  $args = array(
    'post_type' => 'blog', // Тип записи
    'posts_per_page' => -1,     // Количество записей для вывода, -1 для всех
    'meta_query' => array(  // Мета-запрос
      array(
        'key' => 'post_type', // Название кастомного поля
        'value' => '144',       // ID, который нужно найти
        'compare' => 'LIKE'       // Тип сравнения
      )
    )
  );

  $blog_posts = new WP_Query($args);

  if ($blog_posts->have_posts()): ?>
    <section class="reviews">
      <div class="container reviews__container">
        <h2 class="reviews__title title">Обзоры</h2>
        <div class="reviews-swiper swiper">
          <div class="reviews-swiper__wrapper swiper-wrapper">
            <?php while ($blog_posts->have_posts()):
              $blog_posts->the_post();
              $post_image_id = get_post_thumbnail_id(get_the_ID());
              $post_image_small = wp_get_attachment_image_src($post_image_id, 'blog-small')[0];
              $post_image_medium = wp_get_attachment_image_src($post_image_id, 'blog-medium')[0];
              $post_image_large = wp_get_attachment_image_src($post_image_id, 'blog-large')[0];
              $post_image_full = get_the_post_thumbnail_url(get_the_ID(), 'full'); // URL полноразмерного изображения
              $attached_files = get_attached_media('application/pdf', get_the_ID()); // Получаем прикрепленные файлы
              ?>
              <div class="reviews-slide swiper-slide">
                <div class="reviews-slide__title-wrapper">
                  <?php if ($post_image_full): ?>
                    <picture>
                      <source media="(max-width: 640px)" srcset="<?php echo esc_url($post_image_small); ?>">
                      <source media="(max-width: 960px)" srcset="<?php echo esc_url($post_image_medium); ?>">
                      <source media="(max-width: 1920px)" srcset="<?php echo esc_url($post_image_large); ?>">
                      <img src="<?php echo esc_url($post_image_full); ?>" alt="<?php the_title_attribute(); ?>"
                        class="reviews-slide__title-img" loading="lazy">
                    </picture>
                  <?php endif; ?>
                </div>
                <div class="reviews-slide__content-wrapper">
                  <p class="reviews-slide__content-date">
                    <?php echo esc_html(get_field('post_date'), true); ?>
                  </p>
                  <p class="reviews-slide__content-descr">
                    <?php the_title(); ?>
                  </p>
                  <?php if ($attached_files): ?>
                    <?php foreach ($attached_files as $attached_file): ?>
                      <a href="<?php echo esc_url(wp_get_attachment_url($attached_file->ID)); ?>"
                        class="reviews-slide__content-btn btn-light" download>Скачать</a>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
              </div>
              <?php
            endwhile;
            wp_reset_postdata();
            ?>
          </div>
        </div>
        <div class="reviews-swiper__button reviews-swiper__button-prev swiper-button-prev"></div>
        <div class="reviews-swiper__button reviews-swiper__button-next swiper-button-next"></div>
      </div>
    </section>
  <?php endif;
  ?>
</main>

<?php get_footer(); ?>