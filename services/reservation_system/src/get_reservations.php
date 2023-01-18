<?php
include("./db_connect/postgress_connect.php");
/** @var $connect - переменная из postgress_connect.php с текцщим подключением к бд*/

$username = urldecode($_GET['username']);


$result = pg_fetch_all(pg_query($connect,
    "select * from reservation where username='$username'"
));

echo json_encode($result);