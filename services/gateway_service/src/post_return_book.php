<?php declare(strict_types=1);
/** @var LeoCarmo\CircuitBreaker\CircuitBreaker $circuit */
include "./utils.php";

header('Content-Type: application/json; charset=utf-8');
$input = json_decode( file_get_contents('php://input'), TRUE );

$condition = $input['condition'] ?? null;
$date = $input['date'] ?? null;
$username= getallheaders()['X-User-Name'] ?? null;

// сдать книгу и получить данные о книге из резервации
validate(compact('condition', 'date', 'username'), "validate_null", 400);
try{
    services_is_running(["reservation_system", "library_system", "rating_system"]);

    $username = urlencode($username);
    $date = urlencode($input['date']);

    // получаем старые данные резервации
    $old_reservations = json_decode(curl("http://gateway_service:80/api/v1/reservations", ['X-User-Name: '.getallheaders()['X-User-Name']]));
    $old_reservations = array_filter($old_reservations, fn($x) => $x->reservationUid == $reservationUid);
    $old_reservation = $old_reservations[array_key_first($old_reservations)]??null;
    if(!isset($old_reservation) || $old_reservation->status != "RENTED"){
        http_response_code(204);
    }else{

        $reservationData = curl("http://reservation_system:80/return_book?username=$username&reservationUid=$reservationUid&date=$date");

        if($reservationData == "[]"){
            http_response_code(404);
        }
        else{
            $arr = json_decode($reservationData);
            // увеличить счетчик доступных книг
            //$numBooks = curl("http://library_system:80/return_book?username=$username&reservationUid=$reservationUid");
            curl("http://library_system:80/count_book?book_uid=$arr->book_uid&library_uid=$arr->library_uid&count=1");

            $book = json_decode(curl("http://library_system:80/get_book_by_uid?book_uid=$arr->book_uid"));
            $stars = 0;
            if($arr->status == 'EXPIRED'){
                $stars -= 10;
            }
            if($book->condition != $condition){
                $stars -= 10;
                curl("http://library_system:80/change_condition_book?book_uid=$arr->book_uid&condition=$condition");
            }
            if($stars == 0){
                $stars+= 1;
            }
            curl("http://rating_system:80/change_rating?username=$username&stars=$stars");

            $circuit->success();
            http_response_code(204);
            echo ("
                \"condition\": \"$condition\",
                \"date\": \"$arr->till_date\"
            ");
        }
    }
} catch (RuntimeException $e){
    $circuit->failure();

    $json = urlencode(json_encode([
        "username" => getallheaders()['X-User-Name'],
        "date" => $input['date'],
        "condition" => $input['condition'],
        "reservationUid" => $reservationUid
    ]));
    http_response_code(204);
    echo "{}";
    exec("php /var/www/html/src/reconnect/reconnect_post_return_book.php $json  > /dev/null &");
}
