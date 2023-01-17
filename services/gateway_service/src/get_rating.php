<?php
header('Content-Type: application/json; charset=utf-8');
include "./utils.php";
$username= getallheaders()['X-User-Name'] ?? "Test_User";
$username = urlencode($username);
$numStars = curl("http://rating_system:80/num_stars?username=$username");
$result = ["stars" => (int)$numStars];

echo json_encode($result);