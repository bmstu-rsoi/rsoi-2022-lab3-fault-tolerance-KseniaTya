<?php

function curl_post($url, $post_vars = "", $head_vars = []){
    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_vars);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($post_vars)
    ]);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $head_vars);
    $html = curl_exec($curl);
    curl_close($curl);
    return $html;
}

    sleep(10);

    $args = json_decode(urldecode($argv[1]));
    $reservationUid = $args->reservationUid;
    curl_post("http://gateway_service:80/api/v1/reservations/$reservationUid/return",
        json_encode(["condition" => $args->condition, "date" => $args->date])
        ,['X-User-Name: '.$args->username]);

