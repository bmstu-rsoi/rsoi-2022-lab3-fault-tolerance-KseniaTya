<?php
// error_reporting(0);
require_once __DIR__.'/router.php';

// ##################################################
// ##################################################
// ##################################################

// проверка работоспособности сайта
get('/manage/health', 'src/health.php');
// получить кол-во звезд
get('/num_stars', "src/num_stars.php");
get('/change_rating', 'src/change_rating.php');
