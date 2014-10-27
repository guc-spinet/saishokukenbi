<?php
/*
Template Name:Header full
*/
?>
<?php get_header(nonav); $options = get_desing_plus_option(); ?>

<div id="main_col">
 <div id="left_col">
  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

  <div class="post clearfix">

   <?php the_content(__('Read more', 'tcd-w')); ?>
   <?php custom_wp_link_pages(); ?>

  </div><!-- END .post -->

  <?php endwhile; endif; ?>
 </div><!-- END #left_col -->
</div><!-- END #main_col -->

<?php get_footer(); ?>