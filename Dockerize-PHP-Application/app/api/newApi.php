<?php

// Allow requests from any origin
header('Access-Control-Allow-Origin: *');

// Allow these methods from any origin
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

// Allow these headers from any origin
header('Access-Control-Allow-Headers: Content-Type');

// Set content type to JSON
header('Content-Type: application/json; charset=UTF-8');

// URL of the REST API endpoint for Fruityvice
$api_url = 'https://www.fruityvice.com/api/fruit/all';

// Initialize cURL session
$ch = curl_init();

// Set cURL options for GET request
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the GET request
$response_get = curl_exec($ch);

if ($response_get === false) {
    echo json_encode(['error' => 'cURL GET request error: ' . curl_error($ch)]);
} else {
    // Parse the JSON response
    $data_get = json_decode($response_get, true);

    // Handle the parsed data
    if ($data_get !== null) {
        // Output the JSON response
        echo json_encode($data_get);
    } else {
        echo json_encode(['error' => 'Error parsing JSON response.']);
    }
}

// Close cURL session
curl_close($ch);

?>


