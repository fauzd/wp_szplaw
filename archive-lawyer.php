<?php get_header(); ?>

<main>
  <section class="lawyers">
    <div class="container lawyers__container">
      <h1 class="lawyers__title title">Адвокаты</h1>
      <div class="lawyers__description text animate-text">
        <p>Коллегию адвокатов возглавляют эксперты с более чем 11-летним стажем — Дмитрий Солдаткин, опытный адвокат по
          уголовным
          делам экономической направленности и Ольга Зеленая, специалист в области разрешения споров, семейного,
          налогового права.</p>
        <p>За последние два года коллегии удалось защитить Доверителей от претензий на сумму около 30 млрд рублей.</p>
        <p>Долгосрочными
          клиентами компании являются руководители банков, топ-менеджеры корпораций, крупные строительные, торговые и
          кредитные
          компании, публичные личности.</p>
      </div>
      <div class="lawyers__cards-wrapper">
        <?php
        $args = array(
          'post_type' => 'lawyer', // ваш CPT
          'posts_per_page' => -1, // получить всех адвокатов
          'orderby' => 'ID',       // сортировать по ID
          'order' => 'ASC'       // по возрастанию
        );
        $lawyers = new WP_Query($args);

        if ($lawyers->have_posts()):
          while ($lawyers->have_posts()):
            $lawyers->the_post();
            $lawyer_position = get_field('lawyer_position');
            $lawyer_image_id = get_post_thumbnail_id(get_the_ID());
            $lawyer_image_medium = wp_get_attachment_image_src($lawyer_image_id, 'medium-mobile')[0];
            $lawyer_image_large = wp_get_attachment_image_src($lawyer_image_id, 'large-mobile')[0];
            $lawyer_image_full = get_the_post_thumbnail_url(get_the_ID(), 'full');
            $lawyer_position = get_field('lawyer_position');
            ?>
            <div class="swiper-slide lawyers__slide">
                <div class="lawyers__slide-img-wrapper">
                    <picture>
                        <source media="(max-width: 960px)" srcset="<?php echo esc_url($lawyer_image_medium); ?>">
                        <source media="(max-width: 1920px)" srcset="<?php echo esc_url($lawyer_image_large); ?>">
                        <img src="<?php echo esc_url($lawyer_image_full); ?>" alt="<?php the_title_attribute(); ?>" class="lawyers__slide-img" loading="lazy">
                    </picture>
                  </div>
                  <div class="lawyers__slide-content">
                    <h2 class="lawyers__slide-name title">
                  <?php the_title(); ?>
                </h2>
                <p class="lawyers__slide-description text">
                  <?php echo esc_html($lawyer_position); ?>
                </p>
                <a href="<?php the_permalink(); ?>" class="lawyers__slide-btn btn-light">Подробнее</a>
              </div>
            </div>
          <?php
          endwhile;
          wp_reset_postdata();
        endif;
        ?>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>