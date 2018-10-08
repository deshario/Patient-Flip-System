<?php
sendLineMsg("hello world");
function sendLineMsg($message){
    $chOne = curl_init();
    curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
    curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); // SSL USE
    curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt( $chOne, CURLOPT_POST, 1); // SSL USE
    curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");// Message
    curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
    $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer AbyJ7HavjiRgziR2QS5jue2vf8nvEZmKB6tu50k2tOn', );
    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
    curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec( $chOne );
    if(curl_error($chOne)){
        $error = curl_error($chOne);
        echo "<script>console.log('Error :: $error ')</script>";
    }else{
        $result_ = json_decode($result, true);
        $status = $result_['status'];
        echo "<script>console.log('Status :: $status ')</script>";
    }
    curl_close( $chOne );
}
?>