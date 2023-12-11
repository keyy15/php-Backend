<?php

include 'connection.php';

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Assuming you're sending username and password in the request body
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->username) && isset($data->password)) {
        $username = mysqli_real_escape_string($conn, $data->username);
        $password = $data->password;

        $sql = "SELECT user_id, username, password_hash FROM tbl_users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $db_username, $db_password_hash);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $db_password_hash)) {
                // Password is correct, user is authenticated
                echo json_encode(["message" => "Login successful", "user_id" => $user_id, "username" => $db_username]);
            } else {
                // Password is incorrect
                echo json_encode(["error" => "Invalid password"]);
            }
        } else {
            // No user found with the provided username
            echo json_encode(["error" => "Invalid username"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["error" => "Invalid data format"]);
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}

?>