<?php 

$custom_date = get_field('post_date'); // Получаем значение кастомного поля 'post_date'
?>
<div class="news__swiper-slide swiper-slide slide">
  <div class="news__slide-wrapper slide-wrapper">
    <div class="news__slide-date slide-date">
      <?php echo esc_html($custom_date); ?>
    </div>
    <p class="news__slide-text slide-text">
      <?php the_title(); ?>
    </p>
    <a href="<?php the_permalink(); ?>" class="news__slide-btn btn slide-btn">Подробнее</a>
  </div>
</div>