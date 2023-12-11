<?php
include 'connection.php';

header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Check if the "user_id" parameter is provided in the URL
    if (isset($_GET["user_id"])) {
        // Sanitize the input to prevent SQL injection (you can use other sanitization methods as well)
        $user_id = mysqli_real_escape_string($conn, $_GET["user_id"]);

        // Perform a SELECT query to retrieve a user by ID
        $sql = "SELECT user_id, user_firstname, user_lastname, username, email, password_hash FROM tbl_users WHERE user_id = $user_id";
        $result = $conn->query($sql);

        if ($result) {
            // Check if any rows were returned
            if ($result->num_rows > 0) {
                // Fetch the result as an associative array
                $user = $result->fetch_assoc();

                // Return the user data as JSON
                echo json_encode($user);
            } else {
                echo json_encode(["message" => "User not found"]);
            }
        } else {
            echo json_encode(["error" => "Query failed: " . $conn->error]);
        }
    } else {
        echo json_encode(["message" => "Missing 'user_id' parameter"]);
    }
} else {
    echo json_encode(["message" => "Invalid request method"]);
}
?>
