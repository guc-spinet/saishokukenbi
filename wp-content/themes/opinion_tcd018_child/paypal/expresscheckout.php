<?php
/*
Template Name: expresscheckout
*/
?>
<?php
session_start();
require_once ("paypalfunctions.php");
//データベースに直接接続して金額を取得
//データベース接続
//?>
<?php

// ==================================
// PayPal Express Checkout Module
// ==================================

//'------------------------------------
//' The paymentAmount is the total value of 
//' the shopping cart, that was set 
//' earlier in a session variable 
//' by the shopping cart page
//'------------------------------------

//コース情報の格納
$_SESSION['course_name'] = $_POST['course_name'];
$course_name = $_SESSION['course_name'];

if($_POST['course_type'] == 1) {
    $_SESSION['course_type'] = '通信コース';
    $link = mysqli_connect("mysql201.sixcore.ne.jp", "dresh_wp1", "l23s12r1", "dresh_wp1");
    $result = mysqli_query($link, "select meta_value from wp_usermeta where user_id = ".$_POST['regist_teacher_id']."&& meta_key = 'user_tuition_fee_online'");
    $row = mysqli_fetch_array($result);
    $_SESSION["Payment_Recurring"] = $row[0];
    mysqli_free_result($result);
    mysqli_close($link);
} elseif ($_POST['course_type'] == 2) {
    $_SESSION['course_type'] = '通学コース';
    $link = mysqli_connect("mysql201.sixcore.ne.jp", "dresh_wp1", "l23s12r1", "dresh_wp1");
    $result = mysqli_query($link, "select meta_value from wp_usermeta where user_id = ".$_POST['regist_teacher_id']."&& meta_key = 'user_tuition_fee_commute'");
    $row = mysqli_fetch_array($result);
    $_SESSION["Payment_Recurring"] = $row[0];
    mysqli_free_result($result);
    mysqli_close($link);
} else {
    //エラーを返す
}
$course_type = $_SESSION['course_type'];

//受講する講師のID格納
$_SESSION['regist_teacher_id'] = $_POST['regist_teacher_id'];

//定期支払い金額の格納
//$_SESSION["Payment_Recurring"]  = $_POST['Payment_Recurring'];
$paymentRecurring = $_SESSION["Payment_Recurring"];

$paymentAmount = 32400;
$_SESSION['Payment_Amout'] = $paymentAmount;


//'------------------------------------
//' The currencyCodeType and paymentType 
//' are set to the selections made on the Integration Assistant 
//'------------------------------------
$currencyCodeType = "JPY";
$paymentType = "Sale";

//'------------------------------------
//' The returnURL is the location where buyers return to when a
//' payment has been succesfully authorized.
//'
//' This is set to the value entered on the Integration Assistant 
//'------------------------------------
$returnURL = "http://saishokukenbi.jp/review/";

//'------------------------------------
//' The cancelURL is the location buyers are sent to when they hit the
//' cancel button during authorization of payment during the PayPal flow
//'
//' This is set to the value entered on the Integration Assistant 
//'------------------------------------
$cancelURL = "http://saishokukenbi.jp/detailed_information/%E3%83%86%E3%82%B9%E3%83%88%E3%82%B5%E3%83%B3%E3%83%97%E3%83%AB/?para1=1&para2=dresh";

//'------------------------------------
//' Calls the SetExpressCheckout API call
//'
//' The CallShortcutExpressCheckout function is defined in the file PayPalFunctions.php,
//' it is included at the top of this file.
//'-------------------------------------------------

$resArray = CallShortcutExpressCheckout( $paymentAmount, $currencyCodeType, $paymentType, $returnURL, $cancelURL, $course_name, $course_type);
$ack = strtoupper($resArray["ACK"]);
if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING")
{
	RedirectToPayPal ( $resArray["TOKEN"] );
} 
else  
{
	//Display a user friendly Error on the page using any of the following error information returned by PayPal
	$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
	$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
	$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
	$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
	
	echo "SetExpressCheckout API call failed. ";
	echo "Detailed Error Message: " . $ErrorLongMsg;
	echo "Short Error Message: " . $ErrorShortMsg;
	echo "Error Code: " . $ErrorCode;
	echo "Error Severity Code: " . $ErrorSeverityCode;
}
?>