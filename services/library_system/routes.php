<?php
// error_reporting(0);
require_once __DIR__.'/router.php';

// ##################################################
// ##################################################
// ##################################################

// проверка работоспособности сайта
get('/manage/health', 'src/health.php');
// получить список библиотек
get('/get_libraries', "src/get_libraries.php");
get('/get_books', "src/get_books.php");
get('/count_book', "src/count_book.php");
get('/getBook', "src/getBook.php");
get('/get_book_by_uid', 'src/get_book_by_uid.php');
get('/change_condition_book', 'src/change_condition_book.php');
get('/get_library_by_uid', 'src/get_library_by_uid.php');
