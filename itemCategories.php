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
    $list_categories = $dData['list'];
    $categories = array();
    
    $sql = "SELECT * FROM item_categories WHERE list_categories_id = $list_categories";
    $res = mysqli_query($connection, $sql);
    if (mysqli_num_rows($res) != 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $categories[] = array(
                "id" => $row['id'],
                "name" => $row['name']
            );
        }
    }
    
    $connection->close();
    echo json_encode($categories);
}
?>
