<?php

function load_blog_ajax()
{
  $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
  $post_tag = isset($_POST['post_tag']) ? sanitize_text_field($_POST['post_tag']) : '';
  $start_date = isset($_POST['start_date']) ? sanitize_text_field($_POST['start_date']) : '';
  $end_date = isset($_POST['end_date']) ? sanitize_text_field($_POST['end_date']) : '';


  $args = array(
    'post_type' => 'blog',
    'posts_per_page' => 6,
    'offset' => $offset,
    'post_status' => 'publish',  // Только опубликованные записи
    'meta_key' => 'post_date', // Ключ кастомного поля даты
    'orderby' => 'meta_value', // Сортировка по значению кастомного поля
    'order' => 'DESC' // Последние записи первыми
  );

  $posts_query = array('relation' => 'AND');

  //Добавляем фильтрацию по рубрике
  if (!empty($post_tag) && $post_tag != 1235813213455) {
    $args['meta_query'] = array(
      array(
        'key' => 'post_type', 
        'value' => '"' . $post_tag . '"',
        'compare' => 'LIKE'
      )
    );
  }

  // Если заданы даты, добавляем их в запрос
  if (!empty($start_date) && !empty($end_date)) {
    $args['meta_query'][] = array(
      'key' => 'post_date',
      'value' => array($start_date, $end_date),
      'compare' => 'BETWEEN',
      'type' => 'DATE'
    );
  } elseif (!empty($start_date)) { // Одиночная дата
    $args['meta_query'][] = array(
      'key' => 'post_date',
      'value' => $start_date,
      'compare' => '=',
      'type' => 'DATE'
    );
  }

  $posts_query = new WP_Query($args);

  if ($posts_query->have_posts()) {
    ob_start(); // Начинаем буферизацию вывода
    while ($posts_query->have_posts()) {
      $posts_query->the_post();
      get_template_part('assets/templates/blog-med-template'); // Вывод информации о каждом деле с помощью шаблона
    }
    $posts_output = ob_get_clean(); // Получаем содержимое буфера

    // Определяем, есть ли еще записи после текущей страницы
    $more_posts = ($posts_query->found_posts > ($offset + $args['posts_per_page']));

    // Отправляем JSON-ответ
    wp_send_json(
      array(
        'posts' => $posts_output,
        'more_posts' => $more_posts
      )
    );
  } else {
    wp_send_json(
      array(
        'posts' => '',
        'more_posts' => false
      )
    );
  }

  wp_reset_postdata(); // Сбрасываем $post
  die();
}


add_action('wp_ajax_load_posts', 'load_blog_ajax');
add_action('wp_ajax_nopriv_load_posts', 'load_blog_ajax');

?>