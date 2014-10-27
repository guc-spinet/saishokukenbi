<?php
$user_para_id = '';
$user_para_name = '';
if(isset($_GET['para1'])) {
   $_SESSION[user_para_id] = array();
   $_SESSION[user_para_id]  = get_query_var('para1');
}
if(isset($_GET['para2'])) {
    $_SESSION[user_para_name] = array();
    $_SESSION[user_para_name]  = get_query_var('para2');
}
$user_para_id =  $_SESSION[user_para_id];
$user_para_name =  $_SESSION[user_para_name];
?>
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
    $args = array('post_type' => 'thread', 'posts_per_page' => $post_num, 'author_in' => array($user_para_id));
    $thread_list = new WP_Query($args);
    ?>
  <?php if ($thread_list -> have_posts()) :?>
  <ul id="news_list" class="clearfix">
  <?php while ($thread_list -> have_posts()) : $thread_list -> the_post(); 
   $thread_id = get_the_ID(); 
   $thread_link = get_permalink($thread_id);
   ?>
   
    <li class="clearfix">
     <p class="news_date"><?php the_time('Y/n/j'); ?></p>
     <h4 class="news_title"><a href="<?php echo $thread_link.'?para1='.$user_para_id.'&para2='.$user_para_name; ?>"><?php the_title(); ?></a></h4>
    </li>
   

  <?php endwhile; ?>
  </ul>
  <div class="archive_footer">
  <a class="archive_list_link" href="<?php echo get_post_type_archive_link('thread'); ?>"><?php _e("Archives","tcd-w"); ?></a>
  </div>
  
  <?php else: ?>
  
  <p><?php _e("まだ投稿がありません。","tcd-w"); ?></p>
  
  <?php endif; wp_reset_query(); ?>
  </div>
  <?php
  $args = array('post_type' => 'event_thread', 'posts_per_page' => $post_num, 'author_in' => array($user_para_id));
  $event_thread_list = new WP_Query($args);
  ?>
　<div class="event_block">
　<h3 class="headline2">イベント</h3>
  <?php if ($event_thread_list -> have_posts()) :?>
  <ul id="news_list" class="clearfix">
  <?php while ($event_thread_list -> have_posts()) : $event_thread_list -> the_post(); 
   $event_thread_id = get_the_ID(); 
   $event_thread_link = get_permalink($event_thread_id); 
  ?>

  <li class="clearfix">
     <p class="news_date"><?php the_time('Y/n/j'); ?></p>
     <h4 class="news_title"><a href="<?php echo $event_thread_link.'?para1='.$user_para_id.'&para2='.$user_para_name; ?>"><?php the_title(); ?></a></h4>
    </li>
  <?php endwhile; ?>
  </ul>
  <div class="archive_footer">
  <a class="archive_list_link" href="<?php echo get_post_type_archive_link('event_thread'); ?>"><?php _e("Archives","tcd-w"); ?></a>
  </div>
  
  <?php else: ?>
  
  <p><?php _e("まだ投稿がありません。","tcd-w"); ?></p>
  
  <?php endif; wp_reset_query(); ?>
  
  </div>
  <div class="topics_block">
　<h3 class="headline2">講座用PDF</h3>
    <?php
    $args = array('post_type' => 'pdfs', 'posts_per_page' => $post_num, 'author_in' => array($user_para_id));
    $pdfs = new WP_Query($args);
    ?>
  <?php if ($thread_list -> have_posts()) :?>
  <ul id="news_list" class="clearfix">
  <?php while ($pdfs -> have_posts()) : $pdfs -> the_post(); 
   $pdfs_id = get_the_ID(); 
   $pdfs_link = get_permalink($pdfs_id);
   ?>
  <li class="clearfix">
     <p class="news_date"><?php the_time('Y/n/j'); ?></p>
     <h4 class="news_title"><a href="<?php echo $pdfs_link.'?para1='.$user_para_id.'&para2='.$user_para_name; ?>"><?php the_title(); ?></a></h4>
    </li>
    <div><?php the_content();?></div>
  <?php endwhile; ?>
  </ul>
  <div class="archive_footer">
  <a class="archive_list_link" href="<?php echo get_post_type_archive_link('pdfs'); ?>"><?php _e("Archives","tcd-w"); ?></a>
  </div>
  
  <?php else: ?>
  
  <p><?php _e("まだ投稿がありません。","tcd-w"); ?></p>
  
  <?php endif; wp_reset_query(); ?>
  </div>
  <div class="topics_block">
　<h3 class="headline2">講座用動画</h3>
    <?php
    $args = array('post_type' => 'movies', 'posts_per_page' => $post_num, 'author_in' => array($user_para_id));
    $movies_list = new WP_Query($args);
    ?>
  <?php if ($movies_list -> have_posts()) :?>
  <ul id="news_list" class="clearfix"> 
  <?php while ($movies_list -> have_posts()) : $movies_list -> the_post(); 
   $movies_id = get_the_ID(); 
   $movies_link = get_permalink($movies_id);
   ?>

     <li class="clearfix">
     <p class="news_date"><?php the_time('Y/n/j'); ?></p>
     <h4 class="news_title"><a href="<?php echo $movies_link.'?para1='.$user_para_id.'&para2='.$user_para_name; ?>"><?php the_title(); ?></a></h4>
    </li>
    <div><?php the_content();?></div>
  <?php endwhile; ?>
  </ul>
  <div class="archive_footer">
  <a class="archive_list_link" href="<?php echo get_post_type_archive_link('movies'); ?>"><?php _e("Archives","tcd-w"); ?></a>
  </div>
  
  <?php else: ?>
  
  <p><?php _e("まだ投稿がありません。","tcd-w"); ?></p>
  
  <?php endif; wp_reset_query(); ?>
  </div>
   
  </div>
</div>