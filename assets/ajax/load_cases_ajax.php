<?php

function load_cases_ajax()
{
  $practice_ids = isset($_POST['practice_id']) ? $_POST['practice_id'] : array();
  $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
  $case_id = isset($_POST['case_id']) ? intval($_POST['case_id']) : '';

  $args = array(
    'post_type' => 'case',
    'posts_per_page' => 5,
    'offset' => $offset
  );

  // Добавляем фильтрацию по ID дела
  if (!empty($case_id)) {
    $args['p'] = $case_id; // Фильтрация по ID дела
  } elseif (!empty($practice_ids)) {
    $args['meta_query'] = array(
      'relation' => 'OR', // Используем OR для фильтрации по любому из ID
    );
    foreach ($practice_ids as $practice_id) {
      $args['meta_query'][] = array(
        'key' => 'case_practice-type',
        'value' => '"' . $practice_id . '"',
        'compare' => 'LIKE'
      );
    }
  }

  $cases_query = new WP_Query($args);

  if ($cases_query->have_posts()) {
    ob_start(); // Начинаем буферизацию вывода
    while ($cases_query->have_posts()) {
      $cases_query->the_post();
      get_template_part('assets/templates/case-template'); // Вывод информации о каждом деле с помощью шаблона
    }
    $cases_output = ob_get_clean(); // Получаем содержимое буфера

    // Определяем, есть ли еще записи после текущей страницы
    $more_cases = ($cases_query->found_posts > ($offset + $args['posts_per_page']));

    // Отправляем JSON-ответ
    wp_send_json(
      array(
        'cases' => $cases_output,
        'more_cases' => $more_cases
      )
    );
  } else {
    wp_send_json(
      array(
        'cases' => '',
        'more_cases' => false
      )
    );
  }

  wp_reset_postdata(); // Сбрасываем $post
  die();
}


add_action('wp_ajax_load_cases', 'load_cases_ajax');
add_action('wp_ajax_nopriv_load_cases', 'load_cases_ajax');

?>