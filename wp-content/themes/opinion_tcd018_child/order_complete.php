<?php
/*
Template Name: order_complete
*/
?>
<?php
	/*==================================================================
	 PayPal Express Checkout Call
	 ===================================================================
	*/


require_once ("paypal/paypalfunctions.php");
$PaymentOption = "PayPal"; //追加
if ( $PaymentOption == "PayPal" )
{
	/*
	'------------------------------------
	' The paymentAmount is the total value of 
	' the shopping cart, that was set 
	' earlier in a session variable 
	' by the shopping cart page
	'------------------------------------
	*/
	
	$finalPaymentAmount =  $_SESSION["Payment_Amount"];
		
        //定期支払い金額
        $recurringPayment = $_SESSION["Payment_Recurring"];
        $course_name = $_SESSION['course_name'];
        $course_type = $_SESSION['course_type'];
        
	/*
	'------------------------------------
	' Calls the DoExpressCheckoutPayment API call
	'
	' The ConfirmPayment function is defined in the file PayPalFunctions.jsp,
	' that is included at the top of this file.
	'-------------------------------------------------
	*/

	$resArray = ConfirmPayment ( $finalPaymentAmount );
	$ack = strtoupper($resArray["ACK"]);
	if( $ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING" )
	{
		/*
		'********************************************************************************************************************
		'
		' THE PARTNER SHOULD SAVE THE KEY TRANSACTION RELATED INFORMATION LIKE 
		'                    transactionId & orderTime 
		'  IN THEIR OWN  DATABASE
		' AND THE REST OF THE INFORMATION CAN BE USED TO UNDERSTAND THE STATUS OF THE PAYMENT 
		'
		'********************************************************************************************************************
		*/

		$transactionId		= $resArray["PAYMENTINFO_0_TRANSACTIONID"]; // ' Unique transaction ID of the payment. Note:  If the PaymentAction of the request was Authorization or Order, this value is your AuthorizationID for use with the Authorization & Capture APIs. 
		$transactionType 	= $resArray["PAYMENTINFO_0_TRANSACTIONTYPE"]; //' The type of transaction Possible values: l  cart l  express-checkout 
		$paymentType		= $resArray["PAYMENTINFO_0_PAYMENTTYPE"];  //' Indicates whether the payment is instant or delayed. Possible values: l  none l  echeck l  instant 
		$orderTime 			= $resArray["PAYMENTINFO_0_ORDERTIME"];  //' Time/date stamp of payment
		$amt				= $resArray["PAYMENTINFO_0_AMT"];  //' The final amount charged, including any shipping and taxes from your Merchant Profile.
		$currencyCode		= $resArray["PAYMENTINFO_0_CURRENCYCODE"];  //' A three-character currency code for one of the currencies listed in PayPay-Supported Transactional Currencies. Default: USD. 
		$feeAmt				= $resArray["PAYMENTINFO_0_FEEAMT"];  //' PayPal fee amount charged for the transaction
		$settleAmt			= $resArray["PAYMENTINFO_0_SETTLEAMT"];  //' Amount deposited in your PayPal account after a currency conversion.
		$taxAmt				= $resArray["PAYMENTINFO_0_TAXAMT"];  //' Tax charged on the transaction.
		$exchangeRate		= $resArray["PAYMENTINFO_0_EXCHANGERATE"];  //' Exchange rate if a currency conversion occurred. Relevant only if your are billing in their non-primary currency. If the customer chooses to pay with a currency other than the non-primary currency, the conversion occurs in the customer's account.
		
		/*
		' Status of the payment: 
				'Completed: The payment has been completed, and the funds have been added successfully to your account balance.
				'Pending: The payment is pending. See the PendingReason element for more information. 
		*/
		
		$paymentStatus	= $resArray["PAYMENTINFO_0_PAYMENTSTATUS"]; 

		/*
		'The reason the payment is pending:
		'  none: No pending reason 
		'  address: The payment is pending because your customer did not include a confirmed shipping address and your Payment Receiving Preferences is set such that you want to manually accept or deny each of these payments. To change your preference, go to the Preferences section of your Profile. 
		'  echeck: The payment is pending because it was made by an eCheck that has not yet cleared. 
		'  intl: The payment is pending because you hold a non-U.S. account and do not have a withdrawal mechanism. You must manually accept or deny this payment from your Account Overview. 		
		'  multi-currency: You do not have a balance in the currency sent, and you do not have your Payment Receiving Preferences set to automatically convert and accept this payment. You must manually accept or deny this payment. 
		'  verify: The payment is pending because you are not yet verified. You must verify your account before you can accept this payment. 
		'  other: The payment is pending for a reason other than those listed above. For more information, contact PayPal customer service. 
		*/
		
		$pendingReason	= $resArray["PAYMENTINFO_0_PENDINGREASON"];  

		/*
		'The reason for a reversal if TransactionType is reversal:
		'  none: No reason code 
		'  chargeback: A reversal has occurred on this transaction due to a chargeback by your customer. 
		'  guarantee: A reversal has occurred on this transaction due to your customer triggering a money-back guarantee. 
		'  buyer-complaint: A reversal has occurred on this transaction due to a complaint about the transaction from your customer. 
		'  refund: A reversal has occurred on this transaction because you have given the customer a refund. 
		'  other: A reversal has occurred on this transaction due to a reason not listed above. 
		*/
		
		$reasonCode		= $resArray["PAYMENTINFO_0_REASONCODE"];
                
	}
	else  
	{
		//Display a user friendly Error on the page using any of the following error information returned by PayPal
		$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
		$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
		$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
		$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
		
		echo "GetExpressCheckoutDetails API call failed. ";
		echo "Detailed Error Message: " . $ErrorLongMsg;
		echo "Short Error Message: " . $ErrorShortMsg;
		echo "Error Code: " . $ErrorCode;
		echo "Error Severity Code: " . $ErrorSeverityCode;
	}
        
        $resArray2 = CallCreateRecurringPaymentsProfile($recurringPayment, $course_name, $course_type);
	$ack = strtoupper($resArray2["ACK"]);
	if( $ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING" )
	{
                require_once(ABSPATH . WPINC . '/registration.php');
                $teacher_data = get_user_by( 'id', $_SESSION['regist_teacher_id']);
                var_dump($teacher_data);
                $teacher_name = $teacher_data->user_login;
                var_dump($_SESSION["login_already"]);
                if(empty($_SESSION["login_already"])){
                    $username = $_POST['accountID'];
                    $password = $_POST['accountPW'];
                    $email = $_SESSION['email'];
                    var_dump($username);
                    $new_user_id = wp_create_user( $username, $password, $email );
                    if( isset( $new_user_id ) && !is_wp_error( $new_user_id ) ){
                        $return = update_user_meta( $new_user_id, 'application',  $teacher_name );
                    }
                }else{
                    $my_data = get_user_by( 'login',$_SESSION["login_already"]);
                    $my_name = $my_data->user_login;
                    $my_application = $my_data->application;
                    if(empty($my_application)){
                        //初回　自分のapp更新
                         $return = update_user_meta( $my_data->ID, 'application',  $teacher_name );
                    }else{
                        //２回目　自分のapp更新
                        $applications = $my_application.','.$teacher_name;
                        $return = update_user_meta( $my_data->ID, 'application',  $applications );

                    }
                    $teacher_application = $teacher_data->application;
                    if(empty($teacher_application)){
                         $return = update_user_meta( $teacher_data->ID, 'application',  $my_name );
                    }else{
                        $teacher_applications = $teacher_application.','.$my_name;
                        $return = update_user_meta( $teacher_data->ID, 'application',  $teacher_applications );
                    }
                }
                //アフィリエイトバナーを踏んで来ていた場合
                if($affiliate_code){

                    /*----アフィリエイト情報をデータベースへ格納----*/
                    global $wpdb;

                    //データ整理
                    $name = $_SESSION['firstname'].$_SESSION['lastname'];
                    $date = date("Y/m/j");
                    $affiliate_code = $_COOKIE['Saishokukenbi_A_Cookie'];

                    //デバッグ用
                    $wpdb->show_errors();

                    $sql_rsl = $wpdb->query( $wpdb->prepare("insert into $wpdb->affiliate ( name, tuition_fee, introducer_id, registration_date ) values (%s, %d, %s, %s)", $name, $recurringPayment, $affiliate_code, $date));
                }
	}
	else  
	{
		//Display a user friendly Error on the page using any of the following error information returned by PayPal
//		$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
//		$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
//		$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
//		$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
//		
//		echo "CallCreateRecurringPaymentsProfile API call failed. ";
//		echo "Detailed Error Message: " . $ErrorLongMsg;
//		echo "Short Error Message: " . $ErrorShortMsg;
//		echo "Error Code: " . $ErrorCode;
//		echo "Error Severity Code: " . $ErrorSeverityCode;
	}
}		
		
?>


<?php get_header('community'); $options = get_desing_plus_option(); ?>
<div id="main_col">
 <ul id="bread_crumb" class="clearfix">
  <li class="home"><a href="<?php echo esc_url(home_url('/')); ?>"><span><?php _e('Home', 'tcd-w'); ?></span></a></li>
  <li class="last"><?php the_title(); ?>お申し込み完了</li>
 </ul>

 <div id="left_col" class="clearfix">
  
  <div class="left_block">
      
<?php 
 if( $ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING" )
	{     
?>
    <!--申込み御礼のメッセージ-->
    <p>お申し込みありがとうございます。決済が完了いたしました。<br>
    お申し込みをされた講師の、コミュニティページに入ることができます。<br>
    講師とコミュニケーションを取り、あなたの夢を叶えてください！</p>
    <a href="<?php echo bloginfo('url'); ?>/community/?para1=<?php echo $_SESSION['regist_teacher_id']; ?>para=<?php echo $teacher_name; ?>">コミュニティページへ</a>
<?php } else { ?>
    <p>正しく決済されませんでした。<br>
        お手数をおかけいたしますが、事務局までお問い合わせくださいませ。<br><br>
        才職兼美アカデミー運営事務局<br>
        電話番号：<br>
    メールアドレス：</p>
    <a href="<?php echo bloginfo('url'); ?>/detailed_information//?para1=<?php echo $_SESSION['regist_teacher_id']; ?>para=<?php echo $teacher_name; ?>"></a>
    
        
<?php } ?>
      
      
	<?php
		//debug
                //データベースに入れる値（アフィリエイト）
//                echo 'アフィリエイト情報';
//                echo '受講生名'.$_SESSION['firstname'].$_SESSION['lastname'];
//                echo '講座名'.$_SESSION['course_name'].$_SESSION['course_type'];
//                echo '講師ID'.$_SESSION['regist_teacher_id'];
//                echo '受講料（月額）'.$recurringPayment;
////                var_dump($_SESSION['Payment_Recurring']);
//                echo '紹介者名'.$_COOKIE['Saishokukenbi_A_Cookie'];
//                echo time();
//                ?><p></p><?php
//                //ユーザーアカウント
//                echo 'ユーザーアカウント';
//                echo $_POST['accountID'];
//                echo $_POST['accountPW'];
//                echo $_SESSION['email'];
                
//                $link = mysqli_connect("mysql201.sixcore.ne.jp", "dresh_wp1", "l23s12r1", "dresh_wp1");
//                $result = mysqli_query($link, "select meta_value from wp_usermeta where user_id = 24 && meta_key = 'user_tuition_fee_online'");
//                $row = mysqli_fetch_array($result);
//                echo $row[0];
                

	?>
      
  </div>
     
 </div><!-- END #left_col -->
 
<?php get_template_part('sidebar1'); ?>
 
</div><!-- END #main_col -->

<?php get_template_part('sidebar2'); ?>

<?php get_footer(); ?>
