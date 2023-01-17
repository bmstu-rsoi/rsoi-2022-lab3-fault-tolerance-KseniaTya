<?php

include("./db_connect/postgress_connect.php");
/** @var $connect - переменная из postgress_connect.php с текцщим подключением к бд */
$result = pg_fetch_all(pg_query($connect,
    "select * from books 
                where book_uid = '" . $_GET['book_uid'] . "' ;"
));
echo json_encode($result[0]);