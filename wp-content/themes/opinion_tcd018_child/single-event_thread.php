<?php get_header(community); $options = get_desing_plus_option(); ?>
<?php
$user_para_id =  $_SESSION[user_para_id];
$user_para_name =  $_SESSION[user_para_name];
$query = array(
    'para1' => $user_para_id,
    'para2' => $user_para_name,
);
?>
<div id="main_col">

 <ul id="bread_crumb" class="clearfix">
  <li class="home"><a href="<?php echo esc_url(home_url('/')); ?>"><span><?php _e('Home', 'tcd-w'); ?></span></a></li>
  <li><a href="<?php echo get_post_type_archive_link('event_thread'); ?>"><span><?php _e('イベントスレッド', 'tcd-w'); ?></span></a></li>
  <li class="last"><?php the_title(); ?></li>
 </ul>

 <div id="left_col">

  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

  <div id="single_title">
   <h2><?php the_title(); ?></h2>
   <ul id="single_meta" class="clearfix">
    <?php if ($options['show_date']) : ?><li class="date"><?php the_time('Y/n/j'); ?></li><?php endif; ?>
    <?php if ($options['show_comment']) : ?><li class="post_comment"><?php comments_popup_link(__('Write comment', 'tcd-w'), __('1 comment', 'tcd-w'), __('% comments', 'tcd-w')); ?></li><?php endif; ?>
    <?php if ($options['show_author']) : ?><li class="post_author"><?php the_author_posts_link(); ?></li><?php endif; ?>
   </ul>
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

 <?php if ($options['show_comment']) : if (function_exists('wp_list_comments')) { comments_template('', true); } else { comments_template(); }; endif; ?>
  
  <?php // Recent news --------------------------------------------------------------------------------------- ?>
  <div id="Recent_news">
   <h3 class="headline2"><?php _e("最近のイベントスレッド","tcd-w"); ?></h3>
   <?php
        $args = array('post_type' => 'event_thread', 'posts_per_page' => 5);
        $recent_event_thread = get_posts($args);
        if ($recent_event_thread) {
   ?>
   <ul id="news_list" class="clearfix">
    <?php foreach ($recent_event_thread as $post) : setup_postdata ($post); ?>
    <li class="clearfix">
     <p class="news_date"><?php the_time('Y/n/j'); ?></p>
     <h4 class="news_title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
    </li>
    <?php endforeach; wp_reset_query(); ?>
   </ul>
   <?php }; ?>
  </div><!-- END #recent_news -->
 </div><!-- END #left_col -->

 <?php //get_template_part('sidebar1'); ?>

</div><!-- END #main_col -->

<?php //get_template_part('sidebar2'); ?>

<?php get_footer(); ?>