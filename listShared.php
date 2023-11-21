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
    $category = $dData['selectedCategory'];
    $name = $dData['name'];
    $list = array();
    
    $sqlListShared = "SELECT list_id FROM user_list WHERE user_id = $userId";
    $resListShared = mysqli_query($connection, $sqlListShared);
    if (mysqli_num_rows($resListShared) != 0) {
        while ($rowListShared = mysqli_fetch_array($resListShared)) {
            $userList = $rowListShared['list_id'];
            
            if ($category == "" && $name == ""){
                $sql = "SELECT * FROM list WHERE id = $userList";
                $res = mysqli_query($connection, $sql);
                if (mysqli_num_rows($res) != 0) {
                    while ($row = mysqli_fetch_array($res)) {
                        $list[] = array(
                            "id" => $row['id'],
                            "name" => $row['name'],
                            "description" => $row['description'],
                            "max_price" => $row['max_price'],
                            "total_price" => $row['total_price'],
                            "user_id" => $row['user_id'],
                            "list_cat_id" => $row['list_cat_id']
                        );
                    }
                }
            } else if ($category !== "" && $name == "") {
                $sql = "SELECT * FROM list WHERE id = $userList AND list_cat_id = $category";
                $res = mysqli_query($connection, $sql);
                if (mysqli_num_rows($res) != 0) {
                    while ($row = mysqli_fetch_array($res)) {
                        $list[] = array(
                            "id" => $row['id'],
                            "name" => $row['name'],
                            "description" => $row['description'],
                            "max_price" => $row['max_price'],
                            "total_price" => $row['total_price'],
                            "user_id" => $row['user_id'],
                            "list_cat_id" => $row['list_cat_id']
                        );
                    }
                }
            }
            
            else if ($category == "" && $name !== "") {
                $sql = "SELECT * FROM list WHERE id = $userList AND name LIKE '%$name%'";
                $res = mysqli_query($connection, $sql);
                if (mysqli_num_rows($res) != 0) {
                    while ($row = mysqli_fetch_array($res)) {
                        $list[] = array(
                            "id" => $row['id'],
                            "name" => $row['name'],
                            "description" => $row['description'],
                            "max_price" => $row['max_price'],
                            "total_price" => $row['total_price'],
                            "user_id" => $row['user_id'],
                            "list_cat_id" => $row['list_cat_id']
                        );
                    }
                }
            }
            
            else if ($category !== "" && $name !== "") {
                $sql = "SELECT * FROM list WHERE id = $userList AND name LIKE '%$name%' AND list_cat_id = $category";
                $res = mysqli_query($connection, $sql);
                if (mysqli_num_rows($res) != 0) {
                    while ($row = mysqli_fetch_array($res)) {
                        $list[] = array(
                            "id" => $row['id'],
                            "name" => $row['name'],
                            "description" => $row['description'],
                            "max_price" => $row['max_price'],
                            "total_price" => $row['total_price'],
                            "user_id" => $row['user_id'],
                            "list_cat_id" => $row['list_cat_id']
                        );
                    }
                }
            }
        }
    }

    $connection->close();
    echo json_encode($list);
}
?>
