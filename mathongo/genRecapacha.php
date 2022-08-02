<?php

$sitekey = "6LfK6TocAAAAAPP6z6uXcecKqPLq1-MfDHShRXAf";
$site = "https://iam.mathongo.com";


$vToken = file_get_contents("https://www.google.com/recaptcha/api.js?render=$sitekey");

$vtok = substr($vToken,stripos($vToken, 'releases/')+9);
$vtok = substr($vtok,0,stripos($vtok, '/'));

$recapToken = file_get_contents("https://www.google.com/recaptcha/api2/anchor?ar=1&hl=en&size=invisible&cb=cs3&k=$sitekey&co=$site&v=$vtok");


echo $recapToken;
?>