<?php
header('Content-Type: application/json; charset=utf-8');

$page = $_GET['page'] ?? 1;
$size = $_GET['size'] ?? 50;
if($size < 0 || $page < 0){
    echo "incorrect values!";
}
else {
    $_GET['showAll'] = $_GET['showAll'] ?? "false";
    include "./utils.php";

    $array = json_decode(curl("http://library_system:80/get_books&page=$page&size=$size&libraryUid=$libraryUid".($_GET['showAll']=="true" ?"&showAll=true" :"&showAll=false")));
    $items = array_map(fn($item) => [
        "bookUid" => $item -> book_uid,
        "name"=> $item -> name,
        "author"=> $item -> author,
        "genre"=> $item -> genre,
        "condition" => $item -> condition,
        "availableCount" => $item -> available_count
    ], $array);
    $result = [
        "page" => $page,
        "pageSize" => count($items) < $size ? count($items):$size,
        "totalElements" => count($items),
        "items" => $items
    ];
    echo normJsonStr(json_encode($result,JSON_PRETTY_PRINT));

}