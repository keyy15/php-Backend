<?php
// api.php

// Set headers to allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Sample data
$items = array(
    array("id" => 1, "name" => "Item 1"),
    array("id" => 2, "name" => "Item 2"),
    array("id" => 3, "name" => "Item 3")
);

// Convert the data to JSON format
$json_response = json_encode($items);

// Return the JSON response
echo $json_response;
?>
