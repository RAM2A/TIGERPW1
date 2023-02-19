
<?php
function save_json($path,$array){
 // $fp = fopen($path, 'w');
//fwrite($fp, json_encode($array));
//fclose($fp);
  return file_put_contents($path,json_encode($array));
  
}

function get_json($path){ return json_decode(file_get_contents($path), true);
  
}


function send_tg_updates($msg){
  $ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot5918206900:AAF3vqYtwlEUyKrwMk1j2I7yPYka9TAygaY/sendMessage');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded',
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, "chat_id=-1001895705515&text=$msg&parse_mode=html");

$response = curl_exec($ch);

curl_close($ch);
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




?>