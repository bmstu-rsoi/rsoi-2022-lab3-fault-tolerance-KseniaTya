<?php

include("./db_connect/postgress_connect.php");
/** @var $connect - переменная из postgress_connect.php с текцщим подключением к бд */
$status = $_GET['status'];
$reservationUid = $_GET['reservationUid'];
pg_query($connect, "update reservation set status='".$status."' where reservation_uid = $reservationUid");
