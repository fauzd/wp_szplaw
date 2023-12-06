<div class="post__content-wrapper">
  <div class="post__content-top">
    <?php
    if (has_post_thumbnail()) {
      $image_id = get_post_thumbnail_id();
      $image_large = wp_get_attachment_image_src($image_id, 'blog-large')[0];
      $image_medium = wp_get_attachment_image_src($image_id, 'blog-medium')[0];
      $image_small = wp_get_attachment_image_src($image_id, 'blog-small')[0];
      ?>
      <picture>
        <source media="(max-width: 320px)" srcset="<?php echo esc_url($image_small); ?>">
        <source media="(max-width: 960px)" srcset="<?php echo esc_url($image_medium); ?>">
        <img src="<?php echo esc_url($image_large); ?>" alt="Обложка записи блога"
          class="post__content-img post__content-top-child">
      </picture>

      <?php
    }
    ?>
    <div class="post__content-info post__content-top-child">
      <div class="post__content-date case-number">
        <?php the_field('post_date'); ?>
      </div>
      <h1 class="post__content-title title">
        <?php the_title(); ?>
      </h1>
    </div>
  </div>
  <div class="post__content-text text">
    <?php echo apply_filters('the_content', get_the_content()); ?>
  </div>
  <?php

  $attachment = get_field('post_attachment');

  if ($attachment) { // Проверяем, есть ли информация о файле
    // Получаем URL и название файла из массива данных
    $file_url = $attachment['url'];
    $file_title = $attachment['title'];

    // Выводим ссылку для скачивания файла
    ?>
    <a href="<?php echo esc_url($file_url); ?>" class="post__btn btn" download>
      Скачать:
      <?php echo esc_html($file_title); ?>
    </a><br>
    <?php
  }
  ?>
</div>