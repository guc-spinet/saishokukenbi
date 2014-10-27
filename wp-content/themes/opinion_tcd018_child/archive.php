<?php
if(isset($_GET['para3'])) {
    $para1 = $_GET['para3'];
}
?>
<?php if (is_author() and !empty($para3)):?>
<?php get_header(community); $options = get_desing_plus_option(); ?>
<?php elseif (is_category() and !empty($para3)):?>
<?php get_header(community); $options = get_desing_plus_option(); ?>
<?php 
    $term = get_current_term();
    query_posts('author='.$para3.'&category_name='.$term->name);
?>
<?php else :?>
<?php get_header(); $options = get_desing_plus_option(); ?>
<?php endif;?>
<div id="main_col" class="clearfix">

 <?php get_template_part('breadcrumb'); ?>

 <div id="left_col">

 <?php if ( have_posts() ) : ?>

 <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 <?php if (is_category()) { ?>
 <h2 class="archive_headline"><?php printf(__('Archive for the &#8216; %s &#8217; Category', 'tcd-w'), single_cat_title('', false)); ?></h2>

 <?php } elseif( is_tag() ) { ?>
 <h2 class="archive_headline"><?php printf(__('Posts Tagged &#8216; %s &#8217;', 'tcd-w'), single_tag_title('', false) ); ?></h2>

 <?php } elseif (is_day()) { ?>
 <h2 class="archive_headline"><?php printf(__('Archive for &#8216; %s &#8217;', 'tcd-w'), get_the_time(__('F jS, Y', 'tcd-w'))); ?></h2>

 <?php } elseif (is_month()) { ?>
 <h2 class="archive_headline"><?php printf(__('Archive for &#8216; %s &#8217;', 'tcd-w'), get_the_time(__('F, Y', 'tcd-w'))); ?></h2>

 <?php } elseif (is_year()) { ?>
 <h2 class="archive_headline"><?php printf(__('Archive for &#8216; %s &#8217;', 'tcd-w'), get_the_time(__('Y', 'tcd-w'))); ?></h2>

 <?php } elseif (is_author()) { ?>
 <?php global $wp_query; $curauth = $wp_query->get_queried_object(); //get the author info ?>
 <h2 class="archive_headline"><?php printf(__('Archive for the &#8216; %s &#8217;', 'tcd-w'), $curauth->display_name ); ?></h2>

 <?php } else { ?>
 <h2 class="archive_headline"><?php _e('Blog Archives', 'tcd-w'); ?></h2>
 <?php }; ?>

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

 <?php include('navigation.php'); ?>

 </div><!-- END #left_col -->

 <?php get_template_part('sidebar1'); ?>

</div><!-- END #main_col -->

<?php get_template_part('sidebar2'); ?>

<?php get_footer(); ?>