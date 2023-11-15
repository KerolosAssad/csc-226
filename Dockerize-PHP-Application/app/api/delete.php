<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../class/employees.php';
include_once '../class/Artist.php';

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (isset($data->employee)) {
    // Deleting an Employee
    $item = new Employee($db);
    $item->id = $data->employee->id;

    if ($item->deleteEmployee()) {
        echo json_encode("Employee deleted.");
    } else {
        echo json_encode("Employee could not be deleted.");
    }
} elseif (isset($data->artist)) {
    // Deleting an Artist
    $item = new Artist($db);
    $item->counter = $data->artist->counter;

    if ($item->deleteArtist()) {
        echo json_encode("Artist deleted.");
    } else {
        echo json_encode("Artist could not be deleted.");
    }
} else {
    echo json_encode("Invalid data provided. Please specify 'employee' or 'artist' in your JSON input.");
}
?>
