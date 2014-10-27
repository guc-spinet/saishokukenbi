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
}
if(isset($_GET['para2'])) {
    $user_para_name = $_GET['para2'];
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
            $post_num = 5;
            $args = array('post_type' => 'detailed_information', 'posts_per_page' => $post_num, 'author__in' => array($other_community_user_id->ID));
            $pickup_community = new WP_Query($args);
             if ($pickup_community -> have_posts()) : while ($pickup_community -> have_posts()) : $pickup_community -> the_post();
             $user_top_id = get_the_ID(); 
             $post = get_post($user_top_id);
            if ($post){
            $author = get_userdata($post->post_author);
            $post_user_id = $author->ID;
            $post_user_name = $author->user_login;
            $url = get_permalink( $post->ID);
            $link = mb_substr($url, 0, -1, "UTF-8");
            
            }
            ?>
            <div class="pickup_community">
                <a href="<?php echo $link.'?para1='.$post_user_id.'&para2='.$post_user_name; ?>">
                <?php if ( has_post_thumbnail()) { echo the_post_thumbnail(''); } else { echo '<img src="'; bloginfo('template_url'); echo '/img/common/no_image2.jpg" alt="" title="" />'; }; ?>
                <p><?php the_title(); ?></p>
                </a>
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
     
 </div><!-- END #left_col -->
 
<?php get_template_part('sidebar4'); ?>
 
</div><!-- END #main_col -->

<?php get_template_part('sidebar3'); ?>

<?php get_footer(); ?>
<?php endif;?>