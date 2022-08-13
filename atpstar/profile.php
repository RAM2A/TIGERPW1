<?php

require('./endpoints.php');
header('Content-Type: application/json; charset=utf-8');

 echo json_encode(getProfile()['data'][0]);

?>