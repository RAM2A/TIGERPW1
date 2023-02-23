<?php 
// header('Content-Type: application/json; charset=utf-8');
// echo "OPTIMIZING IMPORTED BATCHES";


// include('endpoints.php');
// $old_batches = @get_json('batches_un.json');


// function _group_by($array, $key) {
//     $return = array();
//     foreach($array as $val) {
//         $return[$val[$key]][] = $val;
//     }
//     return $return;
// }

// function save_json($path,$array){
//  // $fp = fopen($path, 'w');
// //fwrite($fp, json_encode($array));
// //fclose($fp);
//   return file_put_contents($path,json_encode($array));
  
// }

// function get_json($path){ return json_decode(file_get_contents($path), true);
  
// }

// $final_ = [];
// $final_batches = [];
// $final_ids = [];

// foreach ($old_batches as $value) {
// foreach ($value as $v) {
//   $final_[] = $v;
//   }
// }

// $batch_d = _group_by($final_,'id');

// foreach ($batch_d as $value) {
//   $max = [];

//   foreach ($value as $v) {
//   $max[] = count($v["details"]["subjects"]);
//   }

  

//   $maximum = max($max);
//   $final_batches[] = $value[array_search($maximum, $max)];

  
// }

// $final_fi= [];

// foreach ($final_batches as $v) {
  
//   $da = getBatchDetails($v['id']);
//   $da['description'] = '';
//   $v['details'] = $da;
//   $final_fi[]= $v;
//   echo 'OPTIMIZING '.$da['name'].'<br>';
// }

// $arrr = ["ALLBATCHES" => $final_fi];

//   save_json('batches.json',$arrr);

//   echo '<script>location.replace("jsonadd.php")</script>';
function run($command, $outputFile = 'runlock_optimize.txt') {
    $processId = shell_exec(sprintf(
        '%s > %s 2>&1 & echo $!',
        $command,
        $outputFile
    ));
       
      print_r("processID of process in background is: "
        . $processId);
}

// // echo json_encode($final_batches);


  
if( @strpos(file_get_contents("runlock_optimize.txt"),"DONE DONE DONE") !== false) {    
file_put_contents("runlock_optimize.txt", '');
run("php filter_pw_batches_back.php");
print_r("Task Added.processID is: ".getmypid());
}else{
  echo "wait for previous batchs to optimize fully\n";
}




?>
