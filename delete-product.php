<?php
include 'connection.php';

header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE");
// header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    // Check if the "id" parameter is provided in the URL
    if (isset($_GET["id"])) {
        // Sanitize the input to prevent SQL injection
        $product_id = mysqli_real_escape_string($conn, $_GET["id"]);

        // Perform a DELETE query to remove the product
        $sql = "DELETE FROM tbl_product WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $product_id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Product deleted successfully"]);
        } else {
            echo json_encode(["message" => "Product deletion failed"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["message" => "Missing 'id' parameter"]);
    }
} else {
    echo json_encode(["message" => "Invalid request method"]);
}
