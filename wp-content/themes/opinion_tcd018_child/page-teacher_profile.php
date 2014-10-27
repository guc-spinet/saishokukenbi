<?php
/*
Template Name: teacher_profile
*/
?>

<?php get_header('community'); $options = get_desing_plus_option(); ?>

<?php
$user_para_id =  $_SESSION[user_para_id];
$user_para_name =  $_SESSION[user_para_name];
$query = array(
    'para1' => $user_para_id,
    'para2' => $user_para_name,
);
?>

<div id="main_col" class="clearfix">

 <ul id="bread_crumb" class="clearfix">
     
 <li class="home"><a href="<?php echo esc_url(home_url('/')); ?>"><span><?php _e('Home', 'tcd-w'); ?></span></a></li>
 <li><a href="<?php echo get_post_type_archive_link('detailed_information'); ?>"><span><?php _e('講座紹介', 'tcd-w'); ?></span></a></li>
 <li><a href="<?php echo '/detailed_information/'.$user_data->display_name.'/?para1='.$user_para_id.'&para2='.$use_para_name; ?>"><span><?php echo $user_data->display_name; ?></span></a></li>
 <li class="last"><?php single_post_title(); ?></li>

</ul>

 <div id="left_col">


 <?php
       if($user_data) {
 ?>
 <h2 class="headline2" style="background: url('http://saishokukenbi.jp/wp-content/uploads/2014/10/<?php echo $user_para_name; ?>_midashi.png') no-repeat;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php _e("Author Profile","tcd-w"); ?></h2>
 <div id="author_profile_area" class="clearfix">
  <div id="author_avatar"><?php echo get_avatar($user_para_id, 150); ?></div>
  <div id="author_meta">
   <h2 id="author_name"><?php echo $user_data->display_name; ?><?php if($user_data->post_name) { ?><span id="author_name2"><?php echo $user_data->post_name; ?></span><?php }; ?></h2>
   <?php if($user_data->description) { ?>
   <div id="author_desc">
    <?php echo wpautop($user_data->description); ?>
   </div>
   <?php }; ?>
  </div>
 </div>
 <?php }; ?>



 <?php get_template_part('paypal'); ?>
 </div><!-- END #left_col -->

 <?php get_template_part('sidebar1'); ?>

</div><!-- END #main_col -->

<?php get_template_part('sidebar2'); ?>

<?php get_footer(); ?>