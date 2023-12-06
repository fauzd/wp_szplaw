<!DOCTYPE html>
<html <?php language_attributes() ?>>

<head>
  <meta charset="<?php bloginfo("charset"); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">

  <?php wp_head(); ?>
  <?php
  if (is_post_type_archive('lawyer') || is_singular('practice') || is_singular('lawyer') || is_singular('service') || is_page('contacts') || is_page('policy')): ?>
    <style>
      .header {
        background: #00201f !important;
      }
    </style>
  <?php endif; ?>
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


</head>

<?php
global $home_page_link;
$home_page_id = 8; // ID страницы Home
$home_page_link = get_permalink($home_page_id);

global $about_page_link;
$about_page_id = 109; // ID страницы About
$about_page_link = get_permalink($about_page_id);

global $contacts_page_link;
$contacts_page_id = 137; // ID страницы Contacts
$contacts_page_link = get_permalink($contacts_page_id);

global $policy_page_link;
$policy_page_id = 261; // ID страницы политики
$policy_page_link = get_permalink($policy_page_id);
?>

<body>

  <header class="header">
    <div class="container header__container">
      <?php
      $logo_url = get_field('logo', 8);
      $default_logo_url = get_stylesheet_directory_uri() . '/assets/images/logo-light.svg';
      $phone_default = get_field('phone_call', 8);
      $phone_default_formatted = format_phone_number($phone_default);
      $phone_wa = get_field('phone_wa', 8);
      $name_tg = get_field('name_tg', 8);
      $email = get_field('email', 8);


      if ($logo_url):
        ?>
        <a href="<?php echo esc_url($home_page_link); ?>" class="header__logo-link">
          <img class="header__logo logo" src="<?php echo esc_url($logo_url); ?>" alt="SZP logo">
        </a>
      <?php else: ?>
        <a href="<?php echo esc_url($home_page_link); ?>" class="header__logo-link">
          <img class="header__logo" src="<?php echo esc_url($default_logo_url); ?>" alt="SZP logo">
        </a>
      <?php endif; ?>

      <div class="header__links">
        <ul class="header__nav-list">
          <li class="header__item nav__item"><a href="<?php echo esc_url($about_page_link); ?>"
              class="header__link nav__link">О нас</a></li>
          <li class="header__item nav__item"><a href="<?php echo esc_url(get_post_type_archive_link('lawyer')); ?>"
              class="header__link nav__link">Адвокаты</a></li>
          <li class="header__item nav__item"><a href="<?php echo esc_url(get_post_type_archive_link('practice')); ?>"
              class="header__link nav__link">Услуги</a></li>
          <li class="header__item nav__item"><a href="<?php echo esc_url(get_post_type_archive_link('case')); ?>"
              class="header__link nav__link">Дела</a></li>
          <li class="header__item nav__item"><a href="<?php echo esc_url(get_post_type_archive_link('blog')); ?>"
              class="header__link nav__link">Блог</a></li>
          <li class="header__item nav__item"><a href="#" class="header__link nav__link search-mobile-btn">Поиск</a></li>
          <li class="header__item nav__item nav__item-wa"><a href="https://wa.me/<?php echo esc_attr($phone_wa); ?>"
              target="_blank" class="header__link header__link-wa">Написать в Whatsapp</a></li>
          <li class="header__item nav__item nav__item-tg "><a
              href="https://t.me/<?php echo esc_url(get_field('name_tg')); ?>" target="_blank"
              class="header__link header__link-tg">Написать в Telegram</a></li>
          <li class="header__item nav__item nav__item-phone"><a href="tel:<?php echo esc_attr($phone_default); ?>"
              class="header__link header__link-phone">
              <?php echo esc_attr($phone_default_formatted); ?>
            </a></li>
          <li class="header__item nav__item nav__item-mail "><a href="<?php echo esc_url($contacts_page_link); ?>"
              class="header__link header__link-mail">Контакты</a></li>
        </ul>
        <div class="header__search"><a href="#" class="header__search-link"><img class="header__search-icon"
              src="<?php bloginfo('template_url'); ?>/assets/images/icon-search.svg" alt=""></a></div>
      </div>
      <div class="header__burger">
        <span class="header__burger-line"></span>
        <span class="header__burger-line"></span>
        <span class="header__burger-line"></span>
      </div>
    </div>

    <div class="search-modal">
      <div class="search-modal__content">
        <h2 class="search-modal__title title">Поиск</h2>
        <form class="search-modal__form" action="#" method="get">
          <input class="search-modal__form-input text" type="text" name="search">
          <span class="search-modal__clear">&times;</span>
        </form>
        <div class="search-modal__results">
          <ul class="search-modal__results-list">

          </ul>
        </div>
      </div>
      <div class="search-modal__close"><span class="search-modal__close-cross">&times;</span></div>
    </div>

  </header>