<?php
// [ user.php ]
$user_para_id = '';
$user_para_name = '';
if(isset($_GET['para1'])) {
    $user_para_id = $_GET['para1'];
}
if(isset($_GET['para2'])) {
    $user_para_name = $_GET['para2'];
}
?>

<?php get_header(community); $options = get_desing_plus_option(); ?>

<div id="main_col">

 <ul id="bread_crumb" class="clearfix">
  <li class="home"><a href="<?php echo esc_url(home_url('/')); ?>"><span><?php _e('Home', 'tcd-w'); ?></span></a></li>
  <li><a href="<?php echo get_post_type_archive_link('detailed_information'); ?>"><span><?php _e('講座詳細', 'tcd-w'); ?></span></a></li>
  <li class="last"><?php the_title(); ?></li>
 </ul>

 <div id="left_col">

  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

  <div id="news_title">
   <h2><?php the_title(); ?></h2>
   <p class="date"><?php the_time('Y-n-j'); ?></p>
  </div>
  
     
     
     <div id="profile_author_list">
   <ul>
    <?php
         $blogusers = get_users_of_blog();
         if ($blogusers) {
          foreach ($blogusers as $bloguser) {
          $user_data = get_userdata($bloguser->user_id);
          if($user_data->show_author == true) {
    ?>
    <li class="clearfix">
     <div class="profile_author_avatar"><?php echo get_avatar($user_data->ID, 70); ?></div>
     <div class="profile_author_meta">
      <div class="profile_author_meta_top">
       <h2 class="profile_author_name"><?php echo $user_data->display_name; ?><?php if($user_data->post_name) { ?><span class="profile_author_name2"><?php echo $user_data->post_name; ?></span><?php }; ?></h2>
       <a class="profile_author_link" href="<?php echo get_author_posts_url($user_data->ID); ?>"><?php _e("Author profile","tcd-w"); ?></a>
      </div>
      <?php if($user_data->profile2) { ?>
      <div class="profile_author_desc">
       <?php echo wpautop($user_data->profile2); ?>
      </div>
      <?php }; ?>
     </div>
    </li>
    <?php }; }; }; ?>
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

  <?php // Recent news --------------------------------------------------------------------------------------- ?>
  <div id="Recent_detailed_information">
   <h3 class="headline2"><?php _e("他の講座","tcd-w"); ?></h3>
   <?php
        $args = array('post_type' => 'detailed_information', 'posts_per_page' => 5);
        $recent_detailed_information = get_posts($args);
        if ($recent_detailed_information) {
   ?>
   <ul id="news_list" class="clearfix">
    <?php foreach ($recent_detailed_information as $post) : setup_postdata ($post); ?>
    <li class="clearfix">
     <p class="news_date"><?php the_time('Y/n/j'); ?></p>
     <h4 class="news_title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
    </li>
    <?php endforeach; wp_reset_query(); ?>
   </ul>
   <?php }; ?>
  </div><!-- END #recent_news -->
  <div class="apply_banner">
      
    <?php if (is_user_logged_in()) :
    //ユーザー処理
    $user = wp_get_current_user();
    $my_user_id = $user->get('ID');
    $my_user_application = $user->get('application');
    $applications = explode(",", $my_user_application);
    $key = array_search($user_para_name, $applications);    
    if($key === FALSE):    
    ?>   
    <p>ログイン中:未登録</p>
    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="NKE7J78RYLJ96">
<table>
<tr><td><input type="hidden" name="on0" value="支払いオプション">支払いオプション</td></tr><tr><td><select name="os0">
	<option value="オプション 1">オプション 1 : ¥5,000 JPY - 毎月</option>
	<option value="オプション 2">オプション 2 : ¥10,000 JPY - 毎月</option>
</select> </td></tr>
</table>
<input type="hidden" name="currency_code" value="JPY">
<input type="image" src="https://www.sandbox.paypal.com/ja_JP/JP/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - オンラインでより安全・簡単にお支払い">
<img alt="" border="0" src="https://www.sandbox.paypal.com/ja_JP/i/scr/pixel.gif" width="1" height="1">
</form>

    <?php else :?>
    <p>ログイン中：登録済</p>
    <a href="<?php echo 'http://saishokukenbi.jp/community?para1='.$user_para_id.'&para2='.$user_para_name.'/';?>"><h1>マイページへ</h1></a>
   <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="NKE7J78RYLJ96">
<table>
<tr><td><input type="hidden" name="on0" value="支払いオプション">支払いオプション</td></tr><tr><td><select name="os0">
	<option value="オプション 1">オプション 1 : ¥5,000 JPY - 毎月</option>
	<option value="オプション 2">オプション 2 : ¥10,000 JPY - 毎月</option>
</select> </td></tr>
</table>
<input type="hidden" name="currency_code" value="JPY">
<input type="image" src="https://www.sandbox.paypal.com/ja_JP/JP/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - オンラインでより安全・簡単にお支払い">
<img alt="" border="0" src="https://www.sandbox.paypal.com/ja_JP/i/scr/pixel.gif" width="1" height="1">
</form>


    <?php endif;?>
    <?php else :?>
    <p>ログインしてない</p>
    <form action="<?php bloginfo('template_url'); ?>/paypal/page-paypal?event=INPUT1" method="POST">
    <input type="image" name="submit" src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" border="0" align="top" alt="Check out with PayPal">
    </form>
    <?php endif;?>
      
  </div>
 </div><!-- END #left_col -->

 <?php get_template_part('sidebar1'); ?>

</div><!-- END #main_col -->

<?php get_template_part('sidebar2'); ?>

<?php get_footer(); ?>