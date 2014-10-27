<div id="right_col">

<div class="center_block">
      <div class="top_block">
          <p><?php the_author_meta( 'profile2', $user_para_id ); ?></p>
      </div>
      <h3>新着情報</h3>
  <div class="topics_block">
　<h3 class="headline2">トピック</h3>
    <?php
    $post_num = 5;
    $args = array('post_type' => 'thread', 'posts_per_page' => $post_num, 'author__in' => array($user_para_id));
    $thread_list = new WP_Query($args);
    ?>
  <?php if ($thread_list -> have_posts()) :?>
     
  <?php while ($thread_list -> have_posts()) : $thread_list -> the_post(); 
   $thread_id = get_the_ID(); 
   $thread_link = get_permalink($thread_id);
   ?>

  <h2><a href="<?php echo $thread_link.'?para1='.$user_para_id.'&para2='.$user_para_name; ?>"><?php the_title(); ?></a></h2>

  <?php endwhile; ?>
  
  <div class="archive_footer">
  <a class="archive_list_link" href="<?php echo get_post_type_archive_link('event_thread'); ?>"><?php _e("Archives","tcd-w"); ?></a>
  </div>
  
  <?php else: ?>
  
  <p><?php _e("まだ投稿がありません。","tcd-w"); ?></p>
  
  <?php endif; wp_reset_query(); ?>
  </div>
  <?php
  $args = array('post_type' => 'event_thread', 'posts_per_page' => $post_num, 'author__in' => array($user_para_id));
  $event_thread_list = new WP_Query($args);
  ?>
　<div class="event_block">
　<h3 class="headline2">イベント</h3>
  <?php if ($event_thread_list -> have_posts()) :?>
     
  <?php while ($event_thread_list -> have_posts()) : $event_thread_list -> the_post(); 
   $event_thread_id = get_the_ID(); 
   $event_thread_link = get_permalink($event_thread_id); 
  ?>

  <h2><a href="<?php echo $event_thread_link.'?para1='.$user_para_id.'&para2='.$user_para_name; ?>"><?php the_title(); ?></a></h2>

  <?php endwhile; ?>
  
  <div class="archive_footer">
  <a class="news_widget_list_link" href="<?php echo get_post_type_archive_link('event_thread'); ?>"><?php _e("Archives","tcd-w"); ?></a>
  </div>
  
  <?php else: ?>
  
  <p><?php _e("まだ投稿がありません。","tcd-w"); ?></p>
  
  <?php endif; wp_reset_query(); ?>
  
  </div>
   
  </div>
</div>