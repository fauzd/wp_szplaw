<footer class="footer">
  <div class="container footer__container">
    <div class="footer__top">
      <nav class="footer__nav">
        <ul class="footer__list">
          <li class="footer__list-item nav__item"><a href="<?php echo esc_url($GLOBALS['about_page_link']); ?>"
              class="footer__list-link nav__link">О нас</a></li>
          <li class="footer__list-item nav__item"><a href="<?php echo esc_url(get_post_type_archive_link('lawyer')); ?>"
              class="footer__list-link nav__link">Адвокаты</a></li>
          <li class="footer__list-item nav__item"><a
              href="<?php echo esc_url(get_post_type_archive_link('practice')); ?>"
              class="footer__list-link nav__link">Услуги</a></li>
          <li class="footer__list-item nav__item"><a href="<?php echo esc_url(get_post_type_archive_link('case')); ?>"
              class="footer__list-link nav__link">Дела</a></li>
          <li class="footer__list-item nav__item"><a href="<?php echo esc_url(get_post_type_archive_link('blog')); ?>"
              class="footer__list-link nav__link">Блог</a></li>
        </ul>
      </nav>
      <div class="footer__contacts-wrapper">
        <?php
        $phone_default = get_field('phone_call', 8);
        $phone_default_formatted = format_phone_number($phone_default);
        $phone_wa = get_field('phone_wa', 8);
        $name_tg = get_field('name_tg', 8);
        $email = get_field('email', 8);
        

        ?>
        <ul class="footer__contacts">
          <li class="footer__contacts-item footer__contacts-phone nav__item "><a href="tel:<?php echo esc_attr($phone_default); ?>"
              class="footer__contacts-link"><?php echo esc_attr($phone_default_formatted); ?></a></li>
          <li class="footer__contacts-item footer__contacts-mail nav__item "><a href="mailto:<?php echo esc_attr($email); ?>"
              class="footer__contacts-link"><?php echo esc_attr($email); ?></a></li>
          <li class="footer__contacts-item footer__contacts-tg nav__item "><a href="https://t.me/<?php echo esc_attr($name_tg); ?>" target="_blank"
              class="footer__contacts-link">Написать в телеграм</a></li>
          <li class="footer__contacts-item footer__contacts-wa nav__item "><a href="https://wa.me/<?php echo esc_attr($phone_wa); ?>"
              target="_blank" class="footer__contacts-link">Написать в Whatsapp</a></li>
          <li class="footer__contacts-item footer__contacts-location nav__item "><a
              href="<?php echo esc_url($GLOBALS['contacts_page_link']); ?>" class="footer__contacts-link">Москва,
              Космодамианская
              наб., д. 38, стр. 3</a></li>
        </ul>
      </div>
    </div>
    <div class="footer__bottom">
      <?php
      $logo_url = get_field('logo', 8);
      $default_logo_url = get_stylesheet_directory_uri() . '/assets/images/logo-light.svg';
      
      if ($logo_url):
        ?>
        <a href="<?php echo esc_url($GLOBALS['home_page_link']); ?>" class="footer__logo-link">
          <img src="<?php echo esc_url($logo_url); ?>" alt="логотип" class="footer__logo">
        </a>
      <?php else: ?>
        <a href="<?php echo esc_url($GLOBALS['home_page_link']); ?>" class="footer__logo-link">
          <img src="<?php echo esc_url($default_logo_url); ?>" alt="логотип" class="footer__logo">
        </a>
      <?php endif; ?>
      <img src="<?php bloginfo('template_url'); ?>/assets/images/footer-decor.svg" alt="" class="footer__decor">
      <div class="footer__credits">
        <p class="footer__credits-description">© 2016-
          <?php echo date("Y"); ?> Московская коллегия адвокатов «Солдаткин, Зеленая и Партнеры»
        </p>
        <a href="<?php echo esc_url($GLOBALS['policy_page_link']); ?>" class="footer__credits-policy">Политика конфиденциальности</a>
      </div>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
<script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/ru.js"></script>

</body>

</html>