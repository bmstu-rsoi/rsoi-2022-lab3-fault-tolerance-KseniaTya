<?php
include "./utils.php";
//echo curl_post("http://gateway_service:80/api/v1/reservations",
//    "bookUid=f7cdc58f-2caf-4b15-9727-f89dcc629b27&libraryUid=83575e12-7ce0-48ee-9931-51919ff3c9ee&tillDate=27-01-2023 23:12:34"
//    ,['X-User-Name: ksenia']);
echo curl_post("http://gateway_service:80/api/v1/reservations",
    "
    {\n    \"bookUid\": \"f7cdc58f-2caf-4b15-9727-f89dcc629b27\",\n    \"libraryUid\": \"83575e12-7ce0-48ee-9931-51919ff3c9ee\",\n    \"tillDate\": \"2021-10-11\"\n}"
    ,['X-User-Name: ksenia']);