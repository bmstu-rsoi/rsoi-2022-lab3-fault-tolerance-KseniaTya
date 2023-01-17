<?php
    include("./db_connect/postgress_connect.php");
/** @var $connect - переменная из postgress_connect.php с текцщим подключением к бд*/

    $result = pg_fetch_all(pg_query($connect,
        "select * from library_books 
                left join library on library_books.library_id = library.id 
                left join books on library_books.book_id = books.id
                where library.library_uid='".$_GET['libraryUid']."' 
                ".($_GET['showAll']=='true'?"":
                " and library_books.available_count > 0 ").";"
    ));
    $res = array_chunk($result, $_GET['size']);
    if ($res == Array()){
        echo "[]";
    } else{
        echo count($res) < $_GET['page'] ?
            json_encode($res[$_GET['page']-1]):
            json_encode($res[count($res)-1]);
    }