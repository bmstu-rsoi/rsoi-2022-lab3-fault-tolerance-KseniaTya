<?php
// error_reporting(0);
require_once __DIR__.'/router.php';

// ##################################################
// ##################################################
// ##################################################

// проверка работоспособности сайта
get('/manage/health', 'src/health.php');
// получить список библиотек
get('/api/v1/libraries', "src/get_libraries.php");
// получить книги из библиотеки
get('/api/v1/libraries/$libraryUid/books', 'src/get_books.php');
// получить список взятых в прокат в прокат книг
get('/api/v1/reservations', 'src/get_reservations.php');
// взять книгу в библиотеке
post('/api/v1/reservations', 'src/post_reservations.php');
// вернуть книгу из библиотеки
post('/api/v1/reservations/$reservationUid/return', 'src/post_return_book.php');
// получить рейтинг пользователя
get('/api/v1/rating', 'src/get_rating.php');

// доступ к тестам с уже введенными входным данным
get('/test', 'tests/index.php');

// -- Example:

/*// Static GET
// In the URL -> http://localhost
// The output -> Index
get('/', 'views/index.php');

// Dynamic GET. Example with 1 variable
// The $id will be available in user.php
get('/user/$id', 'views/user');

// Dynamic GET. Example with 2 variables
// The $name will be available in full_name.php
// The $last_name will be available in full_name.php
// In the browser point to: localhost/user/X/Y
get('/user/$name/$last_name', 'views/full_name.php');

// Dynamic GET. Example with 2 variables with static
// In the URL -> http://localhost/product/shoes/color/blue
// The $type will be available in product.php
// The $color will be available in product.php
get('/product/$type/color/$color', 'product.php');

// A route with a callback
get('/callback', function(){
  echo 'Callback executed';
});

// A route with a callback passing a variable
// To run this route, in the browser type:
// http://localhost/user/A
get('/callback/$name', function($name){
  echo "Callback executed. The name is $name";
});

// A route with a callback passing 2 variables
// To run this route, in the browser type:
// http://localhost/callback/A/B
get('/callback/$name/$last_name', function($name, $last_name){
  echo "Callback executed. The full name is $name $last_name";
});

// ##################################################
// ##################################################
// ##################################################
// any can be used for GETs or POSTs

// For GET or POST
// The 404.php which is inside the views folder will be called
// The 404.php has access to $_GET and $_POST
any('/404','views/404.php');*/
