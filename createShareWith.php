<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: Get, Post");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
require_once 'dbConfig.php';

global $connection;

if (mysqli_connect_error()) {
    echo mysqli_connect_error();
    exit();
} else {
    $eData = file_get_contents("php://input");
    $dData = json_decode($eData, true);
    $list_id = $dData['listId'];
    $email = $dData['email'];
    $result = "";
    
    if ($list_id !== "" && $email !== ""){
        $sql = "SELECT id FROM user WHERE email = '$email'";
        $res = mysqli_query($connection, $sql);
        if (mysqli_num_rows($res) != 0) {
            $row = mysqli_fetch_array($res);
            $userId = $row['id'];
            $checkSql = "SELECT * FROM user_list WHERE user_id = $userId AND list_id = $list_id";
            $checkRes = mysqli_query($connection, $checkSql);
            
            if (mysqli_num_rows($checkRes) != 0) {
                $result = "User already have access to this list!";
            } else {
                $insertSql = "INSERT INTO user_list (user_id, list_id) VALUES ($userId, $list_id)";
                $insertRes = mysqli_query($connection, $insertSql);
                
                if ($insertRes) {
                    $result = "User now have access to your list!";
                } else {
                    $result = "Error sharing list with user: " . mysqli_error($connection);
                }
            }
        } else {
            $result = "Invalid email!";
        }
    }
    
    
    $connection->close();
    echo json_encode($result);
    
}
?>
