<?php
    include("./db_connect/postgress_connect.php");
/** @var $connect - переменная из postgress_connect.php с текцщим подключением к бд*/
$id_book = pg_fetch_all(pg_query($connect,
        "select id from books where book_uid='".$_GET['book_uid']."'"))[0]['id'];

$id_library = pg_fetch_all(pg_query($connect,
    "select id from library where library_uid='".$_GET['library_uid']."'"))[0]['id'];

pg_query($connect, "update library_books set available_count=available_count+'".$_GET['count']."' where book_id='$id_book' and library_id='$id_library'");

