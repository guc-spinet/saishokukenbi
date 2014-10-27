<?php
$req = 'cmd=_notify-validate';
foreach ($_POST as $key => $value) {
	$value = urlencode(stripslashes($value));
	$req .= "&$key=$value";
}

$header .= "POST /cgi-bin/webscr HTTP/1.1¥r¥n";
$header .= "Content-Type: application/x-www-form-urlencoded¥r¥n";
$header .= "Content-Length: " . strlen($req) . "¥r¥n";
$header .= "Host:www.sandbox.paypal.com¥r¥n";
$header .= "Connection: close¥r¥n";
$header .= "¥r¥n";

$fp = fsockopen ("ssl://www.sandbox.paypal.com", 443, $errno, $errstr, 30);

//paypalからの情報取得
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$Invoice = isset($_POST['invoice']) ? $_POST['invoice'] : "0";
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];

$fname = $_POST['first_name'];
$lname = $_POST['last_name'];
$memail = $_POST['payer_email'];

if (!$fp) {
	//error
} else {
	
	fputs ($fp, $header . $req);
        $i = 1;
        $_SESSION["a"] = array();
	while (!feof($fp)) {
		$res = fgets ($fp, 1024);
		if (strcmp(trim($res), "VERIFIED") == 0) {
                    array_push($_SESSION["a"], $i);
                    $i ++;
		} else if (strcmp(trim($res), "INVALID") == 0) {
			//error
                    $i ++;
		}
	}
	fclose ($fp);
}
?>

