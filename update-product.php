<?php
include 'connection.php';

header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Methods: PUT");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['pro_name']) && isset($_POST['pro_qty']) && isset($_POST['pro_des']) && isset($_POST['pro_category']) && isset($_POST['pro_price']) && isset($_POST['pro_dis']) && isset($_POST['pro_public']) && isset($_POST['id'])) {
        // Sanitize the input to prevent SQL injection
        $product_id = mysqli_real_escape_string($conn, $_GET["id"]);

        $pro_name = $_POST['pro_name'];
        $pro_qty = (int) $_POST['pro_qty']; // Cast to integer
        $pro_des = $_POST['pro_des'];
        $pro_category = $_POST['pro_category'];
        $pro_brand = $_POST['pro_brand'];
        $pro_color = $_POST['pro_color'];
        $pro_price = (float) $_POST['pro_price']; // Cast to double
        $pro_dis = $_POST['pro_dis'];
        $pro_public = $_POST['pro_public'];

        // Define the directory where you want to store the uploaded images
        $uploadDirectory = 'uploaded/'; // Update this path

        // Array to store the filenames of successfully uploaded images
        $uploadedImageNames = array();

        // Upload the single image (pro_img)
        $pro_img = '';
        if (isset($_FILES['pro_img']['name']) && $_FILES['pro_img']['error'] === UPLOAD_ERR_OK) {
            $pro_imgName = $_FILES['pro_img']['name'];
            $pro_imgTempName = $_FILES['pro_img']['tmp_name'];
            $pro_imgTargetPath = $uploadDirectory . $pro_imgName;

            if (move_uploaded_file($pro_imgTempName, $pro_imgTargetPath)) {
                $pro_img = $pro_imgName;
            } else {
                echo json_encode(["error" => "Failed to move uploaded image"]);
                exit;
            }
        } elseif ($_FILES['pro_img']['error'] !== UPLOAD_ERR_NO_FILE) {
            echo json_encode(["error" => "File upload error: " . $_FILES['pro_img']['error']]);
            exit;
        }

        // Add this inside the loop where you handle multiple image uploads
        foreach ($_FILES['pro_multiimg']['name'] as $key => $imageName) {
            $tempImageName = $_FILES['pro_multiimg']['tmp_name'][$key];
            $error = $_FILES['pro_multiimg']['error'][$key];

            if ($error === UPLOAD_ERR_OK) {
                // Generate a random filename to avoid overwriting
                $uniqueFileName = rand(1, 100000) . '_' . $imageName;

                // Move the uploaded image to the desired directory
                $targetPath = $uploadDirectory . $uniqueFileName;

                if (move_uploaded_file($tempImageName, $targetPath)) {
                    $uploadedImageNames[] = $uniqueFileName;
                } else {
                    error_log("Failed to move uploaded image: $targetPath");
                    echo json_encode(["error" => "Failed to move uploaded image"]);
                }
            } else {
                echo json_encode(["error" => "File upload error: " . $error]);
                exit;
            }
        }
        // Check if any images were successfully uploaded
        if (!empty($uploadedImageNames)) {
            // Create a comma-separated string of image filenames for pro_multiimg
            $pro_multiimg = join(",", $uploadedImageNames);

            // Prepare SQL statement for updating data
            $sql = "UPDATE tbl_product SET pro_name = ?, pro_qty = ?, pro_des = ?, pro_category = ?, pro_brand = ?, pro_color = ?, pro_price = ?, pro_dis = ?, pro_img = ?, pro_multiimg = ?, pro_public = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                // Bind the parameters for the query
                $stmt->bind_param("sissssdssssi", $pro_name, $pro_qty, $pro_des, $pro_category, $pro_brand, $pro_color, $pro_price, $pro_dis, $pro_img, $pro_multiimg, $pro_public, $product_id);

                if ($stmt->execute()) {
                    // Product updated successfully
                    echo json_encode(["message" => "Product updated successfully"]);
                } else {
                    // Error updating product
                    echo json_encode(["error" => "Failed to update product data: " . $stmt->error]);
                }
                // Close the prepared statement
                $stmt->close();
            } else {
                echo json_encode(["error" => "Failed to prepare SQL statement"]);
            }
        } else {
            echo json_encode(["error" => "No images were uploaded"]);
        }
    } else {
        echo json_encode(["error" => "Invalid data format ah bek"]);
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
