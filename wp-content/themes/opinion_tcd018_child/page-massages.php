<?php
/*
Template Name:massages
*/
?>
<?php get_header(community); $options = get_desing_plus_option(); ?>
<?php
$user_para_id =  $_SESSION[user_para_id];
$user_para_name =  $_SESSION[user_para_name];
$query = array(
    'para1' => $user_para_id,
    'para2' => $user_para_name,
);
$user = wp_get_current_user();
?>
<div id="main_col">

 <ul id="bread_crumb" class="clearfix">
  <li class="home"><a href="<?php echo esc_url(home_url('/')); ?>"><span><?php _e('Home', 'tcd-w'); ?></span></a></li>
  <li class="last"><?php the_title(); ?></li>
 </ul>

 <div id="left_col">

  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

  <h2 class="headline2"><?php the_title(); ?></h2>

  <div class="post clearfix">

   <?php the_content(__('Read more', 'tcd-w')); ?>
      
   <?php 
    $select_page_id = 165;
    $select_me = $user->get('ID');
    $select_you = $user_para_id;
    $data = $wpdb->get_results("
    SELECT comment_content , user_id , comment_ID
    FROM $wpdb->comments
    where (user_id = $select_me or user_id = $select_you) AND comment_post_ID = $select_page_id
    ORDER BY comment_ID DESC 
   ");
   foreach ($data as $value) {
    if($value->user_id == $select_me){
    echo '<div class="massage_block"><p class="line_left">'.$value->comment_content.'</p>';
    echo '<a href="'.get_bloginfo('wpurl').'/wp-admin/comment.php?action=cdc&c='.$value->comment_ID.'">削除</a></div>';
    }else{
    echo '<div class="massage_block2"><p class="line_right">'.$value->comment_content.'</p></div>';
    }
   }
    ?>
   <?php custom_wp_link_pages(); ?>

  </div><!-- END .post -->
  <?php endwhile; endif; ?>
  
 <fieldset class="comment_form_wrapper" id="respond">

  <?php if (function_exists('comment_reply_link')) { ?>
  <div id="cancel_comment_reply"><?php cancel_comment_reply_link() ?></div>
  <?php } ?>

  <form action="<?php echo esc_url(site_url('/')); ?>wp-comments-post.php" method="post" id="commentform">

   <?php if ( $user_ID ) : ?>

   <div id="comment_user_login">
    <p><?php printf(__('Logged in as <a href="%1$s">%2$s</a>.', 'tcd-w'), get_site_url() . '/wp-admin/profile.php', $user_identity); ?><span><a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account', 'tcd-w'); ?>"><?php _e('[ Log out ]', 'tcd-w'); ?></a></span></p>
   </div><!-- #comment-user-login END -->

   <?php else : ?>

   <div id="guest_info">
    <div id="guest_name"><label for="author"><span><?php _e('NAME','tcd-w'); ?></span><?php if ($req) _e('( required )', 'tcd-w'); ?></label><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> /></div>
    <div id="guest_email"><label for="email"><span><?php _e('E-MAIL','tcd-w'); ?></span><?php if ($req) _e('( required )', 'tcd-w'); ?> <?php _e('- will not be published -','tcd-w'); ?></label><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> /></div>
    <div id="guest_url"><label for="url"><span><?php _e('URL','tcd-w'); ?></span></label><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" /></div>
    <?php if ( function_exists('cs_print_smilies') ) { echo '<div id="custom_smilies">'; cs_print_smilies(); echo "</div>\n"; } ?>
   </div>

   <?php endif; ?>

   <div id="comment_textarea">
    <textarea name="comment" id="comment" cols="50" rows="10" tabindex="4"></textarea>
   </div>

   <?php if (function_exists('show_subscription_checkbox')) { show_subscription_checkbox(); } ?>

   <div id="submit_comment_wrapper">
    <?php do_action('comment_form', $post->ID); ?>
    <input name="submit" type="submit" id="submit_comment" tabindex="5" value="<?php _e('Submit Comment', 'tcd-w'); ?>" title="<?php _e('Submit Comment', 'tcd-w'); ?>" alt="<?php _e('Submit Comment', 'tcd-w'); ?>" />
   </div>
   <div id="input_hidden_field">
    <?php if (function_exists('comment_id_fields')) { ?>
    <?php comment_id_fields(); ?>
    <?php } else { ?>
    <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
    <?php } ?>
   </div>

  </form>

 </fieldset><!-- #comment-form-area END -->

 </div><!-- END #left_col -->

</div><!-- END #main_col -->

<?php get_footer(); ?>
