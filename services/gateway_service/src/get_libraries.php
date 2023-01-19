<?php declare(strict_types=1);
/** @var LeoCarmo\CircuitBreaker\CircuitBreaker $circuit */
include "./utils.php";

try{
header('Content-Type: application/json; charset=utf-8');
    $page = $_GET['page'] ?? 1;
    $size = $_GET['size'] ?? 50;
    $city = $_GET['city'] ?? "null";
    if($size < 0 || $page < 0){
        echo "incorrect values!";
    }
    else {
        $array = json_decode(curl("http://library_system:80/get_libraries?city=$city&page=$page&size=$size"));
        $items = array_map(fn($item) => [
              "libraryUid"=> $item -> library_uid,
              "name"=> $item -> name,
              "address"=> $item -> address,
              "city"=> $item -> city
            ], $array);
        $result = [
            "page" => $page,
            "pageSize" => count($items) < $size ? count($items):$size,
            "totalElements" => count($items),
            "items" => $items
            ];
        $json = json_encode($result, JSON_PRETTY_PRINT);
        $circuit->success();
        echo normJsonStr($json);

    }
} catch (RuntimeException $e){
    $circuit->failure();
    http_response_code(503);
    echo "{}";
}
