<?php



// print_r(getBatchDetails(18));

function getBaseHeaders()
{
$token = json_decode(file_get_contents('./token.txt'),true);

  $tok = $token["token"];
  $user = $token["userid"];
  

    return [
    'Auth-Key' => 'appxapi',
    'authorization' => $tok,
    'Client-Service'=> 'Appx',
      'Language'=> 'en',
   'Accept-Encoding'=> 'gzip, deflate',
    'User-ID' => $user,
    'user-agent' => 'okhttp/4.9.1',
    'User_app_category'=> '1'
    ];
}





function file_getsuper_contents($url, $headerData)
{
    // $postdata = http_build_query($data);


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





function getAllBatches()
{
  $token = json_decode(file_get_contents('./token.txt'),true);

 $a= json_decode(file_getsuper_contents("https://rankersapi.appx.co.in/get/mycourse?userid=" . $token['userid'], getBaseHeaders()), true);
return $a["data"];
}



function getBatchDetails($batchid)
{
    $subjects =  json_decode(file_getsuper_contents("https://rankersapi.appx.co.in/get/allsubjectfrmlivecourseclass?courseid=$batchid", getBaseHeaders()), true)["data"];

    
  return $subjects;
  
}



function getBatchTopicsofSubjects($batchid,$sub_id)
{
          $subjectsData =  json_decode(file_getsuper_contents("https://rankersapi.appx.co.in/get/alltopicfrmlivecourseclass?subjectid=$sub_id&courseid=$batchid", getBaseHeaders()), true)["data"];
  
    return $subjectsData;
}


function getBatchsubTopics($batchid,$sub_id,$topic)
{
          $subTopics =  json_decode(file_getsuper_contents("https://rankersapi.appx.co.in/get/allconceptfrmlivecourseclass?subjectid=$sub_id&courseid=$batchid&topicid=$topic", getBaseHeaders()), true)["data"];
  
    return $subTopics;
}



function getsubTopicDetails($batchid,$sub_id,$topic,$sub_topic)
{
          $subTopicsD =  json_decode(file_getsuper_contents("https://rankersapi.appx.co.in/get/livecourseclassbycoursesubtopconceptapiv3?start=-1&courseid=$batchid&subjectid=$sub_id&topicid=$topic&conceptid=$sub_topic", getBaseHeaders()), true)["data"];
  
    return $subTopicsD;
}



function getBatchAnouncements($batchid)
{
    return json_decode(file_getsuper_contents("https://rankersapi.appx.co.in/get/getposts?start=-1&course_id=$batchid", getBaseHeaders()), true);
}




function getProfile()
{
    $token = json_decode(file_get_contents('./token.txt'),true);

    return json_decode(file_getsuper_contents("https://rankersapi.appx.co.in/get/get_user_dt?userid=" . $token['userid'], getBaseHeaders()), true)["data"];
  
}





?>
