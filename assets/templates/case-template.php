<?php
// Получение кастомных полей из группы case_details
$case_number = get_field('case_details_case_number'); // Номер дела
$case_key_metric = get_field('case_details_case_key-metric'); // Ключевые метрики
$case_year = get_field('case_details_case_year'); // Год окончания
$case_lawyers = get_field('case_lawyers'); // Юристы (предполагается, что это массив ID)

// Получение информации о юристах
$lawyers_info = '';
if (!empty($case_lawyers)) {
  foreach ($case_lawyers as $lawyer_id) {
    $lawyer_post = get_post($lawyer_id);
    $lawyer_name = $lawyer_post->post_title; // Имя юриста
    $lawyer_position = get_field('lawyer_position', $lawyer_id); // Должность юриста
    $lawyers_info .= "<p class='case-details__description-text'>$lawyer_name<br>$lawyer_position</p>";
  }
}

// Дополнительные поля кейса
$case_aim = get_field('case_aim');
$case_strategy = get_field('case_strategy');
$case_result = get_field('case_result');

?>

<article class="case">
  <p class="case__number case-number">
    Дело №
    <?php echo esc_html($case_number); ?>
  </p>
  <h3 class="case__title subtitle">
    <?php the_title(); ?>
  </h3>
  <div class="case-details__content">
    <div class="case-details__wrapper case-details__content-child">
      <?php if (!empty($case_key_metric)): ?>
      <div class="case-details__key-metric">
        <h5 class="case-details__description-title case-metric__name">Ключевые цифры</h5>
        <div class="case-details__description-text">
          <?php echo $case_key_metric; ?>
        </div>
      </div>
      <?php endif; ?>
      <?php if (!empty($case_year)): ?>
        <div class="case-details__year">
          <h5 class="case-details__description-title case-metric__name">Год окончания</h5>
          <p class="case-details__description-text">
            <?php echo esc_html($case_year); ?>
          </p>
        </div>
      <?php endif; ?>
      <?php if (!empty($lawyers_info)): ?>
      <div class="case-details__lawyer">
        <h5 class="case-details__description-title case-metric__name">Юристы</h5>
        <?php echo $lawyers_info; ?>
      </div>
      <?php endif; ?>
    </div>
    <div class="case-details__description case-details__content-child">
      <h5 class="case-details__description-title case-metric__name">Постановка задачи</h5>
      <p class="case-details__description-text">
        <?php echo esc_html(strip_tags($case_aim)); ?>
      </p>
      <h5 class="case-details__description-title case-metric__name">Содержание услуг</h5>
      <p class="case-details__description-text">
        <?php echo esc_html(strip_tags($case_strategy)); ?>
      </p>
      <h5 class="case-details__description-title case-metric__name">Результат</h5>
      <p class="case-details__description-text">
        <?php echo esc_html(strip_tags($case_result)); ?>
      </p>
    </div>
  </div>
</article>