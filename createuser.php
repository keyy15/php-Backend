<?php

include 'connection.php';

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (
        isset($_POST['user_firstname']) &&
        isset($_POST['user_lastname']) &&
        isset($_POST['username']) &&
        isset($_POST['email']) &&
        isset($_POST['password_hash'])
    ) {
        $firstname = $_POST['user_firstname'];
        $lastname = $_POST['user_lastname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password_hash'];

        // Hash the password before storing it in the database
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        // Create a prepared statement
        $sql = "INSERT INTO tbl_users (user_firstname, user_lastname, username, email, password_hash) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Bind the parameters
        $stmt->bind_param("sssss", $firstname, $lastname, $username, $email, $password_hash);

        // Check if the statement was prepared successfully
        if ($stmt === false) {
            echo json_encode(["error" => "Prepare failed: (" . $conn->errno . ") " . $conn->error]);
        }

        // Execute the statement
        if ($stmt->execute()) {
            // User inserted successfully
            echo json_encode(["message" => "User created successfully"]);
        } else {
            // Error inserting user
            echo json_encode(["error" => "Create User Failed: " . $stmt->error]);
        }

        // Close the statement
        $stmt->close();
    }
}

?>
