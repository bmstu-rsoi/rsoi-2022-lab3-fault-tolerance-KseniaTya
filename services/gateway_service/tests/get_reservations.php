<?php
include "./utils.php";
echo curl("http://gateway_service:80/api/v1/reservations", ['X-User-Name: ksenia']);