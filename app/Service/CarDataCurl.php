<?php

namespace App\Service;

class CarDataCurl
{
    function create_curl($url,$apiKey,$array_data,$type){

        $session = curl_init();
        curl_setopt($session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($session, CURLOPT_TIMEOUT, 30);
        curl_setopt($session, CURLOPT_URL, $url);
        curl_setopt($session, CURLOPT_USERPWD, $apiKey);
        curl_setopt($session, CURLOPT_POST, true);
        curl_setopt($session, CURLOPT_CUSTOMREQUEST, $type);
        curl_setopt($session, CURLOPT_POSTFIELDS, $array_data);
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($session, CURLOPT_SSL_VERIFYHOST, false);
        $response = curl_exec($session);
        curl_close($session);
        if($response!='')return json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $response), true );
        else $response;

    }
}
