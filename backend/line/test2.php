<?php
$token = 'AbyJ7HavjiRgziR2QS5jue2vf8nvEZmKB6tu50k2tOn';
$file_name_with_full_path = 'D:\\pic.jpg';
if (function_exists('curl_file_create')) {
  $cFile = curl_file_create($file_name_with_full_path);
} else {
  $cFile = '@'.realpath($file_name_with_full_path);
}
$post = array('message' => 'สวัสดี','imageFile'=> $cFile);

print_r(LineNotify::PushMessage($token,$post));

class LineNotify
{
  public function PushMessage($token, $body)
  {
    $result_ = "";
    $chOne = curl_init();
    curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
    // SSL USE
    curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
    //POST
    curl_setopt( $chOne, CURLOPT_POST, 1);
    curl_setopt( $chOne, CURLOPT_POSTFIELDS, $body);
    curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
    //ADD header array
    $headers = array( 'Content-type: multipart/form-data', 'Authorization: Bearer '.$token, );
    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
    //RETURN
    curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec( $chOne );
    //Check error
    if(curl_error($chOne)) {
        $error_ = array('status' => "Error",'massage' => curl_error($chOne));
        $result_ = json_decode($error_, true);
    }
    else {
      $result_ = json_decode($result, true);
    }
    //Close connect
    curl_close( $chOne );
    return  $result_;
  }
}
?>