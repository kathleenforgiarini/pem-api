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
    $list_id = $dData['list_id'];
    $item = array();
    
    $sql = "SELECT * FROM item WHERE list_id = $list_id";
    $res = mysqli_query($connection, $sql);
    if (mysqli_num_rows($res) != 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $item[] = array(
                "id" => $row['id'],
                "name" => $row['name'],
                "quantity" => $row['quantity'],
                "price" => $row['price'],
                "list_id" => $row['list_id'],
                "item_cat_id" => $row['item_cat_id'],
                "done" => $row['done']
            );
        }
    }
    
    $connection->close();
    echo json_encode($item);
}
?>
