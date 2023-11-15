<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../class/employees.php';
include_once '../class/Artist.php';

$database = new Database();
$db = $database->getConnection();

if (isset($_GET['table']) && ($_GET['table'] === 'employee' || $_GET['table'] === 'artist')) {
    $table = $_GET['table'];

    if ($table === 'employee') {
        $item = new Employee($db);
        $item->id = isset($_GET['id']) ? $_GET['id'] : die();
        $item->getSingleEmployee();
        if ($item->name != null) {
            $response = array(
                "id" => $item->id,
                "name" => $item->name,
                "email" => $item->email,
                "age" => $item->age,
                "designation" => $item->designation,
                "created" => $item->created
            );
        }
    } elseif ($table === 'artist') {
        $item = new Artist($db);
        $item->counter = isset($_GET['counter']) ? $_GET['counter'] : die();
        $item->getSingleArtist();
        if ($item->name != null) {
            $response = array(
                "counter" => $item->counter,
                "name" => $item->name,
                "nationality" => $item->nationality,
                "age" => $item->age,
                "gender" => $item->gender,
                "DOB" => $item->DOB,
                "alive" => $item->alive,
                "DOD" => $item->DOD,
                "FormalEducation" => $item->FormalEducation,
                "ArtMedium" => $item->ArtMedium
            );
        }
    }

    if (isset($response)) {
        http_response_code(200);
        echo json_encode($response);
    } else {
        http_response_code(404);
        echo json_encode("Record not found.");
    }
} else {
    http_response_code(400);
    echo json_encode("Please specify 'table' (employee or artist) and 'id' or 'counter' in the URL.");
}
?>