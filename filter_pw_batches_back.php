<?php 
// header('Content-Type: application/json; charset=utf-8');
set_time_limit(0);


include('endpoints.php');
echo "OPTIMIZING IMPORTED BATCHES";
$old_batches = @get_json('batches_un.json');


function _group_by($array, $key) {
    $return = array();
    foreach($array as $val) {
        $return[$val[$key]][] = $val;
    }
    return $return;
}

function save_json($path,$array){
 // $fp = fopen($path, 'w');
//fwrite($fp, json_encode($array));
//fclose($fp);
  return file_put_contents($path,json_encode($array));
  
}

function get_json($path){ return json_decode(file_get_contents($path), true);
  
}

$final_ = [];
$final_batches = [];
$final_ids = [];

foreach ($old_batches as $value) {
foreach ($value as $v) {
  $final_[] = $v;
  }
}

$batch_d = _group_by($final_,'id');

foreach ($batch_d as $value) {
  $max = [];

  foreach ($value as $v) {
  $max[] = count($v["details"]["subjects"]);
  }

  

  $maximum = max($max);
  $final_batches[] = $value[array_search($maximum, $max)];

  
}

$final_fi= [];

foreach ($final_batches as $v) {

  $da = getBatchDetails($v['id']);
  $da['description'] = '';
  $v['details'] = $da;
  $final_fi[]= $v;
  echo 'OPTIMIZING '.$da['name'].'<br>';
  send_tg_updates('OPTIMIZING '.$da['name']);

      sleep(3);
}

$arrr = ["ALLBATCHES" => $final_fi];

  save_json('batches.json',$arrr);

  echo 'DONE DONE DONE';

send_tg_updates("✔️ DONE DONE DONE");


// echo json_encode($final_batches);




?>
