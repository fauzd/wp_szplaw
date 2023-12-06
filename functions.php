<?php

add_action(
  'wp_enqueue_scripts',
  function () {
    wp_enqueue_style('swiper-bundle', get_template_directory_uri() . '/assets/css/swiper-bundle.min.css', array(), '1.0.2');
    wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/style.min.css', array(), '1.0.12');



    wp_enqueue_script('swiper-script', get_template_directory_uri() . '/assets/js/swiper-bundle.js', array(), '1.0.2', true);
    wp_enqueue_script('vivus', get_template_directory_uri() . '/assets/js/vivus.js', array(), '1.0.2', true);
    wp_enqueue_script('gsap', get_template_directory_uri() . '/assets/js/gsap.min.js', array(), '1.0.2', true);
    wp_enqueue_script('ScrollTrigger', get_template_directory_uri() . '/assets/js/ScrollTrigger.min.js', array('gsap'), '1.0.2', true);
    wp_enqueue_script('ScrollTo', get_template_directory_uri() . '/assets/js/ScrollToPlugin.min.js', array('gsap'), '1.0.2', true);
    wp_enqueue_script('header', get_template_directory_uri() . '/assets/js/pages/header.js', array('jquery', 'gsap'), '1.0.4', true);
    wp_enqueue_script('animations', get_template_directory_uri() . '/assets/js/animations.js', array('gsap'), '1.0.2', true);

    //Подключение скрипта главной страницы
    if (is_front_page() || is_home()) {
      wp_enqueue_script('home-script', get_template_directory_uri() . '/assets/js/pages/home.js', array('jquery'), '1.0.0', true);

      // Локализация скрипта
      wp_localize_script(
        'home-script',
        'homeParams',
        array(
          'themeUrl' => get_template_directory_uri()
        )
      );
    }

    // Подключение скриптов для страницы "О нас"
    if (is_page('about')) {
      wp_enqueue_script('about-script', get_template_directory_uri() . '/assets/js/pages/about.js', array('jquery'), '1.0.0', true);

    }

    // Подключение скриптов для архивной страницы "lawyer"
    if (is_post_type_archive('lawyer')) {
      wp_enqueue_script('lawyer-archive-script', get_template_directory_uri() . '/assets/js/pages/archive-lawyer.js', array('jquery'), '1.0.0', true);
    }

    // Подключение скриптов для страницы одиночной записи типа "lawyer"
    if (is_singular('lawyer')) {
      wp_enqueue_script('lawyer-single-script', get_template_directory_uri() . '/assets/js/pages/single-lawyer.js', array('jquery'), '1.0.0', true);
    }

    // Подключение скриптов для страницы одиночной записи типа "blog"
    if (is_singular('blog')) {
      wp_enqueue_script('blog-single-script', get_template_directory_uri() . '/assets/js/pages/single-blog.js', array('jquery'), '1.0.0', true);
    }
  }
);

add_theme_support('post-thumbnails');
add_theme_support('title-tag');
add_theme_support('custom-logo');

// Предварительная загрузка
function szplaw2023_preload_resources()
{
  $font_urls = array(
    get_template_directory_uri() . '/assets/fonts/Manrope-Regular.woff2',
    get_template_directory_uri() . '/assets/fonts/Manrope-Bold.woff2',
    get_template_directory_uri() . '/assets/fonts/Cormorant-Regular.woff2',
    get_template_directory_uri() . '/assets/fonts/CormorantSC-Regular.woff2',
    get_template_directory_uri() . '/assets/fonts/Manrope-Regular.woff',
    get_template_directory_uri() . '/assets/fonts/Manrope-Bold.woff',
    get_template_directory_uri() . '/assets/fonts/Cormorant-Regular.woff',
    get_template_directory_uri() . '/assets/fonts/CormorantSC-Regular.woff',
  );

  foreach ($font_urls as $font_url) {
    $font_name = pathinfo($font_url, PATHINFO_FILENAME); // Извлечение имени файла без расширения

    wp_register_style('szplaw2023-' . $font_name, false); // Регистрация стиля для каждого шрифта
    wp_enqueue_style('szplaw2023-' . $font_name);

  }

  echo '<link rel="preload" href="' . esc_url($font_urls[0]) . '" as="font" type="font/woff2">';
  echo '<link rel="preload" href="' . esc_url($font_urls[3]) . '" as="font" type="font/woff2">';


  //Картинки 
  if (is_front_page() && has_post_thumbnail()) {
    $image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large-desktop')[0];
    echo '<link rel="preload" href="' . esc_url($image_url) . '" as="image">';
  }


}
add_action('wp_head', 'szplaw2023_preload_resources');


//Меняем заголовки страниц
function szp_custom_title()
{
  if (is_front_page() || is_home()) {
    return get_bloginfo('name') . ' — Коллегия адвокатов';
  } elseif (is_page('about')) {
    return 'О нас — ' . get_bloginfo('name');
  } elseif (is_singular()) {
    $page_title = single_post_title('', false);

    return $page_title . ' — ' . get_bloginfo('name');

  } elseif (is_post_type_archive('lawyer')) {
    return 'Адвокаты — ' . get_bloginfo('name');
  } elseif (is_post_type_archive('practice')) {
    return 'Практики — ' . get_bloginfo('name');
  } elseif (is_post_type_archive('case')) {
    return 'Дела — ' . get_bloginfo('name');
  } elseif (is_post_type_archive('blog')) {
    return 'Блог — ' . get_bloginfo('name');
  } elseif (is_page('contacts')) {
    return 'Контакты — ' . get_bloginfo('name');
  } elseif (is_page('policy')) {
    return 'Политика конфиденциальности — ' . get_bloginfo('name');
  }
}
add_filter('pre_get_document_title', 'szp_custom_title');



// Вставляем текущую дату если не указана пользователем дата публикации в записях блога
function blog_post_date_auto_populate($post_id)
{
  // Проверяем, является ли запись типа "blog_post"
  if (get_post_type($post_id) !== 'blog') {
    return;
  }

  // Получаем значение поля "post_date"
  $field_value = get_field('post_date', $post_id);

  // Если значение поля пустое, то заполняем его текущей датой
  if (empty($field_value)) {
    $current_date = date('Y-m-d'); // формат для сохранения в базу данных
    update_field('post_date', $current_date, $post_id);
  }
}

// Добавляем функцию в хук save_post
add_action('save_post', 'blog_post_date_auto_populate');


//Страница дел. AJAX
require_once get_template_directory() . '/assets/ajax/load_cases_ajax.php';

function cases_scripts()
{
  if (is_post_type_archive('case') || is_singular('case')) {
    wp_enqueue_script('cases-ajax', get_template_directory_uri() . '/assets/js/pages/archive-case.js', array('jquery'), null, true);
  }

  wp_localize_script('cases-ajax', 'ajax_case', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'cases_scripts');



//Страница блога. AJAX
require_once get_template_directory() . '/assets/ajax/load_blog_ajax.php';

function blog_scripts()
{
  if (is_post_type_archive('blog') || is_singular('blog')) {
    wp_enqueue_script('blog-ajax', get_template_directory_uri() . '/assets/js/pages/archive-blog.js', array('jquery'), '1.0.10', true);
  }

  wp_localize_script('blog-ajax', 'ajax_blog', array('ajax_url' => admin_url('admin-ajax.php')));
}

add_action('wp_enqueue_scripts', 'blog_scripts');

//Поиск
require_once get_template_directory() . '/assets/ajax/search_ajax.php';

function search_scripts()
{

  wp_enqueue_script('search-ajax', get_template_directory_uri() . '/assets/js/modal/search.js', array('jquery'), null, true);
  wp_localize_script('search-ajax', 'ajax_search', array('ajax_url' => admin_url('admin-ajax.php')));
}

add_action('wp_enqueue_scripts', 'search_scripts');

// Подключаем файлы с пользовательскими функциями
require_once get_template_directory() . '/assets/custom-functions/phone-formatter.php';

function szplaw2023_add_image_sizes()
{
  // Добавляем новые размеры изображений фонового в секции О нас
  add_image_size('small-mobile', 320, 9999);  // Мобильные устройства
  add_image_size('medium-mobile', 480, 9999); // Большие мобильные
  add_image_size('large-mobile', 640, 9999);  // Мобильные Retina

  add_image_size('small-tablet', 641, 9999);  // Планшеты
  add_image_size('medium-tablet', 768, 9999); // Планшеты ландшафт
  add_image_size('large-tablet', 1024, 9999); // Небольшие десктопы
  add_image_size('small-desktop', 1280, 9999); // Средние десктопы
  add_image_size('large-desktop', 1920, 9999); // Большие десктопы

  //В блоге
  add_image_size('blog-large', 600, 400, true); // Для экранов 1920px и больше
  add_image_size('blog-medium', 450, 300, true); // Для экранов ~960px
  add_image_size('blog-small', 284, 190, true); // Для экранов 320px
}
add_action('after_setup_theme', 'szplaw2023_add_image_sizes');

add_filter('jpeg_quality', function ($arg) {
  return 90; // Установите качество JPEG (от 0 до 100)
});

?>