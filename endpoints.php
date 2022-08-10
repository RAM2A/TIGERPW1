<?php

function getBaseHeaders()
{
  $token = file_get_contents("token.txt");


    return [
        'authority' => 'api.penpencil.xyz',
        'authorization' => 'Bearer ' . $token,
        'client-id' => '5eb393ee95fab7468a79d189',
        'client-type' => 'WEB',
        'client-version' => '99',
        'origin' => 'https://study.physicswallah.live',
        'randomid' => 'c560b7b6-9298-4c1c-a62f-77ca92a18376',
        'referer' => 'https://study.physicswallah.live/',
        'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.54 Safari/537.36',
    ];
}






function getAllBatches()
{
    $a= json_decode(file_getsuper_contents("https://api.penpencil.xyz/v3/batches/my-batches?page=1&mode=1", getBaseHeaders()), true)['data'];

      $b= json_decode(file_getsuper_contents("https://api.penpencil.xyz/v3/batches/my-batches?page=2&mode=1", getBaseHeaders()), true)['data'];

return array_merge($a, $b);
}


function getBatchDetails($batchid)
{
    return json_decode(file_getsuper_contents("https://api.penpencil.xyz/v3/batches/$batchid/details", getBaseHeaders()), true)['data'];
}

function getProfile()
{
    return json_decode(file_getsuper_contents("https://api.penpencil.xyz/v1/users/my-profile", getBaseHeaders()), true)['data'];
}


function getTopicDetails($batchid, $subject_id)
{
    $finalD = [];
    $data =  json_decode(file_getsuper_contents("https://api.penpencil.xyz/v2/batches/$batchid/subject/$subject_id/topics?page=1", getBaseHeaders()), true);
    $i = count($data['data']);

    $finalD = array_merge($finalD, $data['data']);

    $p = 2;
    while ($i < $data['paginate']['totalCount']) {
        $data =  json_decode(file_getsuper_contents("https://api.penpencil.xyz/v2/batches/$batchid/subject/$subject_id/topics?page=$p", getBaseHeaders()), true);
        $i = $i + count($data['data']);

        $finalD = array_merge($finalD, $data['data']);
        $p++;
    }
    return $finalD;
}


function getSubTopicDetails($batchid, $subject_id, $tag, $type)
{
    $finalD = [];

    //  types:
    //  videos
    //  notes
    // DppNotes
    // DppVideos

    $data =  json_decode(file_getsuper_contents("https://api.penpencil.xyz/v2/batches/$batchid/subject/$subject_id/contents?page=1&contentType=${urlencode($type)}&tag=".urlencode($tag), getBaseHeaders()), true);
    $i = count($data['data']);

    $finalD = array_merge($finalD, $data['data']);

    $p = 2;
    while ($i < $data['paginate']['totalCount']) {
        $data =  json_decode(file_getsuper_contents("https://api.penpencil.xyz/v2/batches/$batchid/subject/$subject_id/contents?page=$p&contentType=${urlencode($type)}&tag=".urlencode($tag), getBaseHeaders()), true);
        $i = $i + count($data['data']);

        $finalD = array_merge($finalD, $data['data']);
        $p++;
    }
    return $finalD;
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
