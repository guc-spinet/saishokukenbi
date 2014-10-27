<?php
/*
Template Name: community
*/
?>
<?php
//ユーザーのログイン確認

// [ user.php ]
$user_para_id = '';
$user_para_name = '';
if(isset($_GET['para1'])) {
    $user_para_id = $_GET['para1'];
    var_dump($user_para_id);
}
if(isset($_GET['para2'])) {
    $user_para_name = $_GET['para2'];
    var_dump($user_para_name);
}
$user = wp_get_current_user();
$my_user_id = $user->get('ID');
$my_user_application = $user->get('application');
$applications = explode(",", $my_user_application);
$key = array_search($user_para_name, $applications); 
if($key === FALSE):
    //header("Location:http://saishokukenbi.jp/");
    //exit;
else:
$query = array (
        'para1' => $user_para_id ,
        'para2' => $user_para_name
        );
?>


<?php get_header('community'); $options = get_desing_plus_option(); ?>

<div id="main_col">
 <ul id="bread_crumb" class="clearfix">
  <li class="home"><a href="<?php echo esc_url(home_url('/')); ?>"><span><?php _e('Home', 'tcd-w'); ?></span></a></li>
  <li class="last"><?php the_title(); ?></li>
 </ul>

 <div id="left_col" class="clearfix">
  
  <div class="left_block">
    <div class="thumbnails_block">
        <?php echo get_avatar($user_para_id, 150); ?>
        <p>管理人：<?php the_author_meta( 'display_name', $user_para_id ); ?></p>
    </div>
      
       <div class="thumbnails_block">
        <h2><?php the_author_meta( 'display_name', $my_user_id ); ?>のプロフィール</h2>
        <?php echo get_avatar($my_user_id, 150); ?>
        <p><a href="<?php echo add_query_arg( $query, bloginfo('url').'/private_massages');?>">プライベートメッセージを送る</a></p>
        <p><a href="http://saishokukenbi.jp/my_profile/">登録情報の変更</a></p>
        <p><a href="http://saishokukenbi.jp/withdraw/">退会処理</a></p>
        <h2><?php the_author_meta( 'display_name', $my_user_id); ?>の参加中講義一覧</h2>
        <div class="pickup_community_list">
            
            <?php
            if($applications):
            foreach ($applications as $application):
            $other_community_user_id = get_user_by( 'login', $application );
            $post_num = 1;
            $args = array('post_type' => 'detailed_information', 'posts_per_page' => $post_num, 'author__in' => array($other_community_user_id->ID));
            $pickup_community = new WP_Query($args);
             if ($pickup_community -> have_posts()) : while ($pickup_community -> have_posts()) : $pickup_community -> the_post();
            ?>
            <div class="pickup_community">
                <?php if ( has_post_thumbnail()) { echo the_post_thumbnail('size2'); } else { echo '<img src="'; bloginfo('template_url'); echo '/img/common/no_image2.jpg" alt="" title="" />'; }; ?>
                <p><?php the_title(); ?></p>
            </div>
            <?php 
            endwhile; 
            endif;
            wp_reset_query;
            endforeach;
            endif;
            ?>
             
        </div>
    </div>
      
  </div>
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
     
  <?php while ($thread_list -> have_posts()) : $thread_list -> the_post(); ?>

  <h2><?php the_title(); ?></h2>

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
     
  <?php while ($event_thread_list -> have_posts()) : $event_thread_list -> the_post(); ?>

  <h2><?php the_title(); ?></h2>

  <?php endwhile; ?>
  
  <div class="archive_footer">
  <a class="news_widget_list_link" href="<?php echo get_post_type_archive_link('event_thread'); ?>"><?php _e("Archives","tcd-w"); ?></a>
  </div>
  
  <?php else: ?>
  
  <p><?php _e("まだ投稿がありません。","tcd-w"); ?></p>
  
  <?php endif; wp_reset_query(); ?>
  
  </div>
   
  </div>
     <div class="right_block">
         <h2>人気講師ランキング</h2>
         <?php $args = array('post_type' => 'detailed_information', 'posts_per_page' => 10);
            $detailed_information = new WP_Query($args);
            if ($detailed_information -> have_posts()) : while ($detailed_information -> have_posts()) : $detailed_information -> the_post();
         ?>
         <div class="teacher_ranking">
             <?php if ( has_post_thumbnail()) { echo the_post_thumbnail(); } else { echo '<img src="'; bloginfo('template_url'); echo '/img/common/no_image2.jpg" alt="" title="" />'; }; ?>
             <p><?php $blogusers = get_users(); echo $blogusers[0]->display_name ;?></p>
         </div>
         <?php  endwhile; endif; wp_reset_query;?>
     </div>
     
 </div><!-- END #left_col -->
</div><!-- END #main_col -->

<?php get_footer(); ?>
<?php endif;?>