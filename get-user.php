<?php

include 'connection.php';

header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER["REQUEST_METHOD"] === "GET"){
    $sql = "SELECT * FROM tbl_users ORDER BY user_id DESC";
    $result = $conn->query($sql);
    
    if($result){
        $users = array();
        while($row = $result->fetch_assoc()){
            $users[] = $row;
        }

        echo json_encode($users);

    }else{
        echo json_encode(["message" => 'Failed to retrieve user']);
    }
}else{
    echo json_encode(["message" => "Invalid request method"]);
}


?>