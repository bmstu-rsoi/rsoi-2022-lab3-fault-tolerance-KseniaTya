<?php
include("./db_connect/postgress_connect.php");
/** @var $connect - переменная из postgress_connect.php с текцщим подключением к бд */
$book_uid = $_GET['book_uid'];
$condition = $_GET['condition'];
pg_query($connect, "update books set condition='$condition' where book_uid='$book_uid' ");
