<?php
    include("./db_connect/postgress_connect.php");
/** @var $connect - переменная из postgress_connect.php с текцщим подключением к бд*/

    $result = pg_fetch_all(pg_query($connect,
        "select * from library_books 
                left join library on library_books.library_id = library.id 
                left join books on library_books.book_id = books.id
                where library.library_uid='".$_GET['library_uid']."'  
                and books.book_uid = '".$_GET['book_uid']."' ;"
    ));
    echo $result[0]['available_count'];
