<?php
/*
Template Name: paypal_end
*/
?>
<?php
var_dump($_SESSION["a"]);
?>
<?php get_header('community'); $options = get_desing_plus_option(); ?>
<div id="main_col">
 <ul id="bread_crumb" class="clearfix">
  <li class="home"><a href="<?php echo esc_url(home_url('/')); ?>"><span><?php _e('Home', 'tcd-w'); ?></span></a></li>
  <li class="last"><?php the_title(); ?></li>
 </ul>

 <div id="left_col" class="clearfix">
  
  <div class="left_block">
      
       <?php
       echo $item_name = $_POST['item_name'];
echo $item_number = $_POST['item_number'];
echo $payment_status = $_POST['payment_status'];
echo $payment_amount = $_POST['mc_gross'];
echo $payment_currency = $_POST['mc_currency'];
echo $txn_id = $_POST['txn_id'];
echo $Invoice = isset($_POST['invoice']) ? $_POST['invoice'] : "0";
echo $receiver_email = $_POST['receiver_email'];
echo $payer_email = $_POST['payer_email'];

echo $fname = $_POST['first_name'];
echo $lname = $_POST['last_name'];
echo $memail = $_POST['city'];
       ?>
      
  </div>
     
 </div><!-- END #left_col -->
 
<?php get_template_part('sidebar3'); ?>
 
</div><!-- END #main_col -->

<?php get_template_part('sidebar4'); ?>

<?php get_footer(); ?>
