<?php
include "./utils.php";
echo curl("http://gateway_service:80/api/v1/rating", ['X-User-Name: ksenia']);