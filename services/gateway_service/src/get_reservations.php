<?php
header('Content-Type: application/json; charset=utf-8');
    $username= getallheaders()['X-User-Name'] ?? "Test_User";
    $username = urlencode($username);
    include "./utils.php";

    $reservations = json_decode(curl("http://reservation_system:80/get_reservations?username=$username"));
    $result = array_map(function ($reservation){
        $book = json_decode(curl("http://library_system:80/get_book_by_uid?book_uid=".$reservation->book_uid));
        $library = json_decode(curl("http://library_system:80/get_library_by_uid?library_uid=".$reservation->library_uid));
        return [
            "reservationUid" => $reservation -> reservation_uid,
            "status" => $reservation -> status,
            "startDate" => explode(" ",$reservation -> start_date)[0],
            "tillDate" => explode(" ",$reservation -> till_date)[0],
            "book" => [
                "bookUid" => $book -> book_uid,
                "name" => $book -> name,
                "author" => $book -> author,
                "genre" => $book -> genre
            ],
            "library" => [
                "libraryUid" => $library -> library_uid,
                "name" => $library -> name,
                "address" => $library -> address,
                "city" => $library -> city
            ]
        ];
    }, $reservations);

echo json_encode($result);
