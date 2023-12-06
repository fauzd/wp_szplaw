<?php
/*
Template Name: contacts
*/
?>

<?php get_header(); ?>

<main>
  <section class="map">
    <iframe src="https://snazzymaps.com/embed/540974" width="100%" height="100%" style="border:none;"></iframe>
  </section>
  <section class="contacts">
    <div class="container">
      <h2 class="contacts__title title">Контакты</h2>
      <div class="contacts__data">
        <p class="contacts__phone text">T: <a href="tel: +74950664159" class="contacts__phone-link">+7 (495) 066-41-59</a> </p>
        <p class="contacts__address text">Москва, Космодамианская наб., д. 38, стр. 3</p>
        <p class="contacts__email text">E: <a href="mailto:info@szplaw.ru" class="contacts__email-link">info@szplaw.ru</a> </p>
      </div>
    </div>
  </section>
</main>

<?php get_footer(); ?>