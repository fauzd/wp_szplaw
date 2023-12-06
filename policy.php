<?php
/*
Template Name: policy
*/
?>

<?php get_header(); ?>

<main>
  <section class="policy">
    <div class="container policy__container">
      <?php
      $policy_post = get_post(261);
      setup_postdata($policy_post); 
      ?>
  
      <h2 class="policy__title title">
        <?php the_title(); ?>
      </h2>
      <div class="policy__text text">
        <?php the_content(); ?>
      </div>
  
      <?php wp_reset_postdata(); ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>