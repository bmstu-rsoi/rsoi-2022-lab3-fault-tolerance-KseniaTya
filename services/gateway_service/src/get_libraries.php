<?php
header('Content-Type: application/json; charset=utf-8');
    $page = $_GET['page'] ?? 1;
    $size = $_GET['size'] ?? 50;
    $city = $_GET['city'] ?? "null";
    if($size < 0 || $page < 0){
        echo "incorrect values!";
    }
    else {
        include "./utils.php";
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
        echo normJsonStr($json);

    }
