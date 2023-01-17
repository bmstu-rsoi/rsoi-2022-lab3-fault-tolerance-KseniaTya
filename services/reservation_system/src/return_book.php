<?php
include("./db_connect/postgress_connect.php");
/** @var $connect - переменная из postgress_connect.php с текцщим подключением к бд*/

$username = urldecode($_GET['username']);

$condition = " username='$username' and reservation_uid = '".$_GET['reservationUid']."'";
$res = pg_fetch_all(pg_query($connect,
    "select * from reservation where".$condition." and status = 'RENTED'"
));
if($res == []){
    echo "[]";
}
else{
    $status = strtotime(urldecode($_GET['date'])) > strtotime($res[0]["till_date"]) ? "EXPIRED" : "RETURNED";

    pg_query($connect, "update reservation set status='".$status."' where".$condition);

    $result = pg_fetch_all(pg_query($connect,
        "select * from reservation where".$condition
    ));

    echo json_encode($result[0]);
}
