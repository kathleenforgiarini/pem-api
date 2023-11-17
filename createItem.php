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
    $quantity = $dData['quantity'];
    $price = $dData['price'];
    $list_id = $dData['list_id'];
    $category = $dData['item_cat_id'];
    $done = 0;
    $result = false;
    
    if ($name != "" and $quantity != "" and $price != "" and $category != "" and $done != "") {
        
        $createSql = "INSERT INTO item (name, quantity, price, list_id, item_cat_id, done)
                        VALUES ('$name', $quantity, $price, $list_id, $category, $done)";
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
