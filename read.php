<?php
include 'connection.php';

header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Check if the "id" parameter is provided in the UR
    if (isset($_GET["id"])) {
        // Sanitize the input to prevent SQL injection (you can use other sanitization methods as well)
        $product_id = mysqli_real_escape_string($conn, $_GET["id"]);

        // Perform a SELECT query to retrieve a product by ID
        $sql = "SELECT id, pro_name, pro_qty, pro_des, pro_category, pro_brand, pro_color, pro_price, pro_dis, pro_img, pro_multiimg, pro_public FROM tbl_product WHERE id = $product_id";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $product = $result->fetch_assoc();
            // Split pro_multiimg into an array using explode
            $product["pro_multiimg"] = explode(",", $product["pro_multiimg"]);

            echo json_encode($product);
        } else {
            echo json_encode(["message" => "Product not found"]);
        }
    } else {
        echo json_encode(["message" => "Missing 'id' parameter"]);
    }
} else {
    echo json_encode(["message" => "Invalid request method"]);
}
