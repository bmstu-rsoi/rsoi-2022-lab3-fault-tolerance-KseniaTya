<?php
header('Content-Type: application/json');
include "./utils.php";
/** @var LeoCarmo\CircuitBreaker\CircuitBreaker $circuit */


try{
    $input= json_decode(file_get_contents('php://input'), TRUE );
    $bookUid = $input['bookUid'] ?? null;
    $libraryUid = $input['libraryUid'] ?? null;
    $tillDate = $input['tillDate'] ?? null;
    $username= getallheaders()['X-User-Name'] ?? null;

    validate(compact('bookUid', 'libraryUid', 'tillDate', 'username'), "validate_null", 404);

    $tillDate = urlencode($input['tillDate']);
    $username = urlencode($username);
    $numBooks = curl("http://reservation_system:80/num_books?username=$username");
    $numStars = curl("http://rating_system:80/num_stars?username=$username");
    $available_count  = curl("http://library_system:80/getBook?book_uid=$bookUid&library_uid=$libraryUid");
    // echo "available_count = $available_count ";
    //echo "tillDate = $tillDate numBooks = $numBooks numStars = $numStars";
    if($numBooks < $numStars && $available_count > 0){

        // процесс взятия книги
        $uuid = curl("http://reservation_system:80/add_reserv?username=$username&book_uid=$bookUid&library_uid=$libraryUid&till_date=$tillDate");
        curl("http://library_system:80/count_book?book_uid=$bookUid&library_uid=$libraryUid&count=-1");

        $reservations = json_decode(curl("http://gateway_service:80/api/v1/reservations", ['X-User-Name: '.getallheaders()['X-User-Name']]));
        $reservations = array_filter($reservations, fn($x) => $x->reservationUid == $uuid);
        $reservation = reset($reservations);
        $rating = json_decode(curl("http://gateway_service:80/api/v1/rating", ['X-User-Name: ksenia']));
        $result = (object) array_merge((array) $reservation, (array) $rating);
        $circuit->success();
        http_response_code(200);
        echo json_encode($result);

    }else{
        http_response_code(401);
        echo json_encode(["message" => "numBooks > numStars or available_count == 0"]);
    }

} catch (RuntimeException $e){
    $circuit->failure();
    http_response_code(503);
    echo 'fail!' . PHP_EOL;
}

