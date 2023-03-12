<?php
set_time_limit(0);
error_reporting( E_ALL );
function save_json($path,$array){
 // $fp = fopen($path, 'w');
//fwrite($fp, json_encode($array));
//fclose($fp);
  return file_put_contents($path,json_encode($array));
  
}

function get_json($path){ return json_decode(file_get_contents($path), true);
  
}

require('./endpoints.php');

// parse_str($argv[1], $params);

// send_tg_updates(json_encode($params));

    $khazanaProgramId = $argv[3];
  
  $subjects = @get_json("khazana/subjects/$khazanaProgramId.json");
  $index = $argv[1] - 10;
  $chindex = $argv[2] - 10;

  $khazanaProgramData = getKhazanaDetails($khazanaProgramId);

  
  $khslug = $khazanaProgramData['slug'];
  $subject = $subjects[$index];
  $sub_slug = $subject['slug'];
    $chapters = $subject['chapters'];

  $ch = $chapters[$chindex];
      $chslug = $ch['slug'];
    $chid = $ch['_id'];
    
    echo 'Adding Chapter: <b>'.$ch["description"].' in </b> '.$subject["name"].'<br><br>';  
    send_tg_updates( 'Adding Chapter: <b>'.$ch["description"].' in </b> '.$subject["name"]);


    $topics = getKhazanaTopics($khslug,$sub_slug,$chslug);
    
      foreach($topics as $topic_index => $tc){
        $topic_id = $tc['_id'];
            
    echo 'Adding Topic:' .$tc["name"].'<br>';  
    send_tg_updates( 'Adding Topic:' .$tc["name"]);

        
        $sub_topics = getKhazanaSubTopics($khslug,$sub_slug,$chslug,$topic_id);
        
              foreach($sub_topics as $sub_topic_index => $stc){
              $sub_topic_id = $stc['_id'];
              $sub_sub_topics = getKhazanaSubSubTopics($khslug,$sub_slug,$chslug,$topic_id,$sub_topic_id);
              $sub_topics[$sub_topic_index]['sub_topic_data'] = $sub_sub_topics;
                // print_r($sub_sub_topics);
          sleep(3);
              }
        
             $topics[$topic_index]['sub_topics'] = $sub_topics;
                sleep(3);

      }
    $kkkk = $index+10;
  
    
    // save_json("khazana/chapters/$chid.json",$topics);

    echo "\nDONE DONE DONE";
send_tg_updates("✔️ DONE DONE DONE");
?>