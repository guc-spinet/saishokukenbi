<?php
/*
Template Name: review
*/
?>
<?php
/*==================================================================
 PayPal Express Checkout Call
 ===================================================================
*/
// Check to see if the Request object contains a variable named 'token'	
$token = "";
if (isset($_REQUEST['token']))
{
	$token = $_REQUEST['token'];
	
}

// If the Request object contains the variable 'token' then it means that the user is coming from PayPal site.	
if ( $token != "" )
{

	require_once ("paypal/paypalfunctions.php");

	/*
	'------------------------------------
	' Calls the GetExpressCheckoutDetails API call
	'
	' The GetShippingDetails function is defined in PayPalFunctions.jsp
	' included at the top of this file.
	'-------------------------------------------------
	*/
	
        
	$resArray = GetShippingDetails( $token );
	$ack = strtoupper($resArray["ACK"]);
	if( $ack == "SUCCESS" || $ack == "SUCESSWITHWARNING") 
	{
		/*
		' The information that is returned by the GetExpressCheckoutDetails call should be integrated by the partner into his Order Review 
		' page		
		*/
            //野田コード
//		$email 				= $resArray["EMAIL"]; // ' Email address of payer.
//		$payerId 			= $resArray["PAYERID"]; // ' Unique PayPal customer account identification number.
//		$payerStatus		= $resArray["PAYERSTATUS"]; // ' Status of payer. Character length and limitations: 10 single-byte alphabetic characters.
//		$salutation			= $resArray["SALUTATION"]; // ' Payer's salutation.
//		$firstName			= $resArray["FIRSTNAME"]; // ' Payer's first name.
//		$middleName			= $resArray["MIDDLENAME"]; // ' Payer's middle name.
//		$lastName			= $resArray["LASTNAME"]; // ' Payer's last name.
//		$suffix				= $resArray["SUFFIX"]; // ' Payer's suffix.
//		$cntryCode			= $resArray["COUNTRYCODE"]; // ' Payer's country of residence in the form of ISO standard 3166 two-character country codes.
//		$business			= $resArray["BUSINESS"]; // ' Payer's business name.
//		$_SESSION['PAYMENTREQUEST_0_SHIPTONAME']				= $resArray["PAYMENTREQUEST_0_SHIPTONAME"]; // ' Person's name associated with this address.
//		$_SESSION['PAYMENTREQUEST_0_SHIPTOSTREET']		= $resArray["PAYMENTREQUEST_0_SHIPTOSTREET"]; // ' First street address.
//		$shipToStreet2		= $resArray["PAYMENTREQUEST_0_SHIPTOSTREET2"]; // ' Second street address.
//		$_SESSION['PAYMENTREQUEST_0_SHIPTOCITY']			= $resArray["PAYMENTREQUEST_0_SHIPTOCITY"]; // ' Name of city.
//		$_SESSION['PAYMENTREQUEST_0_SHIPTOSTATE']		= $resArray["PAYMENTREQUEST_0_SHIPTOSTATE"]; // ' State or province
//		$_SESSION['PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE']	= $resArray["PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE"]; // ' Country code. 
//		$_SESSION['PAYMENTREQUEST_0_SHIPTOZIP']			= $resArray["PAYMENTREQUEST_0_SHIPTOZIP"]; // ' U.S. Zip code or other country-specific postal code.
//		$addressStatus 		= $resArray["ADDRESSSTATUS"]; // ' Status of street address on file with PayPal   
//		$invoiceNumber		= $resArray["INVNUM"]; // ' Your own invoice or tracking number, as set by you in the element of the same name in SetExpressCheckout request .
//		$phonNumber			= $resArray["PHONENUM"]; // ' Payer's contact telephone number. Note:  PayPal returns a contact telephone number only if your Merchant account profile settings require that the buyer enter one. 
//                $L_BILLINGTYPE0			= $resArray["L_BILLINGTYPE0"];
//                $L_BILLINGAGREEMENTDESCRIPTION0	= $resArray["L_BILLINGAGREEMENTDESCRIPTION0"];
            
            //上田コード
            $_SESSION['email']  = "";
            $_SESSION['email']              = $resArray["EMAIL"]; // ' Email address of payer.
            $payerId 			= $resArray["PAYERID"]; // ' Unique PayPal customer account identification number.
            $payerStatus		= $resArray["PAYERSTATUS"]; // ' Status of payer. Character length and limitations: 10 single-byte alphabetic characters.
            $salutation			= $resArray["SALUTATION"]; // ' Payer's salutation.
            $_SESSION['firstname']			= $resArray["FIRSTNAME"]; // ' Payer's first name.
            $middleName			= $resArray["MIDDLENAME"]; // ' Payer's middle name.
            $_SESSION['lastname']			= $resArray["LASTNAME"]; // ' Payer's last name.
            $suffix				= $resArray["SUFFIX"]; // ' Payer's suffix.
            $cntryCode			= $resArray["COUNTRYCODE"]; // ' Payer's country of residence in the form of ISO standard 3166 two-character country codes.
            $business			= $resArray["BUSINESS"]; // ' Payer's business name.
            $shipToName			= $resArray["PAYMENTREQUEST_0_SHIPTONAME"]; // ' Person's name associated with this address.
            $shipToStreet		= $resArray["PAYMENTREQUEST_0_SHIPTOSTREET"]; // ' First street address.
            $shipToStreet2		= $resArray["PAYMENTREQUEST_0_SHIPTOSTREET2"]; // ' Second street address.
            $shipToCity			= $resArray["PAYMENTREQUEST_0_SHIPTOCITY"]; // ' Name of city.
            $shipToState		= $resArray["PAYMENTREQUEST_0_SHIPTOSTATE"]; // ' State or province
            $shipToCntryCode	= $resArray["PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE"]; // ' Country code. 
            $shipToZip			= $resArray["PAYMENTREQUEST_0_SHIPTOZIP"]; // ' U.S. Zip code or other country-specific postal code.
            $addressStatus 		= $resArray["ADDRESSSTATUS"]; // ' Status of street address on file with PayPal   
            $invoiceNumber		= $resArray["INVNUM"]; // ' Your own invoice or tracking number, as set by you in the element of the same name in SetExpressCheckout request .
            $phonNumber			= $resArray["PHONENUM"]; // ' Payer's contact telephone number. Note:  PayPal returns a contact telephone number only if your Merchant account profile settings require that the buyer enter one. 
            $_SESSION['zip']    =   $resArray["ZIP"];
            $_SESSION['street'] =   $resArray["STREET"];
            $_SESSION["acct"]   =   $resArray["ACCT"];
            $_SESSION["countrycode"]   =   $resArray["COUNTRYCODE"];
            
            if(!$_SESSION['email']){
                echo 'エラーが発生しました。';
            }else{
                if(email_exists($_SESSION['email'])){
                     //登録済
                    $user_data = get_user_by( 'email', $_SESSION['email']);
                    $user_name = $user_data->login;
                    $user_pass = $user_data->password;
                    $user_pass_num = mb_strlen( $user_pass );
                    $_SESSION["login_already"]   =   '';
                    $_SESSION["login_already"]   =   $user_name;
                }else{
                    $_SESSION["login_already"] = "";
                }
            }
                
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
}
		
?>
<?php get_header('community'); $options = get_desing_plus_option(); ?>
<div id="main_col">
 <ul id="bread_crumb" class="clearfix">
  <li class="home"><a href="<?php echo esc_url(home_url('/')); ?>"><span><?php _e('Home', 'tcd-w'); ?></span></a></li>
  <li class="last"><?php the_title(); ?></li>
 </ul>

 <div id="left_col" class="clearfix">
  
  <div class="left_block">
      
     <div id='regist_confirm'>
         <form action='http://saishokukenbi.jp/order_complete' METHOD='POST'>
            <input type="hidden" name="Payment_Amount" value="<?php echo $_SESSION["Payment_Amount"]; ?>">
            <p>お申し込みはまだ完了していません。<br>アカウント作成に必要な項目があります。ご記入のうえ、確定ボタンを押してください。</p>
            <table>
                <tr>
                    <td style="padding: 10px; width: 100px;">ご希望のID</td>
                    <td style="padding: 10px;"><input type="text" name="accountID" required style="height: 20px; width: 200px;"></td>
                </tr>
                <tr>
                    <td style="padding: 10px; width: 100px;">パスワード</td>
                    <td style="padding: 10px;"><input type="password" name="accountPW" required style="height: 20px; width: 200px;"></td>
                </tr>
            </table>
<!--            <p>入学金：<?php echo number_format($_SESSION["Payment_Amount"]); ?>円<br>
                月会費：<?php echo number_format($_SESSION["Payment_Recurring"]); ?>円</p>-->
            <input type="submit" value="" id="paypal_submit_btn">
	</form>
     </div>
	
  </div>
     
 </div><!-- END #left_col -->
 
<?php get_template_part('sidebar1'); ?>
 
</div><!-- END #main_col -->

<?php get_template_part('sidebar2'); ?>

<?php get_footer(); ?>
