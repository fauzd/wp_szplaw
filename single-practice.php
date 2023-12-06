<?php get_header(); ?>

<?php if (have_posts()):
  while (have_posts()):
    the_post();
    $archive_link = get_post_type_archive_link('practice');
    ?>
    <main class="services-details">
      <section class="services-details__about">
        <div class="container">
          <a href="<?php echo esc_url($archive_link) ?>" class="services-details__back-btn back-button">Назад к списку
            услуг</a>
          <h1 class="services-details__title title">
            <?php the_title(); ?>
          </h1>
          <div class="services-details__description-wrapper">
            <div class="services-details__description-column">
              <h3 class="services-details__description-title subtitle">О практике</h3>
              <div class="services-details__description-text text animate-text">
                <?php the_field('practice_about'); ?>
              </div>
            </div>
            <div class="services-details__description-column animate-opacity">
              <h3 class="services-details__description-title subtitle">Мы предлагаем</h3>
              <div class="services-details__description-list text ">
                <?php the_field('practice_offer'); ?>
              </div>
            </div>
          </div>
        </div>
      </section>
      <?php
      $lawyer_ids = get_field('practice_lawyer');

      if ($lawyer_ids) { ?>
        <section class="services-details__lawyer">
          <?php get_template_part('assets/templates/practice-template'); ?>
        </section>
      <?php }
      $current_practice_id = get_the_ID(); // Получаем ID текущей практики
      $current_practice_url = get_permalink(); // URL текущей страницы-практики для построения ссылок возврата
      $filtered_cases_url = add_query_arg(
        array(
          'practice_id' => $current_practice_id,
          'return_url' => urlencode($current_practice_url)
        ),
        home_url('/case/')
      );

      ?>
      <?php
      // Параметры запроса для получения дел, связанных с текущей практикой
      $case_args = array(
        'post_type' => 'case',
        'posts_per_page' => 4,
        'post_status' => 'publish',
        'meta_key' => 'case_details_case_number', // Указываем ключ мета-поля для сортировки
        'orderby' => 'meta_value_num', // Сортируем как числа
        'order' => 'DESC', // Указываем направление сортировки - по убыванию
        'meta_query' => array(
          array(
            'key' => 'case_practice-type', // Поле, в котором сохранен ID практики
            'value' => '"' . $current_practice_id . '"', // ID текущей практики
            'compare' => 'LIKE'
          ),
        ),
      );

      // Выполняем запрос
      $cases_query = new WP_Query($case_args);

      if ($cases_query->have_posts()): ?>
        <section class="services-details__cases">
          <div class="container services-details__cases-container">
            <div class="services-details__cases-header">
              <h2 class="services-details__cases-title title">Дела</h2>
              <a href="<?php echo esc_url($filtered_cases_url); ?>" class="services-details__cases-forward forward-button">Все
                дела</a>
            </div>
            <div class="services-details__cases-wrapper">
              <?php
              while ($cases_query->have_posts()):
                $cases_query->the_post();
                // Получаем кастомные поля
                $case_number = get_field('case_details_case_number');
                $case_aim = get_field('case_aim');
                $case_id = get_the_ID(); //Для построения ссылки
                $case_url = add_query_arg(
                  array(
                    'case_id' => $case_id,
                    'return_url' => urlencode($current_practice_url)
                  ),
                  home_url('/case/')
                );
                ?>
                <div class="services-details__cases-wrapper-child services-details__case">
                  <p class="services-details__case-number case-number">
                    Дело №
                    <?php echo esc_html($case_number); ?>
                  </p>
                  <h3 class="services-details__case-title title">
                    <?php the_title(); ?>
                  </h3>
                  <p class="services-details__case-text text">
                    <?php echo esc_html(strip_tags($case_aim)); ?>
                  </p>

                  <a href="<?php echo esc_url($case_url); ?>" class="services-details__case-btn btn">Подробнее</a>
                </div>
                <?php
              endwhile;
              wp_reset_postdata();?>
            </div>
          </div>
        </section>
        <?php endif;
        ?>
    </main>
  <?php endwhile; endif; ?>

<?php get_footer(); ?>