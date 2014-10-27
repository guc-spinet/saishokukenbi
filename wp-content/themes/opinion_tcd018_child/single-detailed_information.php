<?php
$user_para_id =  $_SESSION[user_para_id];
$user_para_name =  $_SESSION[user_para_name];
$query = array(
    'para1' => $user_para_id,
    'para2' => $user_para_name,
);
?>

<?php get_header(community); $options = get_desing_plus_option(); ?>

<div id="main_col">
 <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
 <ul id="bread_crumb" class="clearfix">
  <li class="home"><a href="<?php echo esc_url(home_url('/')); ?>"><span><?php _e('Home', 'tcd-w'); ?></span></a></li>
  <li><a href="<?php echo get_post_type_archive_link('detailed_information'); ?>"><span><?php _e('講座紹介', 'tcd-w'); ?></span></a></li>
  <li class="last"><?php the_title(); ?></li>
 </ul>

 <div id="left_col">

  

<div id="news_title">
    <h2  style="background: url('http://saishokukenbi.jp/wp-content/uploads/2014/10/<?php echo $user_para_name; ?>_midashi.png') no-repeat;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php the_title(); ?></h2>
  </div>
     
  <div class="post clearfix">

   <?php the_content(__('Read more', 'tcd-w')); ?>
   <?php custom_wp_link_pages(); ?>

  </div><!-- END .post -->

  <?php endwhile; endif; ?>

  <?php if ($options['show_next_post']) : ?>
  <div id="previous_next_post" class="clearfix">
   <p id="previous_post"><?php // previous_post_link('%link') ?></p>
   <p id="next_post"><?php // next_post_link('%link') ?></p>
  </div>
  <?php endif; ?>

  <?php // Recent news --------------------------------------------------------------------------------------- ?>
 <?php // get_template_part('others'); ?>
 <?php get_template_part('paypal'); ?>
 </div><!-- END #left_col -->

 <?php get_template_part('sidebar1'); ?>

</div><!-- END #main_col -->

<?php get_template_part('sidebar2'); ?>

<?php get_footer(); ?>