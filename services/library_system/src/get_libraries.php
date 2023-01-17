<?php
    include("./db_connect/postgress_connect.php");
/** @var $connect - переменная из postgress_connect.php с текцщим подключением к бд*/

    $result = pg_fetch_all(pg_query($connect, "select * from library ".($_GET['city'] == "null"? "": " where city='".$_GET['city']."';")));
    $res = array_chunk($result, $_GET['size']);
    if ($res == Array()){
         echo "[]";
    } else{
        echo count($res) < $_GET['page'] ?
            json_encode($res[$_GET['page']-1]):
            json_encode($res[count($res)-1]);
    }


