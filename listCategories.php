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
    $categories = array();
    
    $sql = "SELECT * FROM list_categories";
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
