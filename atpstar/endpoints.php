<?php


function getBaseHeaders()
{
    return [
    'host' => 'atpstar.com',
    'content-type' => 'application/x-www-form-urlencoded',
    'user-agent' => 'okhttp/5.0.0-alpha.2'
    ];
}


function getBasePOSTDATA($add=[])
{
    $token = file_get_contents('./token.txt');
   
//token - fcG8rhJZ7g

  
    return array_merge([
    // 'subject_type' => 'addon',
    'users_id' => '99503',
    'device_type' => 'Android',	
    'access_token' => $token,	
    'type' => 'mobile'
    ],$add);
}





function file_getsuper_contents($url, $headerData)
{
    // $postdata = http_build_query($postOptions);


  
    array_walk($headerData, static function (&$v, $k) {
        $v = $k . ': ' . $v;
    });

    $headerData = implode("\n", $headerData);


    $opts = array(
        'http' =>
        array(
            'method'  => 'GET',
            'header' => $headerData,
        )
    );

    $context = stream_context_create($opts);
    return file_get_contents($url, false, $context);
}



function file_postsuper_contents($url, $headerData,$postOptions)
{
    $postdata = http_build_query($postOptions);


  
    array_walk($headerData, static function (&$v, $k) {
        $v = $k . ': ' . $v;
    });

    $headerData = implode("\n", $headerData);


    $opts = array(
        'http' =>
        array(
            'method'  => 'POST',
            'header' => $headerData,
            'content' => $postdata
        )
    );

    $context = stream_context_create($opts);
    return file_get_contents($url, false, $context);
}




function getAllBatches()
{
      $token = file_get_contents('./token.txt');

  
 $a= json_decode(file_postsuper_contents("https://atpstar.com/WS/subject_list_new_v1", getBaseHeaders(),getBasePOSTDATA(['subject_type' => 'addon'])), true);
return $a;
}



function getBatchDetails($batchid)
{
    return json_decode(file_postsuper_contents("https://atpstar.com/WS/course_and_package_information_v1_4_5", getBaseHeaders(),getBasePOSTDATA(['subject_id'=>$batchid])), true);
}


function getStudyPlannerofBatch($batchid){
  // search_title
  // sc_subject_category_id - weeks of the same batch
  
      return json_decode(file_postsuper_contents("https://atpstar.com/WS/study_planner1_4_5", getBaseHeaders(),getBasePOSTDATA(['subject_id'=>$batchid])), true);
}

function getStudyPlannerofBatchByChapterId($batchid,$chid){
  // search_title
  // sc_subject_category_id - weeks of the same batch
  
      return json_decode(file_postsuper_contents("https://atpstar.com/WS/study_planner1_4_5", getBaseHeaders(),getBasePOSTDATA(['subject_id'=>$batchid,'sc_subject_category_id'=>$chid])), true);
}



function getVideoListByChapterId($chapter_id)
{
    return json_decode(file_postsuper_contents("https://atpstar.com/WS/video_list_by_chaper_id", getBaseHeaders(),getBasePOSTDATA(['is_live_class'=>0,'chapter_id'=>$chapter_id])), true);
}


function getVideoData($videoId){
 // replace the domain to cdn.jwplayer.com
  
  // video_faculty_id - a feild
  
      return json_decode(file_postsuper_contents("https://atpstar.com/WS/user_watch_videos_v2", getBaseHeaders(),getBasePOSTDATA(['video_id'=>$videoId,'video_type'=>'Normal'])), true);
}





function getReasonsList($type){
  // $type = 'Video';
  // $type = 'StudyMaterial';
  
      return json_decode(file_getsuper_contents("https://atpstar.com/WS/reason_list", getBaseHeaders(),getBasePOSTDATA(['type'=>$type])), true);
}



function getProfile()
{
    return json_decode(file_postsuper_contents("https://atpstar.com/WS/get_user_profile", getBaseHeaders(),getBasePOSTDATA()), true);
}



function getLive(){
  
    return json_decode(file_postsuper_contents("https://atpstar.com/WS/live_class_v1", getBaseHeaders(),getBasePOSTDATA()), true);
}







?>