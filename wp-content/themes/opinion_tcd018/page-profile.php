<?php
/*
Template Name:Author Profile
*/
?>
<?php get_header(); $options = get_desing_plus_option(); ?>

<div id="main_col">

 <ul id="bread_crumb" class="clearfix">
  <li class="home"><a href="<?php echo esc_url(home_url('/')); ?>"><span><?php _e('Home', 'tcd-w'); ?></span></a></li>
  <li class="last"><?php the_title(); ?></li>
 </ul>

 <div id="left_col">

  <h2 class="headline2"><?php _e('Author List', 'tcd-w'); ?></h3>
  <div id="profile_author_list">
   <ul>
    <?php
         $blogusers = get_users_of_blog();
         if ($blogusers) {
          foreach ($blogusers as $bloguser) {
          $user_data = get_userdata($bloguser->user_id);
          if($user_data->show_author == true) {
    ?>
    <li class="clearfix">
     <div class="profile_author_avatar"><?php echo get_avatar($user_data->ID, 70); ?></div>
     <div class="profile_author_meta">
      <div class="profile_author_meta_top">
       <h2 class="profile_author_name"><?php echo $user_data->display_name; ?><?php if($user_data->post_name) { ?><span class="profile_author_name2"><?php echo $user_data->post_name; ?></span><?php }; ?></h2>
       <a class="profile_author_link" href="<?php echo get_author_posts_url($user_data->ID); ?>"><?php _e("Author profile","tcd-w"); ?></a>
      </div>
      <?php if($user_data->profile2) { ?>
      <div class="profile_author_desc">
       <?php echo wpautop($user_data->profile2); ?>
      </div>
      <?php }; ?>
     </div>
    </li>
    <?php }; }; }; ?>
   </ul>
  </div>

 </div><!-- END #left_col -->

 <?php get_template_part('sidebar1'); ?>

</div><!-- END #main_col -->

<?php get_template_part('sidebar2'); ?>

<?php get_footer(); ?>