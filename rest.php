<?php
/***
 * RestAPI
 * @param string $url
 * @param null $data
 * @param string $method
 * @param bool $showError
 * @return mixed
 * @author Lev Savranskiy <lev.savranskiy@gmail.com>
 */


function RestAPI($url , $method = 'GET',   $data = null , $showError = false) {


    $curl = curl_init();
    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if($data){
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }

            break;
        case "DELETE":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
            if($data){
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if($data){
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }

            break;
        default:
            if ($data) {
                $url = sprintf("%s?%s", $url, http_build_query($data));
            }

    }




// Optional Authentication:
//    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//    curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Cache-Control: no-cache',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
    );

    $result = curl_exec($curl);


    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);


    if($showError && ($httpCode < 200 || $httpCode > 399)){

        echo '<h1>ERROR: ' . $httpCode  .'</h1>';
        echo '<hr/><pre>';
        echo 'url: ' . $url . '<br/>';
        echo 'method: ' . $method . '<br/>';
        print_r($data);
        echo  'RESPONSE ';
        print_r($result);
        echo  '</pre>';
        return null;
    }else{
        return $result;
    }
}