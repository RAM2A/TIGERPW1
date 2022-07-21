<?php


function file_post_contents($url, $data,$headerData)
{
    // $postdata = http_build_query($data);

    $postdata = $data;
    
    array_walk($headerData, static function (&$v, $k) {
        $v = $k . ': ' . $v;
    });

    $headerData = implode("\n", $headerData);


    $opts = array(
        'http' =>
        array(
            'method'  => 'POST',
            'header'=> $headerData,
            'content' => $postdata
        )
    );

    $context = stream_context_create($opts);
    return file_get_contents($url, false, $context);
}



function getPolicy($url)
{
    $headerData = [
        'client-version' => '49',
        'Content-Type' => 'application/json',
        'Referer' => 'https://competishun.com/',
        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.54 Safari/537.36',
        'client-id' => '5c8f5d96a248bc40e600bfa4',
        'Client-Type' => 'WEB',
    ];


  $response = file_post_contents("https://api.penpencil.xyz/v1/oauth/token", '{"username":"9413737698","password":"anu123456","client_id":"system-admin","client_secret":"KjPXuAVfC5xbmgreETNMaL7z","grant_type":"password","organizationId":"5c8f5d96a248bc40e600bfa4"}', $headerData);


  $response = json_decode($response,true);
//   print_r($response);


  $access_token = $response["data"]["access_token"];

    $headerData = [
        'authority' => 'api.penpencil.xyz',
        'authorization' => "Bearer " . $access_token,
        'client-id' => '5eb393ee95fab7468a79d189',
        'client-type' => 'WEB',
        'client-version' => '99',
        'content-type' => 'application/json',
        'origin' => 'https://study.physicswallah.live',
        'randomid' => 'c560b7b6-9298-4c1c-a62f-77ca92a18376',
        'referer' => 'https://study.physicswallah.live/',
        'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.54 Safari/537.36',
    ];

    $url = str_replace(".m3u8", ".mpd", $url);


    $topost = array(
        'url' => $url,
    );


    $data =  file_post_contents("https://api.penpencil.xyz/v1/files/get-signed-cookie", json_encode($topost), $headerData);

    $response = json_decode($data,true);
    return $response["data"];
        
}


function getOTPToken($key)
{

    $token = file_get_contents("token.txt");

  
    $headerData = [
        'authority' => 'api.penpencil.xyz',
        'authorization' => "Bearer " . $token,
        'client-id' => '5eb393ee95fab7468a79d189',
        'client-type' => 'WEB',
        'client-version' => '99',
        'content-type' => 'application/json',
        'origin' => 'https://study.physicswallah.live',
        'randomid' => 'c560b7b6-9298-4c1c-a62f-77ca92a18376',
        'referer' => 'https://study.physicswallah.live/',
        'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.54 Safari/537.36',
    ];



      $postdata = $data;
    
    array_walk($headerData, static function (&$v, $k) {
        $v = $k . ': ' . $v;
    });

    $headerData = implode("\n", $headerData);


    $opts = array(
        'http' =>
        array(
            'method'  => 'GET',
            'header'=> $headerData,
        )
    );

    $context = stream_context_create($opts);
        $data =  file_get_contents("https://api.penpencil.xyz/v1/videos/get-otp?key=".$key, false, $context);

  

    $response = json_decode($data,true);
    return $response;
      
}


// if(isset($_GET['url'])){
//     echo getPolicy($_GET["url"]);

// }


?>