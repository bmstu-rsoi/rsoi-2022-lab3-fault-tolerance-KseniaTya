<?php
// проверка здоровья сервиса
function check_health($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $html = curl_exec($ch);
    curl_close($ch);
    return $html;
}
// get запрос
function curl($url, $head_vars = []){
    $domain = explode(":",
        explode("://", $url)[1]
    )[0];
    if(check_health("http://$domain:80/manage/health") != "200 ОК"){
        throw new RuntimeException();
    }
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $head_vars);
    $html = curl_exec($ch);
    curl_close($ch);
    return $html;
}
// post запрос
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
// проверить массив на наличие null элементов
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
// преобразование json в utf-8 (для того, чтобы убрать кракозябры вместо кириллицы в браузере)
function normJsonStr($str){
    $str = preg_replace_callback('/\\\\u([a-f0-9]{4})/i', fn($m) => chr(hexdec($m[1])-1072+224), $str);
    return iconv('cp1251', 'utf-8', $str);
}

require_once __DIR__ . '/vendor/autoload.php';
use LeoCarmo\CircuitBreaker\CircuitBreaker;
use LeoCarmo\CircuitBreaker\Adapters\RedisAdapter;
// Connect to redis
$redis = new \Redis();

$redis->connect('redis', 6379);

$adapter = new RedisAdapter($redis, 'my-product');

// возьмем название файла как название сервиса CircuitBreaker'а
$stack = debug_backtrace();

// Set redis adapter for CB
$circuit = new CircuitBreaker($adapter, end($stack)['args'][1]);

// Configure settings for CB
$circuit->setSettings([
    'timeWindow' => 30, // Time for an open circuit (seconds)
    'failureRateThreshold' => 2, // Fail rate for open the circuit
    'intervalToHalfOpen' => 30,  // Half open time (seconds)
]);

// Check circuit status for service
if (! $circuit->isAvailable()) {
    die('Circuit is not available!');
}