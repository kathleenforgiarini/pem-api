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
    $itemId = $dData['itemId'];
    $result = false;
    
    if ($itemId != "") {

        $checkSql = "SELECT * FROM item WHERE id = $itemId";
        $checkRes = mysqli_query($connection, $checkSql);
        
        if (mysqli_num_rows($checkRes) != 0) {

            $deleteSql = "DELETE FROM item WHERE id = $itemId";
            $deleteRes = mysqli_query($connection, $deleteSql);
            
            if ($deleteRes) {
                $result = true;
            } else {
                $result = false;
            }
        }
    }
    
    $connection->close();
    echo json_encode($result);
}

?>