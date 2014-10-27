<?php get_header(community); $options = get_desing_plus_option(); ?>

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
 <li class="last">ブログ</li>

</ul>

 <div id="left_col">

 <?php if ( have_posts() ) : ?>

 <?php
      global $wp_query;
      $author_id = $wp_query->query_vars['author'];
      $user_data = get_userdata($author_id);
       if($user_data->show_author == true) {
 ?>
 <h2 class="headline2" style="background: url('http://saishokukenbi.jp/wp-content/uploads/2014/10/<?php echo $user_para_name; ?>_midashi.png') no-repeat;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php _e("Author Profile","tcd-w"); ?></h2>
 <div id="author_profile_area" class="clearfix">
  <div id="author_avatar"><?php echo get_avatar($author_id, 70); ?></div>
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

 <h2 class="headline2" style="background: url('http://saishokukenbi.jp/wp-content/uploads/2014/10/<?php echo $user_para_name; ?>_midashi.png') no-repeat;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $user_data->display_name; ?>ブログ<?php _e(" post list","tcd-w"); ?></h2>
 <div id="author_post_list">
 <ul id="post_list" class="clearfix">
  <?php while ( have_posts() ) : the_post(); ?>
  <li class="clearfix">
   <a class="image" href="<?php the_permalink() ?>"><?php if ( has_post_thumbnail()) { echo the_post_thumbnail('size2'); } else { echo '<img src="'; bloginfo('template_url'); echo '/img/common/no_image2.jpg" alt="" title="" />'; }; ?></a>
   <div class="info">
    <?php if ($options['show_date']) { ?>
    <ul class="meta clearfix">
     <?php if ($options['show_date']) { ?><li class="post_date"><?php the_time('Y/n/j'); ?></li><?php }; ?>
     <li class="post_category"><?php the_category(', '); ?></li>
    </ul>
    <?php }; ?>
    <h4 class="title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
    <div class="excerpt"><?php if (has_excerpt()) { the_excerpt(); } else { new_excerpt(110);}; ?></div>
    <?php if($options['show_bookmark']) { include('bookmark.php'); };?>
   </div>
  </li><!-- END .post_list -->
  <?php endwhile; else: ?>
  <li class="no_post"><?php _e("There is no registered post.","tcd-w"); ?></li>
  <?php endif; ?>
 </ul>
 </div>

 <?php include('navigation.php'); ?>

 </div><!-- END #left_col -->

 <?php get_template_part('sidebar1'); ?>

</div><!-- END #main_col -->

<?php get_template_part('sidebar2'); ?>

<?php get_footer(); ?>