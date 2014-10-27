<?php get_header(); $options = get_desing_plus_option(); ?>

<div id="main_col">

 <ul id="bread_crumb" class="clearfix">
  <li class="home"><a href="<?php echo esc_url(home_url('/')); ?>"><span><?php _e('Home', 'tcd-w'); ?></span></a></li>
  <li><a href="<?php echo get_post_type_archive_link('news'); ?>"><span><?php _e('News Archive', 'tcd-w'); ?></span></a></li>
  <li class="last"><?php the_title(); ?></li>
 </ul>

 <div id="left_col">

  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

  <div id="news_title">
   <h2><?php the_title(); ?></h2>
   <p class="date"><?php the_time('Y-n-j'); ?></p>
  </div>

  <div class="post clearfix">

   <?php the_content(__('Read more', 'tcd-w')); ?>
   <?php custom_wp_link_pages(); ?>

  </div><!-- END .post -->

  <?php endwhile; endif; ?>

  <?php if ($options['show_next_post']) : ?>
  <div id="previous_next_post" class="clearfix">
   <p id="previous_post"><?php previous_post_link('%link') ?></p>
   <p id="next_post"><?php next_post_link('%link') ?></p>
  </div>
  <?php endif; ?>

  <?php // Recent news --------------------------------------------------------------------------------------- ?>
  <div id="Recent_news">
   <h3 class="headline2"><?php _e("Recent news","tcd-w"); ?></h3>
   <?php
        $args = array('post_type' => 'news', 'posts_per_page' => 5);
        $recent_news = get_posts($args);
        if ($recent_news) {
   ?>
   <ul id="news_list" class="clearfix">
    <?php foreach ($recent_news as $post) : setup_postdata ($post); ?>
    <li class="clearfix">
     <p class="news_date"><?php the_time('Y/n/j'); ?></p>
     <h4 class="news_title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
    </li>
    <?php endforeach; wp_reset_query(); ?>
   </ul>
   <?php }; ?>
  </div><!-- END #recent_news -->

 </div><!-- END #left_col -->

 <?php get_template_part('sidebar1'); ?>

</div><!-- END #main_col -->

<?php get_template_part('sidebar2'); ?>

<?php get_footer(); ?>