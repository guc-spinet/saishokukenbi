<?php get_header(); $options = get_desing_plus_option(); ?>

<div id="main_col" class="clearfix">

 <ul id="bread_crumb" class="clearfix">
  <li class="home"><a href="<?php echo esc_url(home_url('/')); ?>"><span><?php _e('Home', 'tcd-w'); ?></span></a></li>
  <li class="last"><?php _e('News Archive', 'tcd-w'); ?></li>
 </ul>

 <div id="left_col">

 <h2 class="headline2"><?php _e('News Archive', 'tcd-w'); ?></h2>

 <?php if ( have_posts() ) : ?>

 <ul id="news_list" class="clearfix">
  <?php while ( have_posts() ) : the_post(); ?>
  <li class="clearfix">
   <p class="news_date"><?php the_time('Y/n/j'); ?></p>
   <h4 class="news_title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
  </li>
  <?php endwhile; else: ?>
  <li class="no_post"><?php _e("There is no registered post.","tcd-w"); ?></li>
  <?php endif; ?>
 </ul>

 <?php include('navigation.php'); ?>

 </div><!-- END #left_col -->

 <?php get_template_part('sidebar1'); ?>

</div><!-- END #main_col -->

<?php get_template_part('sidebar2'); ?>

<?php get_footer(); ?>