<?php
function tml_new_user_registered( $user_id ) {
        
        if(isset($_POST['price'])) {
            $price  =  $_POST['price'];
         }
         if(isset($_POST['teacher_name'])) {
             $teacher_name  =  $_POST['teacher_name'];
         }
         if(isset($_POST['user_login'])) {
             $teacher_name  =  $_POST['user_login'];
         }
         $url = 'http://saishokukenbi.jp/wp-content/themes/opinion_tcd018_child/paypal/expresscheckout.php';
         $data = array(
            'Payment_Amount' => $price
        );
        $options = array('http' => array(
            'method' => 'POST',
            'content' => http_build_query($data),
        ));
        $contents = file_get_contents($url, false, stream_context_create($options)); 
        exit;
}
add_action( 'tml_new_user_registered', 'tml_new_user_registered' );
?>
