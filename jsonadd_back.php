
<?php
function save_json($path,$array){
 // $fp = fopen($path, 'w');
//fwrite($fp, json_encode($array));
//fclose($fp);
  return file_put_contents($path,json_encode($array));
  
}

function get_json($path){ return json_decode(file_get_contents($path), true);
  
}





set_time_limit(0);

require('./endpoints.php');

$batch_id = file_get_contents("currbatch.txt");
$batchdet = getBatchDetails($batch_id);
$subjects = $batchdet["subjects"];
$batchSlug = $batchdet["slug"];
    
foreach($subjects as $subject){
    $subject_data = getTopicDetails(urlencode($batchSlug),$subject["slug"]);

  
  foreach($subject_data as $index => $topic){

    $subject_data[$index]["_id"] = $subject["slug"].$topic["slug"];
      
    $suptopic = new stdClass();
    $suptopic->videos = getSubTopicDetails(urlencode($batchSlug), $subject["slug"], $topic["slug"],'videos');
    $suptopic->notes = getSubTopicDetails(urlencode($batchSlug) ,$subject["slug"], $topic["slug"],'notes');
        $suptopic->DppNotes = getSubTopicDetails(urlencode($batchSlug) ,$subject["slug"], $topic["slug"],'DppNotes');
        $suptopic->DppVideos = getSubTopicDetails(urlencode($batchSlug) ,$subject["slug"], $topic["slug"],'DppVideos');
         $suptopic->exercises = getSubTopicDetails(urlencode($batchSlug) ,$subject["slug"], $topic["slug"],'exercises');


      $saveto = "subtopics/".$subject["slug"].$topic["slug"].".json";
    save_json($saveto,$suptopic);

echo 'Adding Topic:'.$topic["name"]." in <b>".$batchdet["name"].'</b><br><br>';

    send_tg_updates('Adding Topic:'.$topic["name"]." in <b>".$batchdet["name"].'</b>');
    
    sleep(3);

    }

  // print_r($subject_data);
  
  $savetoSub = "topics/".$subject["_id"].".json";
      save_json($savetoSub,$subject_data);

    
  }
    echo "\nDONE DONE DONE";
send_tg_updates("✔️ DONE DONE DONE");



?>