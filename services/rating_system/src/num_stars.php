<?php

include("./db_connect/postgress_connect.php");
/** @var $connect - переменная из postgress_connect.php с текцщим подключением к бд*/

$username = urldecode($_GET['username']);


$result = pg_fetch_all(pg_query($connect,
    "select * from rating where username='$username' "
));

if (count($result) == 0){
    pg_query($connect, "
                INSERT INTO rating(username , stars)
                VALUES('$username', 1);
            ");
    echo "1";
} else{
    echo $result[0]['stars'];
}
