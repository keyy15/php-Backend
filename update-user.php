<?php

include 'connection.php';

header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if user_id is provided
    if (isset($_GET["user_id"])) {
        $user_id = mysqli_real_escape_string($conn, $_GET["user_id"]);

        // Check if other required fields are provided
        if (
            isset($_POST['user_firstname']) &&
            isset($_POST['user_lastname']) &&
            isset($_POST['username']) &&
            isset($_POST['email']) &&
            isset($_POST['password_hash'])
        ) {
            $user_firstname = $_POST['user_firstname'];
            $user_lastname = $_POST['user_lastname'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password_hash = $_POST['password_hash'];

            $sql = "UPDATE tbl_users SET user_firstname = ?, user_lastname = ?, username = ?, email = ?, password_hash = ? WHERE user_id = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param('sssssi', $user_firstname, $user_lastname, $username, $email, $password_hash, $user_id);

                if ($stmt->execute()) {
                    // User updated successfully
                    echo json_encode(["message" => "User updated successfully"]);
                } else {
                    // Error updating user
                    echo json_encode(["error" => "Failed to update user data: " . $stmt->error]);
                }
                $stmt->close();
            } else {
                echo json_encode(["error" => "Failed to prepare SQL statement"]);
            }
        } else {
            echo json_encode(["error" => "Invalid data format"]);
        }
    } else {
        echo json_encode(["error" => "Missing 'user_id' parameter"]);
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>
