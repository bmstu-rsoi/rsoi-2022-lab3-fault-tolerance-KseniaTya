<?php
include "./utils.php";
echo curl("http://gateway_service:80/api/v1/libraries?city=Москва&page=1&size=10");