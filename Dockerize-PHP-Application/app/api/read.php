<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../class/employees.php';
include_once '../class/Artist.php'; // Include the Artist class

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (isset($data->table) && ($data->table === 'employee' || $data->table === 'artist')) {
    if ($data->table === 'employee') {
        $items = new Employee($db);
        $stmt = $items->getEmployees();
    } elseif ($data->table === 'artist') {
        $items = new Artist($db);
        $stmt = $items->getArtists();
    }

    $itemCount = $stmt->rowCount();

    if ($itemCount > 0) {
        $response = array();
        $response["body"] = array();
        $response["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            if ($data->table === 'employee') {
                $item = array(
                    "id" => $id,
                    "name" => $name,
                    "email" => $email,
                    "age" => $age,
                    "designation" => $designation,
                    "created" => $created
                );
            } elseif ($data->table === 'artist') {
                $item = array(
                    "counter" => $counter,
                    "name" => $name,
                    "nationality" => $nationality,
                    "age" => $age,
                    "gender" => $gender,
                    "DOB" => $DOB,
                    "alive" => $alive,
                    "DOD" => $DOD,
                    "FormalEducation" => $FormalEducation,
                    "ArtMedium" => $ArtMedium
                );
            }

            array_push($response["body"], $item);
        }

        echo json_encode($response);
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "No records found."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Invalid table name. Please specify 'employee' or 'artist' in your JSON input."));
}
?>
