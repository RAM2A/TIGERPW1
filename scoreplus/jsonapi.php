<?php

if (!function_exists('str_contains')) {
    function str_contains(string $haystack, string $needle): bool
    {
        return '' === $needle || false !== strpos($haystack, $needle);
    }
}


header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

if(isset($_GET['path'])){
	if(str_contains($_GET['path'],".json")){
  echo file_get_contents($_GET['path']);
	}
}

?>