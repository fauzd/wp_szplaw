<?php

$lawyer_ids = get_field('practice_lawyer');

if ($lawyer_ids) {
  // Если возвращается массив, работаем с первым элементом
  $lawyer_id = is_array($lawyer_ids) ? $lawyer_ids[0] : $lawyer_ids;

  $lawyer_title = get_the_title($lawyer_id);
  $lawyer_position = get_field('lawyer_position', $lawyer_id);
  
  $image_id = get_post_thumbnail_id($lawyer_id);
  $small_mobile = wp_get_attachment_image_src($image_id, 'small-mobile')[0];
  $medium_obile = wp_get_attachment_image_src($image_id, 'medium-mobile')[0];
  $large_mobile = wp_get_attachment_image_src($image_id, 'large-mobile')[0];
  $medium_tablet = wp_get_attachment_image_src($image_id, 'medium-tablet')[0];
  $small_desktop = wp_get_attachment_image_src($image_id, 'small-desktop')[0];
  $large_desktop = wp_get_attachment_image_src($image_id, 'large-desktop')[0];
}
?>

  <div class="container">
    <div class="services-details__lawyer-wrapper">
      <div class="services-details__lawyer-wrapper-child">
        <h2 class="services-details__lawyer-title title">Адвокат по практике</h2>
        <h3 class="services-details__lawyer-name title ">
          <?php echo esc_html($lawyer_title); ?>
        </h3>
        <p class="services-details__lawyer-position text animate-text">
          <?php echo esc_html($lawyer_position); ?>
        </p>
      </div>
      <div class="services-details__lawyer-wrapper-child services-details__lawyer-photo-wrapper">
        <picture>
              <source media="(max-width: 320px)" srcset="<?php echo esc_url($small_mobile); ?>">
          <source media="(max-width: 480px)" srcset="<?php echo esc_url($medium_mobile); ?>">
          <source media="(max-width: 640px)" srcset="<?php echo esc_url($large_mobile); ?>">
          <source media="(max-width: 768px)" srcset="<?php echo esc_url($medium_tablet); ?>">
          <source media="(max-width: 1280px)" srcset="<?php echo esc_url($small_desktop); ?>">
          <source media="(max-width: 1920px)" srcset="<?php echo esc_url($large_desktop); ?>">
          <img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title_attribute(); ?>" class="services-details__lawyer-photo">
        </picture>
      </div>
    </div>
  </div>
