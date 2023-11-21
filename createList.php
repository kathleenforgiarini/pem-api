<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once 'dbConfig.php';

global $connection;

if (mysqli_connect_error()) {
    echo mysqli_connect_error();
    exit();
} else {
    $eData = file_get_contents("php://input");
    $dData = json_decode($eData, true);
    $name = $dData['name'];
    $description = $dData['description'];
    $list_cat_id = $dData['list_cat_id'];
    $max_price = $dData['max_price'];
    $user_id = $dData['user_id'];
    $result = false;
    
    if ($name != "" and $description != "" and $list_cat_id != "" and $max_price != "" and $user_id != "") {
        
        $createSql = "INSERT INTO list (name, description, list_cat_id, max_price, user_id)
                        VALUES ('$name', '$description', '$list_cat_id', '$max_price', '$user_id')";
        $createRes = mysqli_query($connection, $createSql);
        
        if ($createRes) {
            $result = true;
        } else {
            $result = false;
        }
        
    }
    
    $connection->close();
    echo json_encode($result);
}

?>
