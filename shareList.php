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
    $list_id = $dData['list'];
    $items = array();
    
    $sql = "SELECT user_id FROM user_list WHERE list_id = $list_id";
    $res = mysqli_query($connection, $sql);
    if (mysqli_num_rows($res) != 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $userId = $row['user_id'];
            $sqlUser = "SELECT id, name, photo FROM user WHERE id = $userId";
            $resUser = mysqli_query($connection, $sqlUser);
            while ($rowUser = mysqli_fetch_assoc($resUser)) {
                $items[] = array('id'=> $rowUser['id'], 'name'=> $rowUser['name'], 'photo' => base64_encode($rowUser["photo"]));
            }
        }
    }
    
    $connection->close();
    echo json_encode($items);
    
}
?>
