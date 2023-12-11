<?php

include 'connection.php';

header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    if (isset($_GET['user_id'])) {
        $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);

        $sql = "DELETE FROM tbl_users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $user_id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "User deleted successfully"]);
        } else {
            echo json_encode(["message" => "User deletion failed"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["message" => "Missing 'user_id' parameter"]);
    }
} else {
    echo json_encode(["message" => "Invalid request method"]);
}
?>
