<?php



// print_r(getBatchDetails(18));

function getBaseHeaders()
{

  $token = json_decode(file_get_contents('./token.txt'),true);

  $tok = $token["token"];
  $user = $token["userid"];

    return [
    'auth-key' => 'appxapi',
    'Authorization' => $tok,
    'Accept-Encoding' => 'gzip',
    'user-id' => $user,
   'client-service' => 'Appx',
    'Accept-Language' => 'en-US,en-IN;q=0.9,en;q=0.8,hi-IN;q=0.7,hi;q=0.6',
    'User-Agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1'
    ];
}





function file_getsuper_contents($url, $headerData)
{
  
$token = json_decode(file_get_contents('./token.txt'),true);

  $tok = $token["token"];
  $user = $token["userid"];
  
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
"auth-key: appxapi",
"Authorization: " . $tok,
"user-id: ".$user,
"client-service: Appx",
"Accept-Language: en-US,en-IN;q=0.9,en;q=0.8,hi-IN;q=0.7,hi;q=0.6",
"User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1"
);

curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);


$resp = curl_exec($curl);
curl_close($curl);

  return $resp;

}





function getAllBatches()
{
  $token = json_decode(file_get_contents('./token.txt'),true);

 $a= json_decode(file_getsuper_contents("https://apnikakshaapi.teachx.in/get/mycourseweb?userid=" . $token['userid'], getBaseHeaders()), true);
return $a["data"];
}



function getBatchDetails($batchid)
{
    $subjects =  json_decode(file_getsuper_contents("https://apnikakshaapi.teachx.in/get/allsubjectfrmlivecourseclass?courseid=$batchid", getBaseHeaders()), true)["data"];

    
  return $subjects;
  
}



function getBatchTopicsofSubjects($batchid,$sub_id)
{
          $subjectsData =  json_decode(file_getsuper_contents("https://apnikakshaapi.teachx.in/get/alltopicfrmlivecourseclass?subjectid=$sub_id&courseid=$batchid", getBaseHeaders()), true)["data"];
  
    return $subjectsData;
}


function getBatchsubTopics($batchid,$sub_id,$topic)
{
          $subTopics =  json_decode(file_getsuper_contents("https://apnikakshaapi.teachx.in/get/allconceptfrmlivecourseclass?subjectid=$sub_id&courseid=$batchid&topicid=$topic", getBaseHeaders()), true)["data"];
  
    return $subTopics;
}



function getsubTopicDetails($batchid,$sub_id,$topic,$sub_topic)
{
          $subTopicsD =  json_decode(file_getsuper_contents("https://apnikakshaapi.teachx.in/get/livecourseclassbycoursesubtopconceptapiv3?start=-1&courseid=$batchid&subjectid=$sub_id&topicid=$topic&conceptid=$sub_topic", getBaseHeaders()), true)["data"];
  
    return $subTopicsD;
}



function getBatchAnouncements($batchid)
{
    return json_decode(file_getsuper_contents("https://apnikakshaapi.teachx.in/get/getposts?start=-1&course_id=$batchid", getBaseHeaders()), true);
}




function getProfile()
{
    $token = json_decode(file_get_contents('./token.txt'),true);

    return json_decode(file_getsuper_contents("https://apnikakshaapi.teachx.in/get/get_user_dt?userid=" . $token['userid'], getBaseHeaders()), true)["data"];
  
}





?>
