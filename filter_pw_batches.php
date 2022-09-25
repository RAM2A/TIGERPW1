<?php 

$old_batches = @get_json('batches.json');

function save_json($path,$array){
 // $fp = fopen($path, 'w');
//fwrite($fp, json_encode($array));
//fclose($fp);
  return file_put_contents($path,json_encode($array));
  
}

function get_json($path){ return json_decode(file_get_contents($path), true);
  
}

$final_ = [];

foreach ($old_batches as $key=>$value) {
foreach ($value as $key=>$value) {
}
}


?>
