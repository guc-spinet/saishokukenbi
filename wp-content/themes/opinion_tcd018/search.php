<?php get_header(); $options = get_desing_plus_option(); ?>

<div id="main_col" class="clearfix">

 <?php get_template_part('breadcrumb'); ?>

 <div id="left_col">

 <?php
      global $query_string;
      query_posts($query_string . "&post_type=post");
      if (have_posts()):
 ?>

 <h2 class="archive_headline"><?php printf(__('Search results for - [ %s ]', 'tcd-w'), get_search_query()); ?></h2>

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
  <?php endwhile; ?>
 </ul>
 <?php else: ?>
 <p class="no_post"><?php _e("There is no registered post.","tcd-w"); ?></p>
 <?php endif; ?>

 <?php include('navigation.php'); ?>

 </div><!-- END #left_col -->

 <?php get_template_part('sidebar1'); ?>

</div><!-- END #main_col -->

<?php get_template_part('sidebar2'); ?>

<?php get_footer(); ?>