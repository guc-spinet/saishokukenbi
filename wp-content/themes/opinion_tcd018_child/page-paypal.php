<?php
/*
Template Name:paypal
*/
?>
<?php
$_SESSION["Payment_Amount"]  = $paymentAmount;
require_once("{$path}paypal/expresscheckout.php");

$event = get_GET('event');
 
//キャンセルの場合
if ($event == 'CANCELPAY') {
    //ログインキャンセル画面を表示
    header("Location:http://saishokukenbi.jp/");
    exit;
}
 
//認証された場合
if ($event == 'RETURNPAY') {
    $paymentAmount = $_SESSION["Payment_Amount"];
    require_once("{$path}paypal/review.php");
    $amount = number_format($paymentAmount);
    $request = number_format($paymentRequest);
}
 
//支払い確認画面 キャンセルの場合
if ($event == 'PAY_NG') {
    header("Location:http://saishokukenbi.jp/");
    exit;
}
 
//支払い確認画面 支払いされた場合
if ($event == 'PAY_OK') {
    $paymentAmount = $_SESSION["Payment_Amount"];
    require_once("{$path}paypal/order_complete.php");
    header("Location:http://saishokukenbi.jp/detailed_information/");
    exit;
}
?>
