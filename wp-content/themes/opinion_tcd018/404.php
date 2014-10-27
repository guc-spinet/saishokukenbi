<?php get_header(); $options = get_desing_plus_option(); ?>

<div id="main_col">

 <ul id="bread_crumb" class="clearfix">
  <li class="home"><a href="<?php echo esc_url(home_url('/')); ?>"><span><?php _e('Home', 'tcd-w'); ?></span></a></li>
  <li class="last"><?php _e("Sorry, but you are looking for something that isn't here.","tcd-w"); ?></li>
 </ul>

 <div id="left_col">

  <h2 class="headline2"><?php _e("Sorry, but you are looking for something that isn't here.","tcd-w"); ?></h2>

  <div class="post clearfix">

   <?php the_content(__('Read more', 'tcd-w')); ?>
   <?php custom_wp_link_pages(); ?>

  </div><!-- END .post -->

 </div><!-- END #left_col -->

 <?php get_template_part('sidebar1'); ?>

</div><!-- END #main_col -->

<?php get_template_part('sidebar2'); ?>

<?php get_footer(); ?>