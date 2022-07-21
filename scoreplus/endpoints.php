<?php


function getBaseHeaders()
{
    $token = file_get_contents('./token.txt');

    return [
    'authority' => 'app-api.scoreplus.live',
    'authorization' => $token,
    'content-type' => 'application/json',
    'origin' => 'https://class.scoreplus.live',
    'referer' => 'https://class.scoreplus.live/',
    'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36',	
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
 $a= json_decode(file_getsuper_contents("https://app-api.scoreplus.live/prod/mycourse", getBaseHeaders()), true);
return $a;
}



function getBatchDetails($batchid)
{
    return json_decode(file_getsuper_contents("https://app-api.scoreplus.live/prod/mycourse/lectures?course_id=$batchid", getBaseHeaders()), true);
}




function getBatchAnouncements($batchid)
{
    return json_decode(file_getsuper_contents("https://app-api.scoreplus.live/prod/mycourse/announcements?course_id=$batchid", getBaseHeaders()), true);
}




function getProfile()
{
    return json_decode(file_getsuper_contents("https://app-api.scoreplus.live/prod/user", getBaseHeaders()), true);
}




?>
