<?php
include("./db_connect/postgress_connect.php");
insert_tables($connect);
function insert_tables($connect){
    // получение списка таблиц из бд
    $result = pg_query($connect, "SELECT n.nspname, c.relname
            FROM pg_class c JOIN pg_namespace n ON n.oid = c.relnamespace
            WHERE c.relkind = 'r' AND n.nspname NOT IN('pg_catalog', 'information_schema');"
    );
    if (pg_fetch_assoc($result) == []) {
       echo "tables isnt exists";
    } else {
        if(pg_fetch_assoc(pg_query($connect, "select id from library")) != []){
            echo "data already exists";
        }else {
            pg_query($connect, "
                INSERT INTO library(id, library_uid, name, city, address)
                VALUES(1, '83575e12-7ce0-48ee-9931-51919ff3c9ee', 'Библиотека имени 7 Непьющих', 'Москва', '2-я Бауманская ул., д.5, стр.1');
            ");
            pg_query($connect, "
                INSERT INTO books(id, book_uid, name, author, genre, condition)
                VALUES(1, 'f7cdc58f-2caf-4b15-9727-f89dcc629b27', 'Краткий курс C++ в 7 томах', 'Бьерн Страуструп', 'Научная фантастика', 'EXCELLENT');
            ");
            pg_query($connect, '
                INSERT INTO library_books(book_id, library_id, available_count)
                VALUES(1, 1, 1);
            ');
            echo "test data added!";
        }
    }
}

