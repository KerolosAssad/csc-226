<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../class/employees.php';
include_once '../class/Artist.php';

$database = new Database();
$db = $database->getConnection();
$data = json_decode(file_get_contents("php://input"));

if (isset($data->employee)) {
    // Update an Employee
    $item = new Employee($db);
    $item->id = $data->employee->id;
    $item->name = $data->employee->name;
    $item->email = $data->employee->email;
    $item->age = $data->employee->age;
    $item->designation = $data->employee->designation;
    $item->created = date('Y-m-d H:i:s');

    if ($item->updateEmployee()) {
        echo json_encode("Employee data updated.");
    } else {
        echo json_encode("Data could not be updated");
    }
} elseif (isset($data->artist)) {
    // Update an Artist
    $item = new Artist($db);
    if (isset($data->artist->counter)) {
        $item->counter = $data->artist->counter;
        $item->name = $data->artist->name;
        $item->nationality = $data->artist->nationality;
        $item->age = $data->artist->age;
        $item->gender = $data->artist->gender;
        $item->DOB = $data->artist->DOB;
        $item->alive = $data->artist->alive;
        $item->DOD = $data->artist->DOD;
        $item->FormalEducation = $data->artist->FormalEducation;
        $item->ArtMedium = $data->artist->ArtMedium;

        if ($item->updateArtist()) {
            echo json_encode("Artist data updated.");
        } else {
            echo json_encode("Data could not be updated");
        }
    } else {
        echo json_encode("Counter not provided for artist.");
    }
} else {
    echo json_encode("Invalid data provided. Please specify 'employee' or 'artist' in your JSON input.");
}
?>

