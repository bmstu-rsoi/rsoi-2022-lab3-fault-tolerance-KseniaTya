<?php declare(strict_types=1);
/** @var LeoCarmo\CircuitBreaker\CircuitBreaker $circuit */
include "./utils.php";

try {
    header('Content-Type: application/json; charset=utf-8');
    $username= getallheaders()['X-User-Name'] ?? "Test_User";
    $username = urlencode($username);
    $numStars = curl("http://rating_system:80/num_stars?username=$username");
    $result = ["stars" => (int)$numStars];
    $circuit->success();

echo json_encode($result);
} catch (RuntimeException $e){
    $circuit->failure();
    http_response_code(503);
    echo "{}";
}
