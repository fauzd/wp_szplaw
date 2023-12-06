<?php $post_date = get_field('post_date'); ?>

<div class="blog__swiper-slide slide">
  
  <div class="blog__slide-wrapper slide-wrapper">
    <div class="blog__slide-date slide-date">
      <?php echo esc_html($post_date); ?>
    </div>
    <p class="blog__slide-text slide-text text">
      <?php the_title(); ?>
    </p>
    <a href="<?php the_permalink(); ?>" class="blog__slide-btn btn slide-btn">Подробнее</a>
  </div>
</div>