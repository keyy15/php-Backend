<?php
include 'connection.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Perform a SELECT query to retrieve product data
    $sql = "SELECT * FROM tbl_product ORDER BY id DESC"; // Fixed the SQL syntax error
    $result = $conn->query($sql);

    if ($result) {
        $products = array();
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        // Return the data as a JSON array
        echo json_encode($products); // Use echo to send the JSON response
    } else {
        echo json_encode(["message" => "Failed to retrieve products"]);
    }
} else {
    echo json_encode(["message" => "Invalid request method"]);
}
