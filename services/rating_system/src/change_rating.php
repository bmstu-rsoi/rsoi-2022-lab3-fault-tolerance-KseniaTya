<?php
include("./db_connect/postgress_connect.php");
/** @var $connect - переменная из postgress_connect.php с текцщим подключением к бд */

$username = urldecode($_GET['username']);
$stars = $_GET['stars'];
$user = pg_fetch_all(pg_query($connect, "select * from rating where username = '$username'"))[0];
$stars = $user['stars'] + $stars;
if($stars < 1){
    $stars = 1;
}
if($stars > 100){
    $stars = 100;
}

pg_query($connect, "update rating set stars='$stars' where username='$username' ");