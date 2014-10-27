 <div class="apply_banner">
      
    <?php if (is_user_logged_in()) :
    $user_para_id =  $_SESSION[user_para_id];
    $user_para_name =  $_SESSION[user_para_name];
    $query = array(
        'para1' => $user_para_id,
        'para2' => $user_para_name,
    );
    $user = wp_get_current_user();
    $my_user_id = $user->get('ID');
    $my_user_application = $user->get('application');
    $applications = explode(",", $my_user_application);
    $key = array_search($user_para_name, $applications);    
    if($key === FALSE):
    ?>   
     <div id='register_area'>
         <p>ログイン中:未登録</p>
         <p>入学金&nbsp;32,400円</p>
        <!--※ペイパル実装済み-->
        <!--カリキュラムページ以外の場合-->
        <?php $args = array('post_type' => 'curriculum', 'posts_per_page' => 1, 'author' => $user_para_id);
               $curriculum = new WP_Query($args);
               if ($curriculum -> have_posts()) : while ($curriculum -> have_posts()) : $curriculum -> the_post();
               $user_curriculum_id = get_the_ID(); 
               $user_top_link = get_permalink($user_curriculum_id);
//               var_dump($user_top_link);
           ?>
        <?php if(!is_single($user_curriculum_id)){ ?>
            
           <a href="<?php echo $user_top_link.'?para1='.$user_para_id.'&para2='.$user_para_name; ?>#register_area">申込みページへ</a>
           
        <?php } else { ?>
            <form action='<?php bloginfo('template_url'); ?>_child/paypal/expresscheckout.php' METHOD='POST'>
                <input type="hidden" name="course_name" value="<?php the_title(); ?>">
                <input type="hidden" name="regist_teacher_id" value="<?php echo $user_para_id; ?>">
                <?php $user_tuition_fee_online = get_the_author_meta('user_tuition_fee_online' ,$user_para_id); ?>
                <?php $user_tuition_fee_commute = get_the_author_meta('user_tuition_fee_commute' ,$user_para_id); ?>
                <p><input id="monthly" type="radio" value="1" name="course_type" required>通信コース&nbsp;<?php echo $user_tuition_fee_online; ?>円<br>
                    <input id="monthly" type="radio" value="2" name="course_type" required>通学コース&nbsp;<?php echo $user_tuition_fee_commute; ?>円</p>
                <p><input type='image' name='submit' src='http://saishokukenbi.jp/wp-content/uploads/2014/10/entry.png'alt='Check out with PayPal' width="315"/></p>
            </form>
        <?php } ?>
           <?php  endwhile; endif; wp_reset_query;?>
     </div>
    <!--/※ペイパル実装済み-->
    
    
    <!--<a href="<?php get_stylesheet_directory_uri(); ?>/registration/"><img src="http://saishokukenbi.jp/wp-content/uploads/2014/10/entry.png"></a>-->
<!--    <form action="index.php?event=INPUT1" method="POST">
    <input type="image" name="submit" src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" border="0" align="top" alt="Check out with PayPal">
    </form>-->


    <?php else :?>
    <p>ログイン中：登録済</p
    <a href="<?php echo 'http://saishokukenbi.jp/community?para1='.$user_para_id.'&para2='.$user_para_name.'/';?>"><h1>コミュニティページへ</h1></a>
    <a href="saishokukenbi.jp/register-2/"><h1>登録済み</h1></a>
    <!--<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="frm1">
	<input type="hidden" name="charset" value="UTF-8" />
	<input type="hidden" name="cmd" value="_ext-enter" />
	<input type="hidden" name="redirect_cmd" value="_xclick" />
	<input type="hidden" name="business" value="noda1283@gmail.com" />
	<input type="hidden" name="item_name" value="才色兼備アカデミー1" />
	<input type="hidden" name="item_number" value="2022" />
	<input type="hidden" name="amount" value="500" />
	<input type="hidden" name="invoice"  id="invoice" value="00212" />
	<input type="hidden" name="shipping" value="0" />
	<input type="hidden" name="no_shipping" value="2" />
	<input type="hidden" name="currency_code" value="JPY" />
	<input type="hidden" name="lc" value="en" />
	<input name="cancel_return" type="hidden" id="cancel_return" value="http://saishokukenbi.jp/" />
	<input name="return" type="hidden" id="return" value="http://saishokukenbi.jp/paypal_end/" />
	<input name="notify_url" type="hidden" id="notify_url" value="<?php // bloginfo('template_url'); ?>/common.php" />

	<input type="hidden" name="first_name" value="" />
	<input type="hidden" name="last_name" value="" />
	<input type="hidden" name="zip" value="180-0023"/>
	<input type="hidden" name="city" value="" />
	<input type="hidden" name="address1" value="" />
	<input type="hidden" name="H_PhoneNumber" value="" />
	<input type="hidden" name="email" value="info@example.jp" />
        <input type='image' name='submit' src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif' border='0' align='top' alt='Check out with PayPal'/>
</form>-->
<!--    <form action='http://saishokukenbi.jp/wp-content/themes/opinion_tcd018_child/paypal/expresscheckout.php' METHOD='POST'>
        <input id="monthly" type="radio" value="1" name="Payment_Amount" required> $1 per month<br>
        <input id="yearly" type="radio" value="10" name="Payment_Amount" required> $10 per year<br>
        <input id="biyearly" type="radio" value="18" name="Payment_Amount"> $18 per 2 years<br>
        <input type='image' name='submit' src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif' border='0' align='top' alt='Check out with PayPal'/>
    </form>-->



    <?php endif;?>
    <?php else :?>
    <p>ログインしてない</p>
    <a href="saishokukenbi.jp/register-2/"><h1>登録</h1></a>
    <?php endif;?>
      
  </div>