<?php
function curl($url, $head_vars = []){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $head_vars);
    $html = curl_exec($ch);
    curl_close($ch);
    return $html;
}
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

    return $html;
}

function validate($array, $func, $err_code){
    $result = [];
    foreach ($array as $k => $v){
        $result += $func($k, $v, "variable isnt set");
    }
    if($result != []){
        http_response_code($err_code);
        echo json_encode($result);
        exit;
    }
}
function validate_null($k, $v, $message):array{
    return $v != null ? [] : ["$k" => "$message"];
}
function normJsonStr($str){
    $str = preg_replace_callback('/\\\\u([a-f0-9]{4})/i', fn($m) => chr(hexdec($m[1])-1072+224), $str);
    return iconv('cp1251', 'utf-8', $str);
}