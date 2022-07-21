<?php
header('Access-Control-Allow-Origin: *');

require('./getpwtoken.php');

if(isset($_GET['key'])){
  echo getOTPToken($_GET['key'])["data"]["otp"];
}

  
?>