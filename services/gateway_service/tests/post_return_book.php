<?php
include_once "./utils.php";

$username = "ksenia";
$reservation = json_decode(curl("http://reservation_system:80/get_reservations?username=$username"));

echo curl_post("http://gateway_service:80/api/v1/reservations/$reservation->reservation_uid/return",
    "
    {\n    \"condition\": \"EXCELLENT\",\n    \"date\": \"2021-10-11\"\n}"
    ,['X-User-Name: ksenia']);

