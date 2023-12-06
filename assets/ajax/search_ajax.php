<?php

function my_ajax_search()
{
  $search_query = sanitize_text_field($_POST['search']);
  $search_results = new WP_Query(
    array(
      'post_type' => array('case', 'blog'),
      's' => $search_query,
      //Вместе два поиска в лоб не работают
      //Если нужно будет сделать поиск по содержимому дел, 
      //то нужно будет дорабатывать. мб разбить на два запроса. 
      //Или по галке либо то либо то.
      // 'meta_query' => array(
      //   'relation' => 'OR',
      //   array(
      //     'key' => 'case_aim',
      //     'value' => $search_query,
      //     'compare' => 'LIKE'
      //   ),
      //   array(
      //     'key' => 'case_strategy',
      //     'value' => $search_query,
      //     'compare' => 'LIKE'
      //   ),
      //   array(
      //     'key' => 'case_result',
      //     'value' => $search_query,
      //     'compare' => 'LIKE'
      //   )
      // )
    )
  );

  if ($search_results->have_posts()) {
    while ($search_results->have_posts()) {
      $search_results->the_post();
      $post_type = get_post_type();
      $link = $post_type === 'blog' ? get_permalink() : '/case/?case_id=' . get_the_ID();

      echo '<li class="search-modal__results-item"><a class="search-modal__results-link text" href="' . esc_url($link) . '">' . get_the_title() . '</a></li>';
    }
  } else {
    echo '<li class="search-modal__results-item search-modal__results-link text">Ничего не найдено</li>';
  }

  

  wp_die();
}
add_action('wp_ajax_my_ajax_search', 'my_ajax_search');
add_action('wp_ajax_nopriv_my_ajax_search', 'my_ajax_search');


?>