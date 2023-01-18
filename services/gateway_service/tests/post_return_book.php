<?php
include_once "./utils.php";

$username = "ksenia";
$reservations = json_decode(curl("http://reservation_system:80/get_reservations?username=$username"));
$reservations = array_filter($reservations, fn($x) => $x->status == "RENTED");
$reservation = reset($reservations);
echo curl_post("http://gateway_service:80/api/v1/reservations/$reservation->reservation_uid/return",
    "
    {\n    \"condition\": \"EXCELLENT\",\n    \"date\": \"2021-10-11\"\n}"
    ,['X-User-Name: ksenia']);

