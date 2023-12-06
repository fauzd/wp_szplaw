<?php
/*
Template Name: home
*/
?>

<?php get_header(); ?>

<main>
  <div class="curtain"></div>
  <section class="hero">
    <?php if (has_post_thumbnail()): ?>
      <picture>
        <source media="(max-width: 1024px)" srcset="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large-tablet'); ?>">
        <source media="(max-width: 1280px)" srcset="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'small-desktop'); ?>">
        <source media="(max-width: 1920px)" srcset="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large-desktop'); ?>">
        <img class="hero__bg-img bg-img" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>"
          alt="hero-bg-img.webp">
      </picture>
    <?php else: ?>
      <img class="hero__bg-img bg-img" src="<?php bloginfo('template_url'); ?>/assets/images/hero-bg-img.webp"
        alt="Заглавная заставка">
    <?php endif; ?>

    <div id="index-hero" class="hero__bg-decor-wrapper"></div>
    <div class="container hero__container">
      <div class="hero__content-wrapper">
        <h1 class="hero__title">
          <span class="hero__title-1row">Доверять,</span>
          <span class="hero__title-2row">когда</span>
          <span class="hero__title-3row">это важно</span>
        </h1>
      </div>
    </div>
  </section>
  <section class="index-services">
    <div class="container index-services__container">
      <div class="index-services__practices index-services__child">
        <h2 class="index-services__practices-title title practice-list__title">Практики</h2>
        <ul class="index-services__list practice-list">
          <?php
          // Собираем практики, отмеченные в админке к выводу на главную
          $args = array(
            'post_type' => 'practice',
            'posts_per_page' => -1,
            'fields' => 'ids', // Возвращает только ID постов
            'meta_query' => array(
              array(
                'key' => 'practice_main_flag',
                'value' => '1',
                'compare' => '=',
              ),
            ),
          );

          $query = new WP_Query($args);
          $practice_ids = $query->posts;

          // $practice_ids = [53, 54, 52, 49, 51];
          
          foreach ($practice_ids as $practice_id) {
            $permalink = get_permalink($practice_id);
            $title = get_the_title($practice_id);

            if (!$permalink)
              continue;
            ?>
            <li class="index-services__item practice-list__item">
              <a href="<?php echo esc_url($permalink); ?>" class="index-services__link practice-list__link">
                <?php echo esc_html($title); ?>
              </a>
            </li>
            <?php
          }
          ?>
        </ul>
      </div>
      <div class="index-services__cases index-services__child">
        <h2 class="index-services__cases-title title">Дела</h2>
        <div class="index-services__cases-swiper swiper-container">
          <div class="swiper-wrapper">
            <?php
            $args = array(
              'post_type' => 'case', // Замените 'case' на точное название вашего CPT
              'posts_per_page' => 6, // Получаем последние записи
              'post_status' => 'publish', // Только опубликованные записи
              'orderby' => 'date', // Сортировка по дате
              'order' => 'DESC', // Последние записи первыми
              'meta_query' => array(
                array(
                  'key' => 'case_details_case_key-metric',
                  'value' => '',
                  'compare' => '!='
                )
              )
            );
            $cases = new WP_Query($args);

            if ($cases->have_posts()) {
              while ($cases->have_posts()) {
                $cases->the_post();

                $case_key_metric = get_field('case_details_case_key-metric'); // Получаем значение кастомного поля
                $case_id = get_the_ID();
                $case_link = '/case/?case_id=' . $case_id;

                ?>
                <div class="index-services__cases-slide swiper-slide">
                  <div class="index-services__cases-slide-title">
                    <?php echo $case_key_metric; ?>
                  </div>
                  <p class="index-services__cases-slide-description">
                    <?php the_title(); ?>
                  </p>
                  <a href="<?php echo $case_link; ?>" class="index-services__cases-slide-btn btn">Подробнее</a>
                </div>
                <?php
              }
              wp_reset_postdata();
            }
            ?>
          </div>
          <div class="index-services__cases-pagination swiper-pagination"></div>
        </div>
      </div>
    </div>
  </section>
  <section class="news">
    <div class="container news__container swiper__container">
      <h2 class="news__title title swiper__title">Новости из блога</h2>
      <div class="news__swiper swiper">
        <div class="news__swiper-wrapper swiper-wrapper">
          <?php
          $args = array(
            'post_type' => 'blog',
            'posts_per_page' => 6,
            'post_status' => 'publish',  // Только опубликованные записи
            'meta_key' => 'post_date', // Ключ кастомного поля даты
            'orderby' => 'meta_value', // Сортировка по значению кастомного поля
            'order' => 'DESC' // Последние записи первыми
          );
          $news = new WP_Query($args);

          if ($news->have_posts()) {
            while ($news->have_posts()) {
              $news->the_post();

              get_template_part('assets/templates/blog-short-template');

            }
            wp_reset_postdata();
          }
          ?>
        </div>
      </div>
      <div class="news__swiper-button-prev swiper-button-prev"></div>
      <div class="news__swiper-button-next swiper-button-next"></div>
    </div>
  </section>
  <section class="recommendations">
    <object id="index-recommendations__bg" class="recommendations__bg" type="image/svg+xml"
      data="<?php bloginfo('template_url'); ?>/assets/images/recommendations-bg.svg"></object>
    <div class="container recommendations__container recommendations__swiper">
      <h2 class="recommendations__title title">Мы рекомендованы рейтингами:</h2>
      <div class="recommendations__content">
        <div class="recommendations-slide"><img
            src="<?php bloginfo('template_url'); ?>/assets/images/recommendations-logo-2.svg" alt=""
            class="recommendations__logo"></div>
        <div class="recommendations-slide"><img
            src="<?php bloginfo('template_url'); ?>/assets/images/recommendations-logo-3.svg" alt=""
            class="recommendations__logo"></div>
        <div class="recommendations-slide"><img
            src="<?php bloginfo('template_url'); ?>/assets/images/recommendations-logo-1.svg" alt=""
            class="recommendations__logo "></div>
        <div class="recommendations-slide"><img
            src="<?php bloginfo('template_url'); ?>/assets/images/recommendations-logo-4.svg" alt=""
            class="recommendations__logo"></div>
        <div class="recommendations-slide"><img
            src="<?php bloginfo('template_url'); ?>/assets/images/recommendations-logo-5.svg" alt=""
            class="recommendations__logo"></div>
        <div class="recommendations-slide"><img
            src="<?php bloginfo('template_url'); ?>/assets/images/recommendations-logo-6.svg" alt=""
            class="recommendations__logo"></div>
      </div>
    </div>
  </section>
</main>

<?php get_footer(); ?>