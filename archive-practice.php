<?php get_header(); ?>

<main>
  <section class="services-hero">
    <?php
    $page_id = 281;
    $image_url_large_desktop = get_the_post_thumbnail_url($page_id, 'large-desktop');
    $image_url_small_desktop = get_the_post_thumbnail_url($page_id, 'small-desktop');
    $image_url_large_tablet = get_the_post_thumbnail_url($page_id, 'large-tablet');
    $image_url_large_mobile = get_the_post_thumbnail_url($page_id, 'large-mobile');
    $default_image_url = get_template_directory_uri() . '/assets/images/services-bg-lg.jpg';

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
      <img class="services__bg-img bg-img" src="<?php echo esc_url($image_url_large_desktop); ?>">
    </picture>
  </section>
  <section class="services">
    <div class="container services__container">
      <div class="services__wrapper">
        <div class="services-entity services__wrapper-child">
          <h1 class="title" style="display: none;">Услуги</h1>
          <div class="services-entity__title services__title title">Юридическим
          лицам</div>
          <ul class="services-entity__list services-list practice-list">
            <li class="services-entity__item practice-list__item"><a href="<?php echo esc_html(get_permalink(53)); ?>" class="services-entity__link practice-list__link"><?php echo esc_html( get_the_title(53)); ?></a></li>
            <li class="services-entity__item practice-list__item"><a href="<?php echo esc_html(get_permalink(52)); ?>" class="services-entity__link practice-list__link"><?php echo esc_html(get_the_title(52)); ?></a></li>
            <li class="services-entity__item practice-list__item"><a href="<?php echo esc_html(get_permalink(49)); ?>" class="services-entity__link practice-list__link"><?php echo esc_html(get_the_title(49)); ?></a></li>
            <li class="services-entity__item practice-list__item"><a href="<?php echo esc_html(get_permalink(51)); ?>" class="services-entity__link practice-list__link"><?php echo esc_html(get_the_title(51)); ?></a></li>
          </div>
          <div class="services-individual services__wrapper-child">
            <h3 class="services-individual__title services__title title">Физическим
            лицам</h3>
            <ul class="services-individual__list services-list practice-list">
              <li class="services-individual__item practice-list__item"><a href="<?php echo esc_html(get_permalink(135)); ?>" class="services-individual__link practice-list__link"><?php echo esc_html(get_the_title(135)); ?></a></li>
              <li class="services-individual__item practice-list__item"><a href="<?php echo esc_html(get_permalink(54)); ?>" class="services-individual__link practice-list__link"><?php echo esc_html(get_the_title(54)); ?></a></li>
              <li class="services-individual__item practice-list__item"><a href="<?php echo esc_html(get_permalink(136)); ?>" class="services-individual__link practice-list__link"><?php echo esc_html(get_the_title(136)); ?></a></li>
              <li class="services-individual__item practice-list__item"><a href="<?php echo esc_html(get_permalink(50)); ?>" class="services-individual__link practice-list__link"><?php echo esc_html(get_the_title(50)); ?></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  </main>

<?php get_footer(); ?>