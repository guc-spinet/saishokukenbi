<?php // echo $_COOKIE['Saishokukenbi_A_Cookie']; ?>

<?php get_header(); $options = get_desing_plus_option(); ?>

<div id="main_col" class="clearfix">

 <ul id="bread_crumb" class="clearfix">
  <li class="home"><a href="<?php echo esc_url(home_url('/')); ?>"><span><?php _e('Home', 'tcd-w'); ?></span></a></li>
  <li class="last"><?php _e('講座紹介', 'tcd-w'); ?></li>
 </ul>

 <div id="left_col">

 <h2 class="headline2 teachers_head"><?php _e('講座紹介', 'tcd-w'); ?></h2>

 <?php if ( have_posts() ) : ?>

  <ul id="post_list_custom" class="clearfix">
  <?php while ( have_posts() ) : the_post(); ?>
  <li class="clearfix">
    <?php 
    $post = get_post($post_id);
    if ($post){
            $author = get_userdata($post->post_author);
            $post_user_id = $author->ID;
            $post_user_name = $author->user_login;
            $url = get_permalink( $post->ID);
            $link = mb_substr($url, 0, -1, "UTF-8");
    }
    ?>
   <a class="image" href="<?php echo $link.'?para1='.$post_user_id.'&para2='.$post_user_name; ?>"><?php if ( has_post_thumbnail()) { echo the_post_thumbnail(); } else { echo '<img src="'; bloginfo('template_url'); echo '/img/common/no_image2.jpg" alt="" title="" />'; }; ?></a>
  </li><!-- END .post_list -->
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