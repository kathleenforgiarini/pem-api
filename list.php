<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: Get, Post");
header("Access-Control-Allow-Headers: Content-Type");

require_once 'dbConfig.php';

global $connection;

if (mysqli_connect_error()) {
    echo mysqli_connect_error();
    exit();
} else {
    $eData = file_get_contents("php://input");
    $dData = json_decode($eData, true);
    $userId = $dData['userId'];
    $list = array();
    
    $sql = "SELECT * FROM list WHERE user_id = $userId";
    $res = mysqli_query($connection, $sql);
    if (mysqli_num_rows($res) != 0) {
        while ($row = mysqli_fetch_array($res)) {
            $list[] = array(
                "id" => $row['id'],
                "name" => $row['name'],
                "description" => $row['description'],
                "max_price" => $row['max_price'],
                "user_id" => $row['user_id'],
                "list_cat_id" => $row['list_cat_id']
            );
        }
    }
    
    $connection->close();
    echo json_encode($list);
}
?>
